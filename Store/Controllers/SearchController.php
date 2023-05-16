<?php

namespace Store\Controllers;

use \Store\Entities\UAdPost;
use \Store\Containers\ImgsContainer;
use \Store\Containers\MetaContainer;
use \Store\Containers\Registration\ProfilesContainer;
use \Store\Containers\Registration\UsersContainer;
use \Store\Containers\Registration\UAdPostsContainer;

class SearchController extends \Store\Middleware\Controller {
	public function search_page() {
		$condition_map = [
			"any" => 0,
			"new" => 1,
			"used" => 2,
		];

		$sorting_params_map = [
			"by_date" => [
				"field" => "create_at",
				"type" => "DESC",
				"name" => "По дате добавления"
			],
			"by_price_up" => [
				"field" => "single_price",
				"type" => "ASC",
				"name" => "По возрастанию цены"
			],
			"by_price_down" => [
				"field" => "single_price",
				"type" => "DESC",
				"name" => "По спаданию цены"
			],
		];

		$s = mb_strtolower(trim( isset($_GET["s"]) ? $_GET["s"] : "" ));
		$filter_price_from = abs(intval(isset($_GET["price_from"]) ? $_GET["price_from"] : 0));
		$filter_price_to = abs(intval(isset($_GET["price_to"]) ? $_GET["price_to"] : PHP_INT_MAX));
		if($filter_price_to == 0) {
			$filter_price_to = PHP_INT_MAX;
		}
		$condition = (!isset($_GET["condition"]) or !isset($condition_map[$_GET["condition"]])) ? "any" : $_GET["condition"];
		$condition = $condition_map[$condition];
		$exchange_flag = !isset($_GET["exchange_flag"]) ? "off" : $_GET["exchange_flag"];
		$exchange_flag = $exchange_flag == "on" ? 1 : 0;
		$radius = !isset($_GET["radius"]) ? 400 : abs(intval($_GET["radius"]));
		$sorting = (!isset($_GET["sorting"]) or !in_array($_GET["sorting"], array_keys($sorting_params_map)))
			? "by_date" 
			: $_GET["sorting"]; 

		$per_page = FCONF["uadposts_per_page"];

		$filters = [ 
			"price" => [
				"from" => $filter_price_from, 
				"to" => $filter_price_to
			],
			"condition" => $condition,
			"exchange_flag" => $exchange_flag,
		];

		if(app() -> sessions -> is_auth()) {
			$uprofile = app() -> sessions -> auth_user() -> profile();
			$filters["location_params"] = [ 
				"rad" => $radius,
				"lat" => $uprofile -> location_lat,
				"lng" => $uprofile -> location_lng,
			];
		}
		$filters = json_encode($filters);

		try {
			app() -> devtools -> timelog_start("search_query", "Request to search server");

			$resp = @file_get_contents(
				str_replace(
					[ "{{search_query}}", "{{filters}}", "{{sorting}}" ], 
					[ urlencode($s), $filters, $sorting ], 
					FCONF["services"]["keywords"]["search"]
				)
			);

			app() -> devtools -> timelog_end("search_query");

			if(!$resp) {
				throw new \Exception("Error of search service");
			}
			$raw_results = json_decode($resp, true);
		} catch(\Exception $e) {
			// TODO: Make normal displaying of error
			echo $e -> getMessage();
		}

		$raw_results = $raw_results["result"]["uaps"];
		$where = [
			["id", "IN", $raw_results],
		];

		$uadposts_rows = app() -> thin_builder -> select(
			UAdPost::$table_name, 
			UAdPost::get_fields(), 
			$where, 
			[$sorting_params_map[$sorting]["field"] ?? "id"],
			$sorting_params_map[$sorting]["type"] ?? "DESC",
			app() -> utils -> get_limits_for_select_query( $per_page )
		);

		$uadposts = [];
		foreach($uadposts_rows as $row){
			$uadposts[] = new UAdPost($row["id"], $row);
		}

		app() -> factory -> initer() -> init_uadposts_group_favorite_state( $uadposts );
		UAdPostsContainer::fill();
		UsersContainer::fill();
		ProfilesContainer::fill();
		ImgsContainer::fill();
		MetaContainer::fill();

		$total_uadposts = app() -> thin_builder -> count( UAdPost::$table_name, $where );

		return $this -> new_template() -> make("site/search", [
			"page_title" => $s ? "Поиск: {$s}" : "Поиск | Store",
			"page_alias" => "page search",
			"uadposts" => $uadposts,
			"per_page" => $per_page,
			"total_uadposts" => $total_uadposts,
			"search_query" => $s,
			"sorting" => $sorting,
			"sorting_variants" => array_map(
				fn($val, $text) => [ "value" => $val, "text" => $text ],
				array_keys($sorting_params_map), 
				array_map(fn($item) => $item["name"], $sorting_params_map)
			),
			"location_country" => app() -> sessions -> is_auth() 
				? app() -> sessions -> auth_user() -> profile() -> country_en 
				: null,
			"location_city" => app() -> sessions -> is_auth() 
				? app() -> sessions -> auth_user() -> profile() -> city_en 
				: null,
		]);
	}

	public function alt_search_page() {
		$s = mb_strtolower(trim( isset($_GET["s"]) ? $_GET["s"] : "" ));
		$per_page = FCONF["uadposts_per_page"];

		$flipped_s = app() -> utils -> lang_mistake_flip($s);

		$words_orig = explode(" ", $s);
		$words_flipped = explode(" ", $flipped_s);

		function arr_diff($arr1, $arr2) {
			foreach($arr1 as $i => $item1) {
				if($item1 != $arr2[$i]) {
					return false;
				}
			}

			return true;
		}

		function get_variants($words) {
			$variants = [ $words ];

			$i = 0;
			while($i < 10000) {
				shuffle($words);
				$f = true;
				foreach($variants as $variant) {
					if(arr_diff($variant, $words)) {
						$f = false;
						break;
					}
				}

				if($f) {
					$variants[] = $words;
				}

				$i++;
			}

			return $variants;
		}

		$search_query = array_map(
			fn($v) => ["title", "LIKE", "%" . implode("%", $v) . "%"], 
			[ ...get_variants($words_orig), ...get_variants($words_flipped) ]
		);

		$where_query = [];
		foreach($search_query as $i => $query) {
			if($i) {
				$where_query[] = "OR";
			}

			$where_query[] = $query;
		}

		$where = [ 
			["state", "=", "published"], 
			"AND", 
			"(",
			...$where_query,
			")"
		];

		$uadposts_rows = app() -> thin_builder -> select(
			UAdPost::$table_name, 
			UAdPost::get_fields(), 
			$where, 
			["id"], 
			"DESC",
			app() -> utils -> get_limits_for_select_query( $per_page )
		);

		$uadposts = [];
		foreach($uadposts_rows as $row){
			$uadposts[] = new UAdPost($row["id"], $row);
		}

		// app() -> factory -> initer() -> init_group_users( $uadposts );
		app() -> factory -> initer() -> init_uadposts_group_favorite_state( $uadposts );
		$authors = array_map( fn($uadp) => $uadp -> user(), $uadposts );
		// app() -> factory -> initer() -> init_group_profiles_for_users( $authors );

		$total_uadposts = app() -> thin_builder -> count( UAdPost::$table_name, $where );

		return $this -> new_template() -> make("site/search", [
			"page_title" => "Search page | Store",
			"page_alias" => "page search",
			"uadposts" => $uadposts,
			"per_page" => $per_page,
			"total_uadposts" => $total_uadposts,
			"search_query" => $s
		]);
	}
}
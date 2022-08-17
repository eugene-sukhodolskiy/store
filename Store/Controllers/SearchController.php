<?php

namespace Store\Controllers;

use \Store\Entities\UAdPost;

class SearchController extends \Store\Middleware\Controller {
	public function search_page() {
		$s = mb_strtolower(trim($_GET["s"]));
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
			app() -> utils -> get_limits_for_select_query($per_page)
		);

		$uadposts = [];
		foreach($uadposts_rows as $row){
			$uadposts[] = new UAdPost($row["id"], $row);
		}

		app() -> factory -> initer() -> init_group_users($uadposts);
		$authors = array_map(fn($uadp) => $uadp -> user(), $uadposts);
		app() -> factory -> initer() -> init_group_profiles_for_users($authors);

		$total_uadposts = app() -> thin_builder -> count(UAdPost::$table_name, $where);

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
<?php

namespace Store\Controllers;

use \Store\Entities\UAdPost;

class SearchController extends \Store\Middleware\Controller {
	public function search_page() {
		$s = trim($_GET["s"]);
		$per_page = FCONF["uadposts_per_page"];

		$uadposts_rows = app() -> thin_builder -> select(
			UAdPost::$table_name, 
			UAdPost::get_fields(), 
			[ 
				["state", "=", "published"], 
				"AND", 
				"(", ["title", "LIKE", "%{$s}%"], "OR", ["content", "LIKE", "%{$s}%"], ")" 
			], 
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

		$total_uadposts = app() -> thin_builder -> count(UAdPost::$table_name);

		return $this -> new_template() -> make("site/search", [
			"page_title" => "Search page | Store",
			"page_alias" => "page search",
			"uadposts" => $uadposts,
			"per_page" => $per_page,
			"total_uadposts" => $total_uadposts
		]);
	}
}
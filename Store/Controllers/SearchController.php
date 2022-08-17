<?php

namespace Store\Controllers;

use \Store\Entities\UAdPost;

class SearchController extends \Store\Middleware\Controller {
	public function search_page() {
		$uadposts_rows = app() -> thin_builder -> select(
			UAdPost::$table_name, 
			UAdPost::get_fields(), 
			[ ["state", "=", "published"] ], 
			["id"], 
			"DESC",
			[0, 20]
		);
		
		$uadposts = [];
		foreach($uadposts_rows as $row){
			$uadposts[] = new UAdPost($row["id"], $row);
		}

		app() -> factory -> initer() -> init_group_users($uadposts);
		$authors = array_map(fn($uadp) => $uadp -> user(), $uadposts);
		app() -> factory -> initer() -> init_group_profiles_for_users($authors);

		return $this -> new_template() -> make("site/search", [
			"page_title" => "Search page | Store",
			"page_alias" => "page search",
			"uadposts" => $uadposts
		]);
	}
}
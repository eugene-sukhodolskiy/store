<?php

namespace Store\Controllers;

class SearchController extends \Store\Middleware\Controller {
	public function search_page() {
		$uadposts_ids = app() -> thin_builder -> select("uadposts", ["id"], [ ["state", "=", "published"] ]);
		$uadposts = [];
		foreach($uadposts_ids as $uadpost_id_item){
			$uadposts[] = new \Store\Entities\UAdPost($uadpost_id_item["id"]);
		}

		return $this -> new_template() -> make("site/search", [
			"page_title" => "Search page | Store",
			"page_alias" => "page search",
			"uadposts" => $uadposts
		]);
	}
}
<?php

namespace Store\Templates\Logic;

class Paginator extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		if(!isset($data["id"])){
			throw new \Exception("For component `paginator` need string var `id`");
		}

		if(!isset($data["total"])){
			$data["total"] = 0;
		}

		if(!isset($data["per_page"])){
			throw new \Exception("For component `paginator` need integer var `per_page`");
		}

		$data["current_page_num"] = isset($_GET["pn"]) ? intval($_GET["pn"]) : 1;
		$data["total_pages"] = ceil($data["total"] / $data["per_page"]);
		
		$data["displaying"] = $data["total_pages"] > 1;
		$data["btn_next_displaying"] = $data["current_page_num"] != $data["total_pages"];
		$data["btn_prev_displaying"] = $data["current_page_num"] > 1;

		if(isset($_GET["pn"])) {
			unset($_GET["pn"]);
		}

		$prev_page = $data["current_page_num"] - 1;
		$next_page = $data["current_page_num"] + 1;

		$data["prev_page_link"] = count($_GET) 
			? app() -> router -> uri . "?" . http_build_query(array_merge($_GET, ["pn" => $prev_page]))
			: app() -> router -> uri . "?pn=" . $prev_page;

		$data["next_page_link"] = count($_GET) 
			? app() -> router -> uri . "?" . http_build_query(array_merge($_GET, ["pn" => $next_page]))
			: app() -> router -> uri . "?pn=" . $next_page;

		$data["current_url"] = count($_GET) 
			? app() -> router -> uri . "?" . http_build_query($_GET)
			: app() -> router -> uri;

		return $data;
	}
}
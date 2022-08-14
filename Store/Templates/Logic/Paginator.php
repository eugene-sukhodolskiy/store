<?php

namespace Store\Templates\Logic;

class Paginator extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		if(!isset($this -> inside_data["id"])){
			// TODO: normalize error displaying
			dd("For component `paginator` need string var `id`");
		}

		if(!isset($this -> inside_data["total"])){
			$this -> inside_data["total"] = 0;
		}

		if(!isset($this -> inside_data["per_page"])){
			// TODO: normalize error displaying
			dd("For component `paginator` need integer var `per_page`");
		}

		$this -> inside_data["current_page_num"] = isset($_GET["pn"]) ? intval($_GET["pn"]) : 1;
		$this -> inside_data["total_pages"] = ceil($this -> inside_data["total"] / $this -> inside_data["per_page"]);
		
		$this -> inside_data["displaying"] = $this -> inside_data["total_pages"] > 1;
		$this -> inside_data["btn_next_displaying"] = $this -> inside_data["current_page_num"] != $this -> inside_data["total_pages"];
		$this -> inside_data["btn_prev_displaying"] = $this -> inside_data["current_page_num"] > 1;

		if(isset($_GET["pn"])) {
			unset($_GET["pn"]);
		}

		$prev_page = $this -> inside_data["current_page_num"] - 1;
		$next_page = $this -> inside_data["current_page_num"] + 1;

		$this -> inside_data["prev_page_link"] = count($_GET) 
			? app() -> router -> uri . "?" . http_build_query(array_merge($_GET, ["pn" => $prev_page]))
			: app() -> router -> uri . "?pn=" . $prev_page;

		$this -> inside_data["next_page_link"] = count($_GET) 
			? app() -> router -> uri . "?" . http_build_query(array_merge($_GET, ["pn" => $next_page]))
			: app() -> router -> uri . "?pn=" . $next_page;

		$this -> inside_data["current_url"] = count($_GET) 
			? app() -> router -> uri . "?" . http_build_query($_GET)
			: app() -> router -> uri;
	}
}
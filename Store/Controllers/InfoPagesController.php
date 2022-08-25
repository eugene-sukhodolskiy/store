<?php

namespace Store\Controllers;

class InfoPagesController extends \Store\Middleware\Controller {
	public function not_found_page() {
		return $this -> new_template() -> make("site/404.php", [
			"page_title" => "Запрашиваемая страница не найдена",
			"page_alias" => "page not-found-page",
		]);
	}
}
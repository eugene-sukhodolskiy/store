<?php

namespace Store\Controllers;

class UAdPost extends \Store\Middleware\Controller {
	public function create_page() {
		return $this -> new_template() -> make('site/create.uadpost', [
			'page_title' => 'Новое объявление',
			'page_alias' => 'page create-uadpost'
		]);
	}
}
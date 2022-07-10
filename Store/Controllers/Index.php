<?php

namespace Store\Controllers;

class Index extends \Store\Middleware\Controller{
	public function index(){
		return $this -> new_template() -> make('site/index', [
			'page_title' => 'Store',
			'page_alias' => 'index'
		]);
	}
}
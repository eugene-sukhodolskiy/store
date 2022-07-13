<?php

namespace Store\Controllers;

class Auth extends \Store\Middleware\Controller {
	public function signup_page() {
		return $this -> new_template() -> make('site/signup', [
			'page_title' => 'Регистрация',
			'page_alias' => 'signup'
		]);
	}

	public function signin() {

	}

	public function signout() {

	}
}
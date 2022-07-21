<?php

namespace Store\Controllers;

use \Store\Models\AuthModel;
use \Store\Entities\User;

class Auth extends \Store\Middleware\Controller {
	public function signup_page() {
		// TODO: check user on already login in sys
		return $this -> new_template() -> make('site/signup', [
			'page_title' => 'Регистрация',
			'page_alias' => 'page signup'
		]);
	}

	public function signin_page() {
		// TODO: check user on already login in sys
		return $this -> new_template() -> make('site/signin', [
			'page_title' => 'Войти в систему',
			'page_alias' => 'page signin'
		]);
	}

	public function signup($email, $password, $password_again) {
		// TODO: check user on already login in sys
		// TODO: generate event
		$email = strtolower(trim(strip_tags(addslashes($email)))); 
		$password = addslashes($password);
		$password_again = addslashes($password_again);

		if(strlen($email) < 4 or !strpos($email, "@") or !strpos($email, ".")) {
			return $this -> utils() -> response_error("incorrect_email", [ "email" ]);
		}

		if(strlen($password) < 8) {
			return $this -> utils() -> response_error("too_short_password", [ "password" ]);
		}

		if($password != $password_again) {
			return $this -> utils() -> response_error("different_passwords", [ "password", "password_again" ]);
		}

		if(User::is_exists_by("email", $email)) {
			return $this -> utils() -> response_error("email_already_exists", [ "email" ]);
		}

		$auth = new AuthModel();
		$user = $auth -> signup($email, $password);

		if(!$user) {
			return $this -> utils() -> response_error("undefined_error", [ "email" ]);
		}

		return $this -> utils() -> response_success();
	}

	public function signin($email, $password) {
		// TODO: check user on already login in sys
		// TODO: generate event
		$email = strtolower(trim(strip_tags(addslashes($email))));
		$password = addslashes($password);

		if(!strlen($email)) {
			return $this -> utils() -> response_error("empty_field", [ "email" ]);
		}

		if(!strlen($password)) {
			return $this -> utils() -> response_error("empty_field", [ "password" ]);
		}

		if(!User::is_exists_by("email", $email)) {
			return $this -> utils() -> response_error("unregistered_email", [ "email" ]);
		}

		$auth = new AuthModel();
		$token = $auth -> signin($email, $password);

		if(!$token){
			return $this -> utils() -> response_error("incorrect_password", [ "password" ]);
		}
	
		return $this -> utils() -> response_success([ "token" => $token ]);
	}

	public function signout() {
		
	}
}
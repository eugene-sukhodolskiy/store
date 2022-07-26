<?php

namespace Store\Controllers;

use \Store\Models\AuthModel;
use \Store\Entities\User;

class Auth extends \Store\Middleware\Controller {
	public function signup_page() {
		if(app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("Index@index") );
		}
		
		return $this -> new_template() -> make('site/signup', [
			'page_title' => 'Регистрация',
			'page_alias' => 'page signup'
		]);
	}

	public function signin_page() {
		if(app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("Index@index") );
		}

		return $this -> new_template() -> make('site/signin', [
			'page_title' => 'Войти в систему',
			'page_alias' => 'page signin'
		]);
	}

	public function signout_page() {
		$auth = new AuthModel();
		$auth -> signout();
		return $this -> utils() -> redirect( app() -> routes -> urlto("Auth@signin_page") );
	}

	public function signup($email, $password, $password_again) {
		// TODO: generate event

		if(app() -> sessions -> is_auth()){
			return $this -> utils() -> response_error("already_logged");
		}

		$email = strtolower(trim(strip_tags($email))); 

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

		return $this -> utils() -> response_success([
			"redirect_url" => app() -> routes -> urlto("Auth@signin_page"), 
			"redirect_delay" => 250
		]);
	}

	public function signin($email, $password) {
		// TODO: generate event
		if(app() -> sessions -> is_auth()){
			return $this -> utils() -> response_error("already_logged");
		}

		$email = strtolower(trim(strip_tags($email)));

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
	
		return $this -> utils() -> response_success([ 
			"token" => $token,
			"redirect_url" => "/", 
			"redirect_delay" => 250
		]);
	}

	public function signout() {
		if(!app() -> sessions -> is_auth()){
			return $this -> utils() -> response_error("not_found_any_sessions");
		}

		$auth = new AuthModel();
		$auth -> signout();
		return $this -> utils() -> response_success();
	}
}
<?php

namespace Store\Models;

use \Store\Entities\User;
use \Store\Entities\Profile;

class Auth extends \Store\Middleware\Model {
	public function signup(String $email, String $password) {
		$user = app() -> creator -> create_user(
			app() -> utils -> gen_alias_from_email($email), 
			$email, 
			$password
		);

		if($user) {
			$profile = app() -> creator -> create_profile($user -> id());
		}

		return $user;
	}

	public function signin(String $email, String $password) {
		$password = sha1($password);
		$user = app() -> factory -> get_user_by("email", $email);

		if(!$user or $user -> get("password") != $password) {
			return false;
		}

		return app() -> sessions -> init_session($user -> id());
	}

	public function signout() {
		return app() -> sessions -> close_current_session();
	}

	public function remove_session(Int $uid) {
		
	}
}
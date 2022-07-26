<?php

namespace Store\Models;

use \Store\Entities\User;

class AuthModel extends \Store\Middleware\Model {
	public function signup(String $email, String $password) {
		return User::create_new_user(
			app() -> utils -> gen_alias_from_email($email), 
			$email, 
			$password
		);
	}

	public function signin(String $email, String $password) {
		$password = sha1($password);
		$user = User::get_user_by_email($email);

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
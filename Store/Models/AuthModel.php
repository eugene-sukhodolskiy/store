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
}
<?php

namespace Store;

use \Store\Entities\Profile;
use \Store\Entities\User;

class Creator {
	public function create_user(String $alias, String $email, String $password) {
		$password_hash = sha1($password);

		$uid = app() -> thin_builder -> insert(User::$table_name, [
			"alias" => $alias,
			"email" => $email,
			"password" => $password_hash,
			"create_at" => date("Y-m-d H:i:s")
		]);

		if(!$uid){
			return false;
		}

		return new User($uid);
	}

	public function create_profile(Int $uid) {
		$profile_id = app() -> thin_builder -> insert(Profile::$table_name, [
			"uid" => $uid,
			"create_at" => date("Y-m-d H:i:s")
		]);

		return new Profile($profile_id);
	}
}
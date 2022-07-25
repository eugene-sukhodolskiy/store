<?php

namespace Store\Entities;

class User extends \Store\Middleware\Entity {
	public static $tablename = "users";

	public function __construct(Int $uid, Array $data = []) {
		parent::__construct(self::$tablename, $uid, [
			"id", "alias", "status", "role", "email", "password", "create_at", "update_at"
		], $data);
	}	

	// Static methods

	public static function create_new_user(String $alias, String $email, String $password) {
		$password_hash = sha1($password);

		$uid = app() -> thin_builder -> insert(self::$tablename, [
			'alias' => $alias,
			'email' => $email,
			'password' => $password_hash
		]);

		if(!$uid){
			return false;
		}

		return new User($uid);
	}

	public static function is_exists_by(String $field_name, String $field_value) {
		return app() -> utils -> table_row_is_exists(
			app() -> thin_builder,
			self::$tablename,
			$field_name,
			$field_value
		);
	}

	public static function get_user_by_email(String $email) {
		$result_data = app() -> thin_builder -> select(
			self::$tablename, 
			["id"], 
			[ ["email", "=", $email] ], 
			["id"], 
			"DESC", 
			[0, 1]
		);

		if(!$result_data) {
			return false;
		}

		return new User($result_data[0]["id"]);
	}
}
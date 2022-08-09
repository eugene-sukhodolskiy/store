<?php

namespace Store\Entities;

class User extends \Store\Middleware\Entity {
	public static $table_name = "users";
	protected $profile_instance;

	public function __construct(Int $uid, Array $data = []) {
		parent::__construct(self::$table_name, $uid, [
			"id", "alias", "status", "role", "email", "password", "create_at", "update_at"
		], $data);
	}	

	public function profile() {
		if(!$this -> profile_instance) {
			$this -> profile_instance = app() -> factory -> get_profile_by("uid", $this -> id());
		}
		
		return $this -> profile_instance;
	}

	// Static methods

	public static function is_exists_by(String $field_name, String $field_value) {
		return app() -> utils -> table_row_is_exists(
			app() -> thin_builder,
			self::$table_name,
			$field_name,
			$field_value
		);
	}
}
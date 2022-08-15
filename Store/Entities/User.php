<?php

namespace Store\Entities;

class User extends \Store\Middleware\Entity {
	public static $table_name = "users";
	protected static $fields = [
		"id", "alias", "status", "role", "email", "password", "create_at", "update_at"
	];
	
	protected $profile_instance;

	public function __construct(Int $uid, Array $data = []) {
		parent::__construct(self::$table_name, $uid, $data);
	}	

	public function profile() {
		if(!$this -> profile_instance) {
			$this -> profile_instance = app() -> factory -> getter() -> get_profile_by("uid", $this -> id());
		}
		
		return $this -> profile_instance;
	}

	public function get_last_uadpost() {
		$posts = app() -> factory -> getter() -> get_uadposts_by("uid", $this -> id(), 1);
		return $posts ? $posts[0] : false;
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
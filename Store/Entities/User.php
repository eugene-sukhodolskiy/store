<?php

namespace Store\Entities;

use \Store\Entities\Session;

class User extends \Store\Middleware\Entity {
	public static $table_name = "users";
	protected static $fields = [
		"id", "alias", "status", "role", "email", "password", "create_at", "update_at"
	];
	
	public function __construct(Int $uid, Array $data = []) {
		parent::__construct(self::$table_name, $uid, $data);
	}	

	public function profile() {
		return $this -> get_pet_instance("Profile", function() {
			return app() -> factory -> getter() -> get_profile_by("uid", $this -> id());
		});
	}

	public function get_last_uadpost() {
		$posts = app() -> factory -> getter() -> get_uadposts_by("uid", $this -> id(), 1);
		return $posts ? $posts[0] : false;
	}

	public function last_session() {
		return $this -> get_pet_instance("Session", function() {
			return app() -> factory -> getter() -> get_session_by("uid", $this -> id());
		});
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
<?php

namespace Store;

use \Store\Entities\User;
use \Store\Entities\Profile;

class Factory {
	public function get_user_by(String $field_name, $field_value) {
		// TODO: find normal method
		$result = app() -> thin_builder -> select(
			User::$table_name, ["id"], [ [$field_name, "=", $field_value] ]
		);

		if(!$result) {
			return null;
		}

		return new User($result[0]["id"]);
	}

	public function get_profile_by(String $field_name, $field_value) {
		// TODO: find normal method
		$result = app() -> thin_builder -> select(
			Profile::$table_name, ["id"], [ [$field_name, "=", $field_value] ]
		);

		if(!$result) {
			return null;
		}

		return new Profile($result[0]["id"]);
	}
}
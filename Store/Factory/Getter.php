<?php

namespace Store\Factory;

use \Store\Entities\User;
use \Store\Entities\Profile;

class Getter {
	public function get_user_by(String $field_name, $field_value) {
		$result = app() -> thin_builder -> select(
			User::$table_name, User::get_fields(), [ [$field_name, "=", $field_value] ]
		);

		if(!$result) {
			return null;
		}

		return new User($result[0]["id"], $result[0]);
	}

	public function get_profile_by(String $field_name, $field_value) {
		$result = app() -> thin_builder -> select(
			Profile::$table_name, Profile::get_fields(), [ [$field_name, "=", $field_value] ]
		);

		if(!$result) {
			return null;
		}

		return new Profile($result[0]["id"], $result[0]);
	}

	public function get_images_by_entity(Int $ent_id, String $assignment) {
		$result = app() -> thin_builder -> select(
			Image::$table_name, Image::get_fields(), [ 
				["ent_id", "=", $ent_id], "AND", ["assignment", "=", $assignment] 
			]
		);

		if(!$result) {
			return null;
		}

		$images = [];
		foreach($result as $item) {
			$images[] = new Image($item["id"], $item);
		}

		return $images;
	}
}
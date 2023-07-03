<?php

namespace Store\Factory;

use \Store\Entities\User;
use \Store\Entities\Profile;
use \Store\Entities\Image;
use \Store\Entities\UAdPost;
use \Store\Entities\Session;
use \Store\Entities\Meta;
use \Store\Entities\Order;
use \Store\Containers\Registration\UAdPostsContainer;

class Getter {
	public function get_user_by(String $field_name, $field_value): ?User {
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
			Profile::$table_name, 
			["id"], 
			[ [$field_name, "=", $field_value] ],
			[], "",
			[0, 1]
		);

		if(!$result) {
			return null;
		}

		return new Profile($result[0]["id"]);
	}

	public function get_images_by_entity(Int $ent_id, String $assignment, Int $amount = 10) {
		$result = app() -> thin_builder -> select(
			Image::$table_name, 
			[], 
			[ ["ent_id", "=", $ent_id], "AND", ["assignment", "=", $assignment] ],
			[ "sequence" ],
			"ASC",
			[0, $amount]
		);

		if(!$result) {
			return [];
		}

		$images = [];
		foreach($result as $item) {
			$images[] = new Image($item["id"], $item);
		}

		return $images;
	}

	public function get_uadposts_by(String $field_name, $field_value, Int $amount = 10): Array {
		$result = app() -> thin_builder -> select(
			UAdPost::$table_name, 
			["id"], 
			[[ $field_name, is_array($field_value) ? "IN" : "=", $field_value ]],
			[ "id" ],
			"DESC",
			[0, $amount]
		);

		if(!$result) {
			return [];
		}

		$uadposts = [];
		foreach($result as $item) {
			$uadposts[] = new UAdPost($item["id"]);
		}

		UAdPostsContainer::fill();

		return $uadposts;
	}

	public function get_session_by(String $field_name, $field_value): ?Session {
		$result = app() -> thin_builder -> select(
			Session::$table_name,
			Session::get_fields(),
			[[$field_name, "=", $field_value]],
			["last_using_at"],
			"DESC",
			[0, 1]
		);

		if(!$result) {
			return null;
		}

		return new Session(intval($result[0]["id"]), $result[0]);
	}

	public function get_meta(Int $ent_id, String $assignment, Int $amount = 10): Array {
		$result = app() -> thin_builder -> select(
			Meta::$table_name,
			Meta::get_fields(),
			[ ["ent_id", "=", $ent_id], "AND", ["assignment", "=", $assignment] ],
			[],
			"",
			[0, $amount]
		);

		if(!$result) {
			return [];
		}

		$meta = [];
		foreach($result as $item) {
			$meta[] = new Meta($item["id"], $item);
		}

		return $meta;
	}

	public function get_orders_by(String $field_name, $field_value, Int $amount = 10) : Array {
		$result = app() -> thin_builder -> select(
			Order::$table_name, 
			Order::get_fields(), 
			[ 
				[ $field_name, is_array($field_value) ? "IN" : "=", $field_value ]
			],
			[ "id" ],
			"DESC",
			[0, $amount]
		);

		if(!$result) {
			return [];
		}

		$orders = [];
		foreach($result as $item) {
			$orders[] = new Order($item["id"], $item);
		}

		return $orders;
	}
}
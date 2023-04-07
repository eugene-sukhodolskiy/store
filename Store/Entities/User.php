<?php

namespace Store\Entities;

use \Store\Entities\Session;
use \Store\Wrappers\UserStatistics;
use \Store\Models\UAdPosts;
use \Store\Models\Favourites;
use \Store\Models\Orders;

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

	public function statistics() {
		return $this -> get_pet_instance("UserStatistics", function() {
			return new UserStatistics($this -> id(), "User");
		});
	}

	public function get_last_uadpost() {
		$posts = app() -> factory -> getter() -> get_uadposts_by("uid", $this -> id(), 1);
		return count($posts) ? $posts[0] : false;
	}

	public function total_uadposts(String $state = "published") {
		return (new UAdPosts()) -> total_by_user($this -> id(), $state);
	}

	public function get_uadposts(String $state = "published", Int $page_num = 1) {
		$uadposts = (new UAdPosts()) -> get_by_user(
			$this -> id(), 
			$state, 
			FCONF["profile_uadposts_per_page"], 
			$page_num,
			"update_at"
		);

		app() -> factory -> initer() -> init_uadposts_group_favorite_state( $uadposts );

		return $uadposts;
	}

	public function last_session() {
		return $this -> get_pet_instance("Session", function() {
			return app() -> factory -> getter() -> get_session_by("uid", $this -> id());
		});
	}

	public function total_favourites_uadposts() {
		return (new Favourites()) -> total_by_user( $this -> id(), "UAdPost" );
	}

	public function get_orders(String $utype, Int $page_num = 1): Array {
		$sorting_cases = [
			"unconfirmed",
			"confirmed",
			"canceled",
			"completed",
		];
		$order_by = "CASE ";
		foreach($sorting_cases as $i => $case) {
			$then = $i + 1;
			$order_by .= "WHEN `state`='{$case}' THEN {$then} ";
		}
		$order_by .= " ELSE " . (count($sorting_cases) + 1) . " END";
		$order_by .= ", `create_at`";

		$orders_model = new Orders();
		$orders = $orders_model -> get_by_user(
			$utype, 
			$this -> id, FCONF["user_orders_per_page"], 
			$page_num, 
			$order_by
		);
		return $orders;
	}

	public function total_orders(String $utype, String $state = "*"): Int {
		return (new Orders()) -> total_by_user($utype, $this -> id, $state);
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
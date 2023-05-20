<?php

namespace Store\Entities;

use \Store\Entities\Session;
use \Store\Containers\UserStatistics;
use \Store\Containers\Registration\UsersContainer;
use \Store\Containers\Registration\UAdPostsContainer;
use \Store\Models\UAdPosts;
use \Store\Models\Favourites;
use \Store\Models\Orders;
use \Store\Entities\Profile;

class User extends \Store\Middleware\Entity {
	public static $table_name = "users";
	protected static $fields = [
		"id", "alias", "status", "role", "email", "password", "create_at", "update_at"
	];
	protected UserStatistics $statistics;
	protected Profile $profile;
	
	public function __construct(Int $uid, Array $data = []) {
		parent::__construct(self::$table_name, $uid, $data);
		$this -> statistics = new UserStatistics($uid);
		// TODO: `uid` - is fail, need `profile_id`
		$this -> profile = new Profile($uid);
		UsersContainer::add_entity_item($this);
	}	

	public function profile(): Profile {
		return $this -> profile;
	}

	public function statistics(): UserStatistics {
		return $this -> statistics;
	}

	public function get_last_uadpost(): ?UAdPost {
		$posts = app() -> factory -> getter() -> get_uadposts_by("uid", $this -> id(), 1);
		return count($posts) ? $posts[0] : null;
	}

	public function total_uadposts(String $state = "published"): Int {
		return (new UAdPosts()) -> total_by_user($this -> id(), $state);
	}

	public function get_uadposts(String $state = "published", Int $page_num = 1): Array {
		$uadposts = (new UAdPosts()) -> get_by_user(
			$this -> id(), 
			$state, 
			FCONF["profile_uadposts_per_page"], 
			$page_num,
			"update_at"
		);

		UAdPostsContainer::fill();

		return $uadposts;
	}

	public function last_session(): ?\Store\Entities\Session {
		return $this -> get_pet_instance("Session", function() {
			return app() -> factory -> getter() -> get_session_by("uid", $this -> id());
		});
	}

	public function total_favourites_uadposts(): Int {
		return (new Favourites()) -> total_by_user( $this -> id(), "UAdPost" );
	}

	public function get_orders(String $utype, Int $page_num = 1, Array $including_states = []): Array {
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
			$order_by,
			"DESC",
			$including_states
		);
		return $orders;
	}

	public function total_orders(String $utype, Array $including_states = []): Int {
		return (new Orders()) -> total_by_user($utype, $this -> id, $including_states);
	}

	public function role_is(String $role_name): Bool {
		return $this -> role == $role_name;
	}

	// Static methods

	public static function is_exists_by(String $field_name, String $field_value): Bool {
		return app() -> utils -> table_row_is_exists(
			app() -> thin_builder,
			self::$table_name,
			$field_name,
			$field_value
		);
	}
}
<?php

namespace Store\Factory;

use \Store\Entities\Profile;
use \Store\Entities\User;
use \Store\Entities\Image;
use \Store\Models\Favourites;

class Initer {
	public function init_group_profiles_for_uadposts_users(Array $uadposts) {
		$count_uadposts = count($uadposts);

		$ids = array_map(fn($uap) => $uap -> user() -> id(), $uadposts);

		$rows = app() -> thin_builder -> select(
			Profile::$table_name, 
			Profile::get_fields(), 
			[ ["uid", "IN", $ids] ],
			[], "",
			[0, $count_uadposts]
		);

		if(!$rows) {
			return null;
		}

		foreach($rows as $row) {
			foreach($uadposts as $uadpost) {
				if($uadpost -> user() -> id() == $row["id"]) {
					$uadpost -> user() -> forward_instance_init("Profile", new Profile($row["id"], $row));
					break;
				}
			}
		}

		return $uadposts;
	}

	public function init_group_users(Array $entities) {
		$count_entities = count($entities);

		$uids = array_map(fn($entity) => $entity -> uid, $entities);

		$rows = app() -> thin_builder -> select(
			User::$table_name, 
			User::get_fields(), 
			[ ["id", "IN", $uids] ],
			[], "",
			[0, $count_entities]
		);

		if(!$rows) {
			return null;
		}

		foreach($rows as $row) {
			foreach($entities as $entity) {
				if($entity -> id() == $row["id"]) {
					$entity -> forward_instance_init("User", new User($row["id"], $row));
					break;
				}
			}
		}

		return $entities;
	}

	public function init_uadposts_group_favorite_state(Array $uadposts): void {
		if(count($uadposts)) {
			(new Favourites()) -> assignment_group_is_favorite("UAdPost", $uadposts);
		}
	}

	public function init_group_profiles_for_users(Array $users) {
		$count_users = count($users);

		$ids = array_map(fn($user) => $user -> id(), $users);

		$rows = app() -> thin_builder -> select(
			Profile::$table_name, 
			Profile::get_fields(), 
			[ ["uid", "IN", $ids] ],
			[], "",
			[0, $count_users]
		);

		if(!$rows) {
			return null;
		}

		foreach($rows as $row) {
			foreach($users as $user) {
				if($user -> id() == $row["id"]) {
					$user -> forward_instance_init("Profile", new Profile($row["id"], $row));
					break;
				}
			}
		}

		return $users;
	}
}
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

	public function init_uadposts_group_images(Array $uadposts): Array {
		$count_uadposts = count($uadposts);

		$ids = array_map(fn($uap) => $uap -> id(), $uadposts);

		$rows = app() -> thin_builder -> select(
			Image::$table_name, 
			Image::get_fields(), 
			[ ["ent_id", "IN", $ids], "AND", ["assignment", "=", "UAdPost"] ],
			[], "",
			[0, $count_uadposts]
		);

		foreach($uadposts as $uap) {
			$uap -> exists_imgs = false;
		}

		foreach($rows as $row) {
			foreach($uadposts as $uap) {
				if($uap -> id() == $row["ent_id"]) {
					$uap -> imgs[] = new Image($row["id"], $row);
					$uap -> exists_imgs = true;
					break;
				}
			}
		}

		return $uadposts;
	}

	public function init_uadposts_group_favorite_state(Array $uadposts): void {
		if(count($uadposts)) {
			(new Favourites()) -> assignment_group_is_favorite("UAdPost", $uadposts);
		}
	}

	public function init_uadposts_profiles_group_images(Array $uadposts): Array {
		$count_entities = count($uadposts);
		if(!$count_entities) {
			return [];
		}

		$profiles_ids = array_map(fn($uap) => $uap -> user() -> profile() -> id(), $uadposts);
		$rows = app() -> thin_builder -> select(
			Image::$table_name, 
			Image::get_fields(), 
			[ ["ent_id", "IN", $profiles_ids], "AND", ["assignment", "=", "Profile"] ],
			[], "",
			[0, $count_entities]
		);

		foreach($uadposts as $uap) {
			$uap -> user() -> profile() -> exists_imgs = false;
		}

		foreach($rows as $row) {
			foreach($uadposts as $uap) {
				if($uap -> user() -> profile() -> id() == $row["ent_id"]) {
					$uap -> user() -> profile() -> imgs[] = new Image($row["id"], $row);
					$uap -> user() -> profile() -> exists_imgs = true;
					break;
				}
			}
		}

		return $uadposts;
	}
}
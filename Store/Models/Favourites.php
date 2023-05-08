<?php

namespace Store\Models;

use \Store\Entities\Favorite;
use \Store\Entities\UAdPost;

class Favourites extends \Store\Middleware\Model {
	public function create(Int $uid, Int $ent_id, String $assignment): ?Favorite {
		$data = [
			"uid" => $uid,
			"ent_id" => $ent_id,
			"assignment" => $assignment,
			"create_at" => date("Y-m-d H:i:s")
		];

		$id = $this -> thin_builder() -> insert(
			Favorite::$table_name,
			$data
		);

		if(!$id) {
			return null;
		}

		if($assignment == "UAdPost") {
			(new UAdPost($ent_id)) -> statistics() -> in_favorites_increase();
		}

		return new Favorite($id, array_merge(
			[ 
				"id" => $id, 
				"update_at" => $data["create_at"] 
			],
			$data
		));
	}

	public function get_by(Int $uid, String $assignment, Int $pn = 1): Array {
		$limit = [ 
			($pn - 1) * FCONF["favourites_uadposts_per_page"],
			FCONF["favourites_uadposts_per_page"]
		];

		$result = $this -> thin_builder() -> select(
			Favorite::$table_name,
			Favorite::get_fields(),
			[
				[ "uid", "=", $uid ],
				"AND",
				[ "assignment", "=", $assignment ]
			],
			[ "id" ],
			"DESC",
			$limit
		);

		if(!$result) {
			return [];
		}

		return array_map( fn($item) => new Favorite($item["id"], $item), $result );
	}

	public function remove_by(Int $uid, Int $ent_id, String $assignment): Bool {
		$favs = $this -> thin_builder() -> select(
			Favorite::$table_name,
			Favorite::get_fields(),
			[
				[ "uid", "=", $uid ],
				"AND",
				[ "ent_id", "=", $ent_id ],
				"AND",
				[ "assignment", "=", $assignment ],
			],
			[],
			"DESC",
			[0, 1]
		);

		if(!$favs or !count($favs)) {
			return false;
		}

		return (new Favorite($favs[0]["id"], $favs[0])) -> remove();
	}

	public function remove_for_assignment_unit(Int $ent_id, String $assignment): Bool {
		return $this -> thin_builder() -> delete(
			Favorite::$table_name,
			[
				[ "ent_id", "=", $ent_id ],
				"AND",
				[ "assignment", "=", $assignment ]
			]
		) ? true : false;
	}

	public function is_exists_by(Int $uid, Int $ent_id, String $assignment) {
		return $this -> thin_builder() -> count(
			Favorite::$table_name,
			[ 
				[ "uid", "=", $uid ],
				"AND",
				[ "ent_id", "=", $ent_id ],
				"AND",
				[ "assignment", "=", $assignment ]
			]
		) ? true : false;
	}

	public function assignment_group_is_favorite(String $assignment, Array $group): Array {
		$ids = array_map(
			fn($item) => $item -> id(),
			$group
		);

		if(app() -> sessions -> is_auth()) {
			$result = $this -> thin_builder() -> select(
				Favorite::$table_name,
				Favorite::get_fields(),
				[
					["uid", "=", app() -> sessions -> auth_user() -> id()],
					"AND",
					[ "assignment", "=", $assignment],
					"AND",
					[ "ent_id", "IN", $ids ]
				]
			);
		} else {
			$result = [];
		}


		foreach($group as $item) {
			$item -> set_favorite_state_for_current_user( false );
		}

		foreach($result as $val) {
			foreach($group as $item) {
				if( $item -> id() == $val["ent_id"] ) {
					$item -> set_favorite_state_for_current_user( true );
					continue;
				}
			}
		}

		return $group;
	}

	public function total_by_user(Int $uid, String $assignment): Int {
		return $this -> thin_builder() -> count(
			Favorite::$table_name,
			[
				[ "uid", "=", $uid ],
				"AND",
				[ "assignment", "=", $assignment ]
			]
		);
	}
}
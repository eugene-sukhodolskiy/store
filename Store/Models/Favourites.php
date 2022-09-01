<?php

namespace Store\Models;

use \Store\Entities\Favorite;

class Favourites extends \Store\Middleware\Model {
	public function create(Int $uid, Int $ent_id, String $assignment) {
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
			]
		);

		if(!$favs or !count($favs)) {
			return false;
		}

		$fav = $favs[0];

		return $fav -> remove();
	}

	public function remove_for_uadpost(Int $uadpost_id): Bool {
		
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
}
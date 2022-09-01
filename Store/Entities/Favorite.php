<?php

namespace Store\Entities;

use \Store\Entities\User;

class Favorite extends \Store\Middleware\Entity {
	public static $table_name = "favourites";
	protected static $fields = [
		"id", "uid", "ent_id", "assignment", 
		"create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}

	public function remove() {
		if(!$this -> remove_entity()) {
			return false;
		}

		// TODO: uadpost stats
		
		return true;
	}
}
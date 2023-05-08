<?php

namespace Store\Entities;

class Meta extends \Store\Middleware\Entity {
	public static $table_name = "meta";
	protected static $fields = [
		"id", "ent_id", "assignment", "name",
		"value", "create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}

	public function __toString() {
		return $this -> value . "";
	}

	public function remove() {
		$this -> remove_entity();
	}
}
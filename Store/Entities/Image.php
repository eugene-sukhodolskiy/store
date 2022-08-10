<?php

namespace Store\Entities;

class Image extends \Store\Middleware\Entity {
	public static $table_name = "images";
	protected static $fields = [
		"id", "uid", "ent_id", "assignment", 
		"alias", "sequence", "create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}
}
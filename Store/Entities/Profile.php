<?php

namespace Store\Entities;

class Profile extends \Store\Middleware\Entity {
	public static $table_name = "profiles"; 
	protected static $fields = [
		"id", "uid", "first_name", "second_name", "phone_number", "userpic", 
		"location_lat", "location_lng", "update_at", "create_at"
	];

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
	}	
}
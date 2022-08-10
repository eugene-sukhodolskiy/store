<?php

namespace Store\Entities;

class Session extends \Store\Middleware\Entity {
	public static $table_name = "sessions";
	protected static $fields = [
		"id", "uid", "state", "role", "token", 
		"last_using_at", "update_at", "create_at"
	];

	public function __construct(Int $uid, Array $data = []) {
		parent::__construct(self::$table_name, $uid, $data);
	}	
}
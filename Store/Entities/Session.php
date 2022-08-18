<?php

namespace Store\Entities;

class Session extends \Store\Middleware\Entity {
	public static $table_name = "sessions";
	protected static $fields = [
		"id", "uid", "state", "token", 
		"last_using_at", "update_at", "create_at"
	];

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
	}	

	public function get_last_activity():int {
		return (time() - strtotime($this -> last_using_at)) / 60;
	}
}
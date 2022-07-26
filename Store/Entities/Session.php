<?php

namespace Store\Entities;

class Session extends \Store\Middleware\Entity {
	public $table_name = "sessions";

	public function __construct(Int $uid, Array $data = []) {
		parent::__construct($this -> table_name, $uid, [
			"id", "uid", "state", "role", "token", "last_using_at", "update_at", "create_at"
		], $data);
	}	
}
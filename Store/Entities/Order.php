<?php

namespace Store\Entities;

class Order extends \Store\Middleware\Entity {
	public static $table_name = "orders";
	protected static $fields = [
		"id", "customer_id", "uap_id", "price",
		"currency", "comment", "delivery_method", 
		"delivery_id", "create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}
}
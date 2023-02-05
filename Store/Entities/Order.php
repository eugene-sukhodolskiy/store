<?php

namespace Store\Entities;

class Order extends \Store\Middleware\Entity {
	public static $table_name = "orders";
	protected static $fields = [
		"id", "customer_id", "uap_id", "price",
		"currency", "comment", "delivery_method", 
		"delivery_id", "create_at", "update_at"
	];

	protected $uadpost;

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}

	public function uadpost() {
		if(!$this -> uadpost) {
			$uadposts = app() -> factory -> getter() -> get_uadposts_by("id", $this -> uap_id, 1);
			$this -> uadpost = count($uadposts) ? $uadposts[0] : null;
			$this -> uadpost -> currency = $this -> currency;
			$this -> uadpost -> price = $this -> price;
		}

		return $this -> uadpost;
	}
}
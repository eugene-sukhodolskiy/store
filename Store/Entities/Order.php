<?php

namespace Store\Entities;

class Order extends \Store\Middleware\Entity {
	public static $table_name = "orders";
	protected static $fields = [
		"id", "seller_id", "customer_id", "uap_id", "price", 
		"state", "currency", "comment", "delivery_method", 
		"delivery_id", "create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}

	public function uadpost() {
		return $this -> get_pet_instance("UAdPost", function() {
			$uadposts = app() -> factory -> getter() -> get_uadposts_by("id", $this -> uap_id, 1);
			$uadpost = count($uadposts) ? $uadposts[0] : null;
			$uadpost -> currency = $this -> currency;
			$uadpost -> price = $this -> price;
			return $uadpost;
		});
	}

	public function get_formatted_create_at() {
		return app() -> utils -> formatted_timestamp($this -> create_at, true);
	}

	public function get_delivery_method_text_name() {
		$delivery_map = app() -> utils -> get_delivery_method_map();
		return isset($delivery_map[$this -> delivery_method]) ? $delivery_map[$this -> delivery_method] : "";
	}

	public function seller() {
		return $this -> get_pet_instance("Seller", function() {
			return app() -> factory -> getter() -> get_user_by("id", $this -> seller_id, 1);
		});
	}

	public function customer() {
		return $this -> get_pet_instance("Customer", function() {
			return app() -> factory -> getter() -> get_user_by("id", $this -> customer_id, 1);
		});
	}
}
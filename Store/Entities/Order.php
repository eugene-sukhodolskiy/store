<?php

namespace Store\Entities;

use \Store\Models\NovaPoshta;
use \Store\Containers\Registration\OrdersContainer;
use \Store\Entities\UAdPost;
use \Store\Entities\User;

class Order extends \Store\Middleware\Entity {
	public static $table_name = "orders";
	protected static $fields = [
		"id", "seller_id", "customer_id", "uap_id", "price", 
		"state", "currency", "single_price", "comment", "delivery_method", 
		"delivery_id", "create_at", "update_at"
	];

	protected UAdPost $uadpost;
	protected User $seller;
	protected User $customer;

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
		OrdersContainer::add_entity_item($this);
	}

	public function fill(Array $data = []) {
		parent::fill($data);
		$this -> uadpost = new UAdPost($this -> uap_id);
		$this -> seller = new User($this -> seller_id);
		$this -> customer = new User($this -> customer_id);
	}

	public function uadpost(): UAdPost {
		if(!$this -> was_filled()) {
			$this -> fill();
		}

		$this -> uadpost -> currency = $this -> currency;
		$this -> uadpost -> price = $this -> price;
		return $this -> uadpost;
	}

	public function get_formatted_create_at() {
		return app() -> utils -> formatted_timestamp($this -> create_at, true);
	}

	public function get_delivery_method_text_name() {
		$delivery_map = app() -> utils -> get_delivery_method_map();
		return isset($delivery_map[$this -> delivery_method]) ? $delivery_map[$this -> delivery_method] : "";
	}

	public function seller(): User {
		if(!$this -> was_filled()) {
			$this -> fill();
		}

		return $this -> seller;
	}

	public function customer(): User {
		if(!$this -> was_filled()) {
			$this -> fill();
		}

		return $this -> customer;
	}

	public function confirm() {
		$this -> state = "confirmed";
		return $this -> update();
	}

	public function cancel() {
		$this -> state = "canceled";
		return $this -> update();	
	}

	public function complete() {
		$this -> state = "completed";
		$this -> seller() -> statistics() -> total_saled_increase();
		$this -> uadpost() -> statistics() -> sales_increase();
		return $this -> update();	
	}

	public function remove() {
		$this -> remove_entity();
	}

	public function nova_poshta_delivery(): ?NPDelivery {
		if($this -> delivery_method !== "1") {
			return null;
		}

		return $this -> get_pet_instance(
			"NPDelivery", 
			fn() => (new NovaPoshta()) -> get_by_order_id($this -> id)
		);
	}
}
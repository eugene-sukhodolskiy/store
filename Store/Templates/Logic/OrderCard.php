<?php

namespace Store\Templates\Logic;

class OrderCard extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		if(!isset($data["order"])){
			throw new \Exception("For component `order-card` need Store\Entities\Order var `order`");
		}

		$order = $data["order"];
		$data["local_menu"] = [];

		if($order -> state == "unconfirmed" and app() -> sessions -> auth_user() -> id != $order -> customer_id) {
			$data["local_menu"][] = [ 
				"type" => "btn",
				"attribute" => "data-order-id=\"{$order -> id}\"",
				"class" => "order-cancel-btn",
				"content" => "<span class=\"mdi mdi-check-bold\"></span> Подтвердить"
			];
		}
		
		if($order -> state == "unconfirmed") {
			$data["local_menu"][] = [ 
				"type" => "btn",
				"attribute" => "data-order-id=\"{$order -> id}\"",
				"class" => "order-cancel-btn",
				"content" => "<span class=\"mdi mdi-cancel\"></span> Отменить"
			];
		} 

		$data["local_menu"][] = [
			"type" => "btn",
			"class" => "order-remove-btn",
			"attribute" => "data-order-id=\"{$order -> id}\"",
			"content" => "<span class=\"mdi mdi-delete-outline\"></span> Удалить"
		];		

		$data["customer_userpic_url"] = $order -> customer() -> profile() -> userpic_url("xs");
		$data["customer_username"] = $order -> customer() -> profile() -> first_name; 
		$data["phone_number"] = $data["mode"] == "seller" 
			? $order -> customer() -> profile() -> phone_number
			: $order -> seller() -> profile() -> phone_number;

		return $data;
	}
}
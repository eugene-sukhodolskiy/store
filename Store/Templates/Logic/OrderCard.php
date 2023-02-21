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
				"content" => "<span class=\"mdi mdi-check-bold\"></span> Принять"
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

		return $data;
	}
}
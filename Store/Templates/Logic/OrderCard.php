<?php

namespace Store\Templates\Logic;

class OrderCard extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		if(!isset($data["order"])){
			throw new \Exception("For component `order-card` need Store\Entities\Order var `order`");
		}

		if(!isset($data["utype"])){
			throw new \Exception("For component `order-card` need String var `utype`");
		}

		$data = $this -> profile_data_prepare($data);
		$data = $this -> local_menu_prepare($data);

		return $data;
	}

	protected function profile_data_prepare(Array $data): Array {
		$order = $data["order"];

		$data["customer_userpic_url"] = $order -> customer() -> profile() -> userpic_url("xs");
		$data["customer_username"] = $order -> customer() -> profile() -> first_name; 
		$data["phone_number"] = $data["utype"] == "seller" 
			? $order -> customer() -> profile() -> phone_number
			: $order -> seller() -> profile() -> phone_number;

		return $data;
	}

	protected function local_menu_prepare(Array $data): Array {
		$order = $data["order"];
		$utype = $data["utype"];

		$confirm_action = app() -> routes -> urlto("OrderController@confirm_order", [
			"order_id" => $order -> id
		]);
		
		$local_menu = [];

		if($order -> state == "unconfirmed" and app() -> sessions -> auth_user() -> id != $order -> customer_id) {
			$local_menu[] = [ 
				"type" => "btn",
				"attribute" => "data-order-confirm-action=\"{$confirm_action}\"",
				"class" => "order-confirm-btn",
				"content" => "<span class=\"mdi mdi-check-bold\"></span> Подтвердить"
			];
		}
		
		if($order -> state == "unconfirmed") {
			$local_menu[] = [ 
				"type" => "btn",
				"attribute" => "data-order-id=\"{$order -> id}\"",
				"class" => "order-cancel-btn",
				"content" => "<span class=\"mdi mdi-cancel\"></span> " 
					. ($utype == "seller" ? "Отклонить" : "Отменить") 
			];
		} 

		$local_menu[] = [
			"type" => "btn",
			"class" => "order-remove-btn",
			"attribute" => "data-order-id=\"{$order -> id}\"",
			"content" => "<span class=\"mdi mdi-delete-outline\"></span> Удалить"
		];

		$data["local_menu"] = $local_menu;

		return $data;
	}
}
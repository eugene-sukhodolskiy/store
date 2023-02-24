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

		$confirm_action = app() -> routes -> urlto("OrderController@change_order_state", [
			"order_id" => $order -> id,
			"state" => "confirm"
		]);

		$cancel_action = app() -> routes -> urlto("OrderController@change_order_state", [
			"order_id" => $order -> id,
			"state" => "cancel"
		]);

		$complete_action = app() -> routes -> urlto("OrderController@change_order_state", [
			"order_id" => $order -> id,
			"state" => "complete"
		]);
		
		$local_menu = [];

		if($order -> state == "unconfirmed" and app() -> sessions -> auth_user() -> id != $order -> customer_id) {
			$local_menu[] = [ 
				"type" => "btn",
				"attribute" => "data-order-action=\"{$confirm_action}\" data-order-btn-type=\"confirm\"",
				"class" => "order-confirm-btn",
				"content" => "<span class=\"mdi mdi-check-bold\"></span> Подтвердить"
			];
		}
		
		if($order -> state == "confirmed" and (time() - strtotime($order -> create_at)) > FCONF["orders"]["timeout_of_state_complete"]) {
			$local_menu[] = [ 
				"type" => "btn",
				"attribute" => "data-order-action=\"{$complete_action}\" data-order-btn-type=\"complete\"",
				"class" => "order-complete-btn",
				"content" => "<span class=\"mdi mdi-check-decagram\"></span> Заказ выполнен"
			];	
		}

		if($order -> state == "unconfirmed" or ($order -> state == "confirmed" and $utype == "seller")) {
			$local_menu[] = [ 
				"type" => "btn",
				"attribute" => "data-order-action=\"{$cancel_action}\" data-order-btn-type=\"cancel\"",
				"class" => "order-cancel-btn",
				"content" => "<span class=\"mdi mdi-cancel\"></span> " 
					. ($utype == "seller" && $order -> state == "unconfirmed" ? "Отклонить" : "Отменить") 
			];
		}


		$data["local_menu"] = $local_menu;

		return $data;
	}
}
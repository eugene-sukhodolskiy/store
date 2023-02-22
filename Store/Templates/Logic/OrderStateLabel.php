<?php

namespace Store\Templates\Logic;

class OrderStateLabel extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		if(!isset($data["order"])){
			throw new \Exception("For component `order-card` need Store\Entities\Order var `order`");
		}

		if(!isset($data["utype"])){
			throw new \Exception("For component `order-card` need String var `utype`");
		}

		$data = $this -> order_state_prepare($data);

		return $data;
	}

	protected function order_state_prepare(Array $data): Array {
		$order = $data["order"];
		$utype = $data["utype"];

		$label = [
			"type" => "warning",
			"icon" => "alert-circle-outline",
			"text" => "Статус заказа неизвестний"
		];

		switch($order -> state) {
			case "confirmed":
				$label["type"] = "success";
				$label["icon"] = "check-bold";
				$label["text"] = "Подтверждено" . ($utype == "customer" ? " продавцом" : "");
				break;
			case "unconfirmed":
				$label["type"] = "primary";
				$label["icon"] = "dots-horizontal";
				$label["text"] = "Ожидает подтверждения" . ($utype == "customer" ? " продавцом" : "");
				break;
			case "canceled":
				$label["type"] = "danger";
				$label["icon"] = "close-thick";
				$label["text"] = "Отменено";
				break;
		}

		$data["order_state_label"] = $label;

		return $data;
	}
}
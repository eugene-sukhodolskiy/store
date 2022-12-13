<?php

namespace Store\Models;

use \Store\Entities\UAdPost;
use \Store\Entities\Order;

class Orders extends \Store\Middleware\Model {

	// TODO: Maybe moving this to Factory/Creator
	public function create(Int $customer_id, Int $uap_id, Float $price, String $currency, String $comment, Int $delivery_method) {
		$data = [
			"customer_id" => $customer_id,
			"uap_id" => $uap_id,
			"price" => $price,
			"currency" => $currency,
			"comment" => $comment,
			"delivery_method" => $delivery_method,
			"delivery_id" => 0,
			"create_at" => date("Y-m-d H:i:s")
		];

		$order_id = $this -> thin_builder() -> insert(Order::$table_name, $data);
		return $order_id ? new Order($order_id) : null;
	}
}
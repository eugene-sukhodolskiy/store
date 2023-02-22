<?php

namespace Store\Models;

use \Store\Entities\UAdPost;
use \Store\Entities\Order;

class Orders extends \Store\Middleware\Model {

	// TODO: Maybe moving this to Factory/Creator
	public function create(Int $customer_id, Int $uap_id, Float $price, String $currency, String $comment, Int $delivery_method): ?Order {
		list($uadpost) = app() -> factory -> getter() -> get_uadposts_by("id", $uap_id, 1);

		$data = [
			"seller_id" => $uadpost -> uid,
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

	/**
	 * @param  String $utype saller or customer
	 * @param  Int    $uid       [description]
	 * @param  Int    $q         [description]
	 * @return [type]            [description]
	 */
	public function get_by_user(String $utype, Int $uid, Int $amount = 10, Int $page_num = 1, Array $order_by = [ "id" ]): Array {
		$orders = $this -> thin_builder() -> select(
			Order::$table_name,
			Order::get_fields(),
			[
				[ FCONF["utype_map"][$utype], "=", $uid ]
			],
			$order_by,
			"DESC",
			[ ($page_num - 1) * $amount, $amount ]
		);

		$orders = array_map(fn($item) => new Order($item["id"], $item), $orders);

		return $orders ? $orders : [];
	}

	public function total_by_user(String $utype, Int $uid): Int {
		$total = $this -> thin_builder() -> count(
			Order::$table_name, 
			[ FCONF["utype_map"][$utype], "=", $uid ]
		);

		return $total;
	}
}
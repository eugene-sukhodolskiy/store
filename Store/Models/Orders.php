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
	public function get_by_user(
		String $utype, 
		Int $uid, 
		Int $amount = 10, 
		Int $page_num = 1, 
		String $order_by = "id", 
		String $order_by_type = "DESC",
		Array $including_states = []
	): Array {
		$fields = implode("`,`", Order::get_fields());
		$tablename = Order::$table_name;
		$limit_from = ($page_num - 1) * $amount;
		$limit_amount = $amount;

		$utype = FCONF["utype_map"][$utype];
		if(!count($including_states)) {
			$including_states = FCONF["orders"]["existing_states"];
		}
		$including_states = implode("','", $including_states);
		$where = "WHERE `{$utype}`='{$uid}' AND `state` IN ('{$including_states}')";
		$q = "SELECT `{$fields}` FROM `{$tablename}` {$where} ORDER BY {$order_by} {$order_by_type} LIMIT {$limit_from},{$limit_amount}";

		$orders = $this -> thin_builder() -> query($q, 'fetchAll', \PDO::FETCH_ASSOC);
		$orders = array_map(fn($item) => new Order($item["id"], $item), $orders);

		return $orders ? $orders : [];
	}

	public function total_by_user(String $utype, Int $uid, Array $including_states = []): Int {
		$where = [ FCONF["utype_map"][$utype], "=", $uid ];
		if(!count($including_states)) {
			$including_states = FCONF["orders"]["existing_states"];
		}
		$where_part_state = [ "state", "IN", $including_states ];
		
		$total = $this -> thin_builder() -> count(
			Order::$table_name, 
			!count($where_part_state) 
				? $where
				: [ $where, "AND", $where_part_state ]
		);

		return $total;
	}
}
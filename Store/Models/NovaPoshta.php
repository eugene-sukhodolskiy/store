<?php

namespace Store\Models;

use \Store\Entities\Order;
use \Store\Entities\NPDelivery;

class NovaPoshta extends \Store\Middleware\Model {
	public function create(
		Int $order_id, 
		String $addr, 
		String $city_ref, 
		String $city_name, 
		String $np_department
	): ?NPDelivery {
		$np_delivery_id = $this -> thin_builder() -> insert(
			NPDelivery::$table_name, 
			compact("order_id", "addr", "city_name", "city_ref", "np_department")
		);
		return $np_delivery_id ? new NPDelivery($np_delivery_id) : null;
	}

	public function get_by_order_id(Int $order_id): ?NPDelivery {
		$result_data = $this -> thin_builder() -> select(NPDelivery::$table_name, [], ["order_id", "=", $order_id]);
		return count($result_data) ? new NPDelivery($result_data[0]["id"], $result_data[0]) : null;
	}
}
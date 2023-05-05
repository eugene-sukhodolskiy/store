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
}
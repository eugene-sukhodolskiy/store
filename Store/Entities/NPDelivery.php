<?php

namespace Store\Entities;

class NPDelivery extends \Store\Middleware\Entity {
	public static $table_name = "nova_poshta_delivery";
	protected static $fields = [
		"id", "order_id", "addr", "city_ref", "city_name", "np_department"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}

	
}
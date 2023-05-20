<?php

namespace Store\Containers\Registration;

use \Store\Entities\Order;

class OrdersContainer extends RegistrationContainer {
	protected static Array $entities = [];

	public static function fill(): Array {
		$no_filled = array_filter(self::$entities, fn($i) => !$i["entity"] -> was_filled());
		$count_entities = count($no_filled);
		$ids = array_map(fn($i) => $i["ent_id"], $no_filled);

		$rows = app() -> thin_builder -> select(
			Order::$table_name, 
			[], 
			[ ["id", "IN", $ids] ],
			[], "",
			[0, $count_entities]
		);

		if(!$rows) {
			return [];
		}

		$filled = [];

		foreach($no_filled as $item) {
			foreach($rows as $row) {
				if($item["ent_id"] == $row["id"]) {
					$item["entity"] -> fill($row);
					$filled[] = $item["entity"];
				}
			}
		}

		return $filled;
	}
}
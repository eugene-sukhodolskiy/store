<?php

namespace Store\Containers\Registration;

use \Store\Entities\User;

class UsersContainer extends RegistrationContainer {
	protected static Array $entities = [];
	
	public static function fill(): Array {
		$no_filled = self::get_no_filled_entities();

		$count_entities = count($no_filled);
		$ids = array_map(fn($i) => $i["ent_id"], $no_filled);

		$rows = app() -> thin_builder -> select(
			User::$table_name, 
			[], 
			[ ["id", "IN", $ids] ],
			[], "",
			[0, $count_entities]
		);

		if(!$rows) {
			return [];
		}

		$filled_users = [];

		foreach($no_filled as $item) {
			foreach($rows as $row) {
				if($item["ent_id"] == $row["id"]) {
					$item["entity"] -> fill($row);
					$filled_users[] = $item["entity"];
				}
			}
		}

		return $filled_users;
	}
}
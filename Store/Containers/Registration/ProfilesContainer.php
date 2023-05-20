<?php

namespace Store\Containers\Registration;

use \Store\Entities\Profile;

class ProfilesContainer extends RegistrationContainer {
	protected static Array $entities = [];
	
	public static function fill(): Array {
		$no_filled = self::get_no_filled_entities();
		$count_entities = count($no_filled);
		$ids = array_map(fn($i) => $i["ent_id"], $no_filled);

		$rows = app() -> thin_builder -> select(
			Profile::$table_name, 
			[], 
			[ ["uid", "IN", $ids] ],
			[], "",
			[0, $count_entities]
		);

		if(!$rows) {
			return [];
		}

		$filled_profiles = [];

		foreach($no_filled as $item) {
			foreach($rows as $row) {
				if($item["ent_id"] == $row["id"]) {
					$item["entity"] -> fill($row);
					$filled_profiles[] = $item["entity"];
				}
			}
		}

		return $filled_profiles;
	}
}
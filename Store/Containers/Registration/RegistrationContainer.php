<?php

namespace Store\Containers\Registration;

class RegistrationContainer {
	public static function add_entity_item(Mixed $entity): ?Array {
		if(!is_object($entity)) {
			throw new \Exception("Entity must be an object");
		}

		static::$entities[] = [
			"ent_id" => $entity -> id(),
			"entity" => $entity
		];

		return static::$entities[count(static::$entities) - 1];
	}

	public static function get_entities_map(): Array {
		return static::$entities;
	}

	public static function search_in_entities_map(Int $ent_id): ?Int {
		foreach(static::$entities as $inx => $entity_item) {
			if($entity_item["ent_id"] == $ent_id) {
				return $inx;
			}
		}

		return null;
	}

	public static function get_no_filled_entities(): Array {
		return array_filter(static::$entities, fn($i) => !$i["entity"] -> was_filled());
	}

	public function get_by_id(Int $ent_id): Mixed {
		$inx = self::search_in_entities_map($ent_id);

		if(is_null($inx)) {
			return null;
		}

		return self::entities[$inx];
	}
}
<?php

namespace Store\Containers;

use \Store\Entities\Meta;

class MetaContainer {
	use \Store\Helpers\GetSetImplementation;

	protected Int $ent_id;
	protected String $assignment;
	protected Bool $was_filled = false;
	protected static Array $containers = [];

	public function __construct(Int $ent_id, String $assignment) {
		$this -> ent_id = $ent_id;
		$this -> assignment = $assignment;

		if(!isset(self::$containers[$assignment])) {
			self::$containers[$assignment] = [];
		}

		self::$containers[$assignment][] = $this;
	}

	public function get(String $field_name) {
		if(!$this -> was_filled()) {
			$this -> fill_container();
		}

		if(in_array($field_name, static::$fields)) {
			if(!isset($this -> data[$field_name])) {
				$this -> create_field_if_not_exists();
			}
			return $this -> data[$field_name];
		}
		
		throw new \Exception("Error of getting MetaContainer property. Property `{$field_name}` not found");
	}

	protected function fill_container(): ?Array {
		if($this -> was_filled()) {
			return null;
		}

		$meta_items = app() -> factory -> getter() -> get_meta(
			$this -> ent_id, 
			$this -> assignment, 
			count(static::$fields_types)
		);

		foreach($meta_items as $item) {
			$this -> data[$item -> name] = $item;
		}

		$this -> was_filled = true;
		$this -> create_field_if_not_exists();

		return $this -> data;
	}

	protected function create_field_if_not_exists() {
		if(!$this -> was_filled()) {
			return;
		}

		foreach(static::$fields_types as $field => $type) {
			if(!isset($this -> data[$field])) {
				$this -> data[$field] = app() -> factory -> creator() -> create_meta(
					$this -> ent_id,
					$this -> assignment,
					$field, 
					app() -> utils -> get_default_val_for_type($type)
				);
			}
		}
	}

	public function update() {
		foreach($this -> data as $item) {
			$item -> update();
		}
	}

	public function total_items() {
		return count($this -> data);
	}

	public function clear_all_fields() {
		foreach ($this -> data as $item) {
			$item -> remove();
		}
	}

	public function was_filled() {
		return $this -> was_filled;
	}

	public function add_meta_item(String $field_name, Meta $meta) {
		$this -> data[$field_name] = $meta;
	}

	public static function fill(): Array {
		foreach (self::$containers as $name => $group) {
			$count_items = count($group) * 100;
			$ids = array_map(fn($container) => $container -> get_ent_id(), $group);
			
			$rows = app() -> thin_builder -> select(
				Meta::$table_name, 
				Meta::get_fields(), 
				[ ["ent_id", "IN", $ids], "AND", ["assignment", "=", $name] ],
				[], "",
				[0, $count_items]
			);
			
			foreach($group as $container) {
				foreach($rows as $row) {
					if($container -> get_ent_id() == $row["ent_id"]) {
						$container -> add_meta_item($row["name"], new Meta($row["id"], $row) );
					}
				}

				$container -> was_filled = true;
			}
		}

		return self::$containers;
	}

	public function get_ent_id(): Int {
		return $this -> ent_id;
	}

	public function get_assignment(): String {
		return $this -> assignment;
	}
}
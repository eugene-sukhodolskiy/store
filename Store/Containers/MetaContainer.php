<?php

namespace Store\Containers;

use \Store\Entities\Meta;

trait MetaContainer {
	use \Store\Helpers\GetSetImplementation;

	protected Int $ent_id;
	protected String $assignment;
	protected Int $total_meta_items = 0;

	public function __construct(Int $ent_id, String $assignment) {
		$this -> ent_id = $ent_id;
		$this -> assignment = $assignment;

		$this -> fill_container();
		$this -> create_field_if_not_exists();
	}

	protected function fill_container() {
		$meta_items = app() -> factory -> getter() -> get_meta(
			$this -> ent_id, 
			$this -> assignment, 
			count(static::$fields)
		);
		$this -> total_meta_items = count($meta_items);

		foreach($meta_items as $item) {
			$this -> data[$item -> name] = $item;
		}
	}

	protected function create_field_if_not_exists() {
		foreach(static::$fields as $field) {
			if(!isset($this -> data[$field])) {
				$this -> data[$field] = app() -> factory -> creator() -> create_meta(
					$this -> ent_id,
					$this -> assignment,
					$field, 
					app() -> utils -> get_default_val_for_type(static::$fields_types[$field])
				);

				$this -> total_meta_items++;
			}
		}
	}

	public function update() {
		foreach($this -> data as $item) {
			return $item -> update();
		}
	}

	public function total() {
		return $this -> total_meta_items;
	}
}
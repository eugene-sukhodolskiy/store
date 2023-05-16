<?php

namespace Store\Middleware;

class Entity {

	use \Store\Helpers\GetSetImplementation {
		get as parent_get;
	}
	use \Store\Helpers\PetInstancesImplementation;

	protected $entity_tablename;
	protected $entity_id;	
	protected $field_name_of_update_at = "update_at";
	protected $was_filled = false;

	public function __construct(String $entity_tablename, Int $entity_id, Array $data = []) {
		$this -> entity_tablename = $entity_tablename;
		$this -> entity_id = $entity_id;

		if(count($data)) {
			$this -> fill($data);
		}
	}

	public function fill(Array $data = []) {
		if(count($data)) {
			$this -> data = $data;
		} else {
			$this -> select_from_db();
		}

		$this -> was_filled = true;
	}

	protected function select_from_db() {
		list($this -> data) = $this -> thin_builder() -> select(
			$this -> entity_tablename, 
			[], 
			['id', '=', $this -> entity_id],
			['id'], 
			'DESC', 
			[0, 1]
		);
	}

	public function get(String $field_name): Mixed {
		if(!$this -> was_filled()) {
			$this -> fill();
		}

		return $this -> parent_get($field_name);
	}

	public function was_filled(): Bool {
		return $this -> was_filled;
	}
	
	public function thin_builder(): \Fury\Modules\ThinBuilder\ThinBuilder {
		return app() -> thin_builder;
	}

	public function id(): Int {
		return $this -> entity_id;
	}

	public function update(): Array|Bool {
		if(!count($this -> modified_fields)){
			return [];
		}

		$where = [ ["id", "=", $this -> entity_id] ];
		$this -> modified_fields[$this -> field_name_of_update_at] = date("Y-m-d H:i:s");

		if(!$this -> thin_builder() -> update($this -> entity_tablename, $this -> modified_fields, $where)) {
			return false;
		}

		$result = $this -> modified_fields;
		$this -> modified_fields = [];
		return $result;
	}

	public static function get_fields(): Array {
		return static::$fields;
	}

	protected function remove_entity() {
		return app() -> thin_builder -> delete(static::$table_name, [ "id", "=", $this -> id() ]);
	}
}
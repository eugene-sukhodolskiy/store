<?php

namespace Store\Middleware;

class Entity {
	protected $entity_tablename;
	protected $entity_id;
	protected $data;

	public function __construct(String $entity_tablename, Int $entity_id, Array $data = []) {
		$this -> entity_tablename = $entity_tablename;
		$this -> entity_id = $entity_id;
		$where = [
		  ['id', '=', $this -> entity_id]
		];
 		
		if(count($data)) {
			$this -> data = $data;
		} else {
			list($this -> data) = $this -> this_builder() -> select(
				$this -> entity_tablename, 
				[], 
				$where, 
				['id'], 
				'DESC', 
				[0, 1]
			);
		}
	}
	
	public function this_builder() {
		return app() -> thin_builder;
	}

	public function to_array() {
		return $this -> data;
	}

	public function id() {
		return $this -> entity_id;
	}

	public function get(String $field_name) {
		return $this -> data[$field_name];
	}

	public function set(String $field_name, $field_val) {
		$this -> data[$field_name] = $field_val;
	}

	public function update() {
		// ...
	}
}
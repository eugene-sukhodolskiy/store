<?php

namespace Store\Middleware;

class Entity {
	protected $entity_tablename;
	protected $entity_id;
	protected $data;
	protected $fields;
	protected $modified_fields = [];
	protected $field_name_of_update_at = "update_at";

	public function __construct(String $entity_tablename, Int $entity_id, Array $fields, Array $data = []) {
		$this -> entity_tablename = $entity_tablename;
		$this -> entity_id = $entity_id;
		$this -> fields = $fields;

		$where = [
		  ['id', '=', $this -> entity_id]
		];
 		
		if(count($data)) {
			$this -> data = $data;
		} else {
			list($this -> data) = $this -> thin_builder() -> select(
				$this -> entity_tablename, 
				[], 
				$where, 
				['id'], 
				'DESC', 
				[0, 1]
			);
		}
	}
	
	public function thin_builder() {
		return app() -> thin_builder;
	}

	public function to_array() {
		return $this -> data;
	}

	public function id() {
		return $this -> entity_id;
	}

	public function get(String $field_name) {
		// TODO: normalize displaying of error
		return in_array($field_name, $this -> fields) ? $this -> data[$field_name] : ddjson(["Error of GET, field `{$field_name}` not found", $this -> data, isset($this -> data[$field_name]) ]);
	}

	public function set(String $field_name, $field_val) {
		if(!in_array($field_name, $this -> fields)){
			// TODO: normalize displaying of error
			ddjson("Error of SET, field `{$field_name}` not found");
		}
	
		$this -> data[$field_name] = $field_val;
		$this -> modified_fields[$field_name] = $field_val;
		return $this;
	}

	public function update() {
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

	public function __get($field_name) {
		return $this -> get($field_name);
	}

	public function __set($field_name, $field_val) {
		return $this -> set($field_name, $field_val);
	}
}
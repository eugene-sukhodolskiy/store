<?php

namespace Store\Middleware;

class Entity {

	use \Store\Helpers\GetSetImplementation;

	protected $entity_tablename;
	protected $entity_id;
	protected $pet_instances = [];
	protected $field_name_of_update_at = "update_at";

	public function __construct(String $entity_tablename, Int $entity_id, Array $data = []) {
		$this -> entity_tablename = $entity_tablename;
		$this -> entity_id = $entity_id;

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

	public function id() {
		return $this -> entity_id;
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

	public static function get_fields() {
		return static::$fields;
	}

	public function get_pet_instance(String $instance_name, $callback) {
		if(!isset($this -> pet_instances[$instance_name])) {
			$this -> pet_instances[$instance_name] = $callback();
		}

		return $this -> pet_instances[$instance_name];
	}

	public function forward_instance_init(String $instance_name, $instance) {
		$this -> pet_instances[$instance_name] = $instance;
	}

	public function remove_entity() {
		return app() -> thin_builder -> delete(static::$table_name, [ "id", "=", $this -> id() ]);
	}
}
<?php

namespace Store\Helpers;

trait GetSetImplementation {

	protected Array $data = [];
	protected Array $modified_fields = [];

	public function to_array(): Array {
		return $this -> data;
	}

	public function get(String $field_name) {
		if(in_array($field_name, static::$fields)) {
			return $this -> data[$field_name] ;
		}
		
		throw new \Exception("Error of GET, field `{$field_name}` not found");
	}

	public function set(String $field_name, $field_val) {
		if(!in_array($field_name, static::$fields)){
			throw new \Exception("Error of SET, field `{$field_name}` not found");
		}
	
		$this -> data[$field_name] = $field_val;
		$this -> modified_fields[$field_name] = $field_val;
		return $this;
	}
	
	public function __get($field_name) {
		return $this -> get($field_name);
	}

	public function __set($field_name, $field_val) {
		return $this -> set($field_name, $field_val);
	}

}

<?php

namespace Store\Helpers;

trait PetInstancesImplementation {
	protected $pet_instances = [];

	public function get_pet_instance(String $instance_name, $callback) {
		if(!isset($this -> pet_instances[$instance_name])) {
			$this -> pet_instances[$instance_name] = $callback();
		}

		return $this -> pet_instances[$instance_name];
	}

	public function forward_instance_init(String $instance_name, $instance) {
		$this -> pet_instances[$instance_name] = $instance;
	}

	public function get_existing_pet_list() {
		return array_keys($this -> pet_instances);
	}
}

<?php

namespace Store\Factory;

class Factory {
	protected $creator_instance;
	protected $getter_instance;

	public function creator() {
		if(!$this -> creator_instance) {
			$this -> creator_instance = new Creator();
		}

		return $this -> creator_instance;
	}

	public function getter() {
		if(!$this -> getter_instance) {
			$this -> getter_instance = new Getter();
		}

		return $this -> getter_instance;	
	}
}
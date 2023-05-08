<?php

namespace Store\Wrappers; 

class UAdPostStatistics {
	use \Store\Containers\MetaContainer;

	protected static Array $fields = [
		"views", "in_favorites"
	];
	
	protected static Array $fields_types = [
		"views" => "Int", 
		"in_favorites" => "Int"
	];

	public function views_increase() {
		$this -> views_change(+1);
	}
	
	protected function views_change(Int $val) {
		$this -> views -> value += $val;
		$this -> views -> update();
	}

	public function in_favorites_increase() {
		$this -> in_favorites_change(+1);
	}

	public function in_favorites_decrease() {
		$this -> in_favorites_change(-1);
	}
	
	protected function in_favorites_change(Int $val) {
		$this -> in_favorites -> value += $val;
		$this -> in_favorites -> update();
	}
}
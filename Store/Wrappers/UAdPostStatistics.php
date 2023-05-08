<?php

namespace Store\Wrappers; 

class UAdPostStatistics {
	use \Store\Containers\MetaContainer;

	protected static Array $fields = [
		"views",
	];
	
	protected static Array $fields_types = [
		"views" => "Int",
	];

	public function views_increase() {
		$this -> views_change(+1);
	}
	
	protected function views_change(Int $val) {
		$this -> views -> value += $val;
		$this -> views -> update();
	}
}
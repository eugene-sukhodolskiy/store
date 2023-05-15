<?php

namespace Store\Containers; 

class UAdPostStatistics extends \Store\Containers\MetaContainer {
	protected static Array $fields = [];
	protected static Array $fields_types = [
		"views" => "Int", 
		"in_favorites" => "Int",
		"phone_views" => "Int",
		"sales" => "Int"
	];

	public function __construct(Int $ent_id) {
		self::$fields = array_keys(self::$fields_types);
		parent::__construct($ent_id, "UAdPost");
	}

	public function views_increase() {
		$this -> views -> value += 1;
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

	public function phone_views_increase() {
		$this -> phone_views -> value += 1;
		$this -> phone_views -> update();
	}

	public function sales_increase() {
		$this -> sales -> value += 1;
		$this -> sales -> update();
	}	
}
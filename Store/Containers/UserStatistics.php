<?php

namespace Store\Containers; 

class UserStatistics extends \Store\Containers\MetaContainer {
	protected static Array $fields = [];
	protected static Array $fields_types = [
		"total_published_uadposts" => "Int",
		"total_saled" => "Int"
	];

	public function __construct(Int $ent_id) {
		self::$fields = array_keys(self::$fields_types);
		parent::__construct($ent_id, "User");
	}

	public function total_published_uadposts_increase() {
		$this -> total_published_uadposts_change(+1);
	}

	public function total_published_uadposts_decrease() {
		$this -> total_published_uadposts_change(-1);
	}

	public function total_saled_increase() {
		$this -> total_saled_change(+1);
	}

	public function total_saled_decrease() {
		$this -> total_saled_change(-1);
	}
	
	protected function total_published_uadposts_change(Int $val) {
		$this -> total_published_uadposts -> value += $val;
		$this -> total_published_uadposts -> update();
	}

	protected function total_saled_change(Int $val) {
		$this -> total_saled -> value += $val;
		$this -> total_saled -> update();
	}
}
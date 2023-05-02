<?php

namespace Store\Wrappers; 

class UserStatistics {
	use \Store\Containers\MetaContainer;

	protected static Array $fields = [
		"total_published_uadposts",
		"total_saled"
	];
	
	protected static Array $fields_types = [
		"total_published_uadposts" => "Int",
		"total_saled" => "Int"
	];

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
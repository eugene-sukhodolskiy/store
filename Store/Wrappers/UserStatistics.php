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
		$this -> total_published_uadposts -> value += 1;
		$this -> total_published_uadposts -> update();
	}

	public function total_published_uadposts_decrease() {
		$this -> total_published_uadposts -> value -= 1;
		$this -> total_published_uadposts -> update();
	}
}
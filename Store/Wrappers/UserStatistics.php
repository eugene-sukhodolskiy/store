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
		"total_saled" => "Int",
	];
}
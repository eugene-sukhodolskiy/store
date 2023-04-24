<?php

return [
	"app_name" => "Store",
	"debug" => true,
	"default_db_wrap" => false,
	"db" => [
		"dblib" => "mysql",
		"host" => "localhost",
		"dbname" => "store",
		"charset" => "utf8",
		"user" => "eugene",
		"password" => "root"
	],
	"app_file" => "App.php",
	"templates_folder" => "Templates",
	"logs_enable" => true,
	"logs_folder" => "Store/Logs",

	"controllers_folder" => "Controllers",
	"text_msgs" => require_once("Store/text-msgs.php"),
	"users_folder" => "users_files",

	"image_resize_map" => [
		"original" => [3840, 80],
		"lg" => [900, 85],
		"md" => [600, 75],
		"sm" => [360, 70] ,
		"xs" => [150, 70] 
	],

	"error_handler" => [
		"important_errors" => ["E_WARNING", "E_ERROR", "E_CORE_ERROR", "EXCEPTION"]
	],

	// Items per page
	"uadposts_per_page" => 20,
	"profile_uadposts_per_page" => 10,
	"favourites_uadposts_per_page" => 10,
	"user_orders_per_page" => 20,

	"utype_map" => [ 
		"seller" => "seller_id", 
		"customer" => "customer_id" 
	],

	"orders" => [
		"timeout_of_state_complete" => 60 * 60 * 24, // 24 hours
		"existing_states" => [
			"confirmed", "canceled", "completed", "unconfirmed"
		] 
	],

	"uadposts" => [
		"max_keywords_number" => 30
	]
]; 
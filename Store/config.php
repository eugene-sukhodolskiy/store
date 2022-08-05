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
		"md" => [900, 85],
		"sm" => [400, 75],
		"xs" => [160, 75] 
	]
]; 
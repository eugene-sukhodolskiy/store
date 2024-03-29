<?php

include_once "Fury/fury.php";
$app = fury_init("Store");

use \Store\Helpers\Generator;

function console() {
	global $argv;

	switch($argv[1]) {
		case "generator.users": 
			(new Generator()) -> generate_random_users($argv[2]);
		break;
		case "generator.uadposts": 
			(new Generator()) -> generate_random_uadpost($argv[2]);
		break;
		case "create.uadpost":
			(new Generator()) -> generate_uadpost_from_json($argv[2]);
		break;
		case "get.config":
			echo json_encode(FCONF);
		break;
		default: echo "\nNo command";
	}

	echo "\n";
}

console();
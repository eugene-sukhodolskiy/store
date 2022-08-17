<?php

namespace Store\Helpers;

use \Store\Models\Auth;
use \Fury\Libs\LoremIpsum;

class Generator {
	protected $lorem_ipsum;

	public function __construct() {
		$this -> lorem_ipsum = new LoremIpsum();
	}

	public function generate_random_users(Int $amount = 10) {
		for($i = 0; $i < $amount; $i++) {
			$email = $this -> lorem_ipsum -> get_email();
			$password = "1111";
			$user = (new Auth()) -> signup($email, $password);
			$user -> profile() -> first_name = $this -> lorem_ipsum -> get_name();
			$user -> profile() -> second_name = $this -> lorem_ipsum -> get_surname();
			$user -> profile() -> phone_number = $this -> lorem_ipsum -> get_phone_number();
			$user -> profile() -> location_lat = rand(400000, 600000) / 10000;
			$user -> profile() -> location_lng = rand(220000, 300000) / 10000;
			$user -> profile() -> update();
			echo "\n#{$i} {$user -> profile() -> first_name} {$email} {$password}";
		}

		echo "\nDone";
	}

	public function generate_random_uadpost(Int $amount = 10) {
		for($i = 0; $i < $amount; $i++) {
			$rand_user = app() -> factory -> getter() -> get_user_by("id", rand(1, 9999));
			$title = $this -> lorem_ipsum -> gen_paragraph(1);

			$uadpost = app() -> factory -> creator() -> create_uadpost(
				$rand_user -> id(), 
				$title, 
				"<p>" . implode("</p><p>", $this -> lorem_ipsum -> gen_paragraphs(rand(1, 8), 1, 20)) . "</p>", 
				rand(1, 2), 
				rand(0, 1), 
				rand(0, 10000), 
				"UAH", 
				rand(400000, 600000) / 10000, 
				rand(220000, 300000) / 10000, 
				"Ukraine", 
				"Украина", 
				"TestRegion", 
				"ТестРегион", 
				"TestCity", 
				"ТестГород", 
				0
			);

			echo "\n#{$i} {$title}";
		}

		echo "\nDone";
	}
}
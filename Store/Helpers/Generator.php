<?php

namespace Store\Helpers;

use \Store\Models\Auth;
use \Fury\Libs\LoremIpsum;
use \Store\Models\Images;
use \Store\Utils;

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

	public function generate_uadpost_from_json($json_data) {
		$uadpost_data = json_decode($json_data);
		
		$rand_user = app() -> factory -> getter() -> get_user_by("id", rand(1, 9999));
		
		$images = new Images();
		if($uadpost_data -> image and strlen($uadpost_data -> image)) {
			echo "Upload image " . $uadpost_data -> image . "\n";
			$img = @file_get_contents($uadpost_data -> image);
			if($img) {
				$img = (new Utils()) -> convert_png_to_jpg($img);
				$img = "data:image/jpeg;base64," . base64_encode($img);
				$img_upload_result = $images -> upload($img);
			}
		}

		echo "Creating UAdPost\n";
		$uadpost = app() -> factory -> creator() -> create_uadpost(
			$rand_user -> id(), 
			$uadpost_data -> title, 
			$uadpost_data -> description, 
			rand(1, 2), 
			rand(0, 1), 
			$uadpost_data -> price, 
			$uadpost_data -> currency, 
			rand(400000, 600000) / 10000, 
			rand(220000, 300000) / 10000, 
			"Ukraine", 
			"Украина", 
			"TestRegion", 
			"ТестРегион", 
			"TestCity", 
			"ТестГород", 
			$img_upload_result ? 1 : 0
		);

		if($uadpost and $img_upload_result) {
			$images -> create_from_aliases(
				[ $img_upload_result["alias"] ],
				$uadpost,
				$rand_user -> id()
			);
		}

		echo "Was created \n";
	}
}
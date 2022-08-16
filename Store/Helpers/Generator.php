<?php

namespace Store\Helpers;

use \Store\Models\Auth;

class Generator {
	public function __construct() {

	}

	public function generate_random_users(Int $amount = 10) {
		for($i = 0; $i < $amount; $i++) {
			$email = $this -> gen_email();
			$password = "1111";
			(new Auth()) -> signup($email, $password);
			echo "\n#{$i} {$email} {$password}";
		}

		echo "\nDone";
	}

	protected function gen_email() {
		return $this -> gen_word(14, "en") . "@gmail.com";
	}

	protected function gen_word(Int $len = 5, String $lang = "en") {
		$letters = [
			"ru" => "йцукенгшщзхъфывапролджэячсмитьбюё",
			"en" => "qwertyuiopasdfghjklzxcvbnm"
		];

		$letters_total = [
			"ru" => strlen($letters["ru"]),
			"en" => strlen($letters["en"]),
		];

		$word = "";
		for($i = 0; $i < $len; $i++) {
			$word .= $letters[$lang][rand(0, $letters_total[$lang])];
		}

		return $word;
	}
}
<?php

namespace Store\Models;

use \Store\Entities\UAdPost;

class Keywords extends \Store\Middleware\Model {
	public function create_keywords_by_content(String $content, Int $uap_id): Array {
		$result = $this -> generate_keywords_by_content($content);
		foreach($result["keys"] as $keyword) {
			$this -> thin_builder() -> insert(
				"uadposts_keywords",
				[
					"uap_id" => $uap_id, 
					"keyword" => $keyword[0], 
					"freq" => $keyword[1]
				]
			);
		}

		return $result;
	}

	public function generate_keywords_by_content(String $content): Array {
		$content = str_replace(
			[",", ".", ";", "-", "[", "]", "!", "?", "*", "~", "(", ")", "=", "&", "^", "$", "#", "@", "_"],
			"",
			$content
		);
		$number = FCONF["uadposts"]["max_keywords_number"];
		$encoded_content = urlencode($content);
		$resp = file_get_contents("http://127.0.0.1:5000/?text={$encoded_content}&number={$number}");

		if($resp) {
			$result = json_decode($resp, true);
		}

		return $result;
	}
}
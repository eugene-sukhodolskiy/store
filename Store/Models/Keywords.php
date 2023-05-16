<?php

namespace Store\Models;

use \Store\Entities\UAdPost;
use \Store\Containers\KeywordsContainer;

class Keywords extends \Store\Middleware\Model {
	public function create_keywords_by_content(String $content, Int $uap_id): Array {
		$result = $this -> generate_keywords_by_content($content);
		foreach($result["keys"] as $keyword) {
			$this -> thin_builder() -> insert(
				"uadposts_keywords",
				[
					"uap_id" => $uap_id, 
					"keyword" => $keyword
				]
			);
		}

		return $result;
	}

	public function generate_keywords_by_content(String $content): Array {
		$content = str_replace(
			mb_str_split("!~@#%^&*()-_+[]{}:;'\"\\/<>,.?=|”"),
			"",
			$content
		);
		$number = FCONF["uadposts"]["max_keywords_number"];
		$encoded_content = urlencode($content);

		$service_url = str_replace(
			[ "{{text}}", "{{number}}" ],
			[ $encoded_content, $number ], 
			FCONF["services"]["keywords"]["gen_keywords"]
		);

		$resp = file_get_contents($service_url);

		if($resp) {
			$result = json_decode($resp, true);
		}

		return $result;
	}

	public function remove_keywords_by_uap_id(Int $uap_id): Bool {
		return $this -> thin_builder() -> delete(
			"uadposts_keywords",
			["uap_id", "=", $uap_id]
		);
	}

	public function get_keywords_by_uap_id(Int $uap_id): KeywordsContainer {
		$keywords = $this -> thin_builder() -> select(
			"uadposts_keywords",
			["uap_id", "=", $uap_id]
		);

		return new KeywordsContainer($keywords);
	}
}
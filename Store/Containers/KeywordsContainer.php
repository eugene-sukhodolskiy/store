<?php
namespace Store\Containers;

use \Store\Entities\UAdPost;

class KeywordsContainer {
	use \Store\Helpers\PetInstancesImplementation;
	protected $keywords = [];

	public function __construct(Array $keywords) {
		$this -> keywords = $keywords;
	}

	protected function not_belonged_to_single_uadpost(Array $keywords): Array {
		return array_filter($keywords, function($keyword) {
			return $keyword["uap_id"] != $this -> belong_to_uadpost_id();
		});
	}

	public function uadpost(): UAdPost {
		return $this -> get_pet_instance("UAdPost", function() {
			return app() -> factory -> getter() -> get_uadpost_by("id", $this -> belong_to_uadpost_id);
		});
	}

	public function belong_to_uadpost_id(): Int {
		return $this -> keywords[0]["uap_id"];
	}
}
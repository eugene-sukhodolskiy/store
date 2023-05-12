<?php

namespace Store\Entities;

class Profile extends \Store\Middleware\Entity {
	public static $table_name = "profiles"; 
	protected static $fields = [
		"id", "uid", "first_name", "second_name", "phone_number", "patronymic",
		"location_lat", "location_lng", "country_en", "country_ru", "region_en", 
		"region_ru", "city_ru", "city_en", "update_at", "create_at"
	];

	public $imgs = [];
	public $exists_imgs = true;

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
	}	

	public function userpic() {
		if($this -> exists_imgs) {
			$this -> imgs = app() -> factory -> getter() -> get_images_by_entity($this -> id(), "Profile", 1);
		}

		if(!$this -> imgs) {
			$this -> exists_imgs = false;
		}

		return $this -> imgs ? $this -> imgs[0] : false;
	}

	public function userpic_url(String $size) {
		$userpic = $this -> userpic();
		return $userpic 
			? $userpic -> get_url($size) 
			: "/Store/Resources/img/default-avatar-img.png";
	}
}
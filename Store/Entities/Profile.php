<?php

namespace Store\Entities;
use \Store\Containers\ImgsContainer;

class Profile extends \Store\Middleware\Entity {
	public static $table_name = "profiles"; 
	protected static $fields = [
		"id", "uid", "first_name", "second_name", "phone_number", "patronymic",
		"location_lat", "location_lng", "country_en", "country_ru", "region_en", 
		"region_ru", "city_ru", "city_en", "update_at", "create_at"
	];

	protected $imgs_container = null;

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
		$this -> imgs_container = new ImgsContainer($id, "Profile");
	}	

	public function userpic(): ?Image {
		return $this -> imgs_container -> get_first_img();
	}

	public function userpic_url(String $size) {
		$userpic = $this -> userpic();
		return $userpic 
			? $userpic -> get_url($size) 
			: "/Store/Resources/img/default-avatar-img.png";
	}
}
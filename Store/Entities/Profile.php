<?php

namespace Store\Entities;

class Profile extends \Store\Middleware\Entity {
	public static $table_name = "profiles"; 
	protected static $fields = [
		"id", "uid", "first_name", "second_name", "phone_number",
		"location_lat", "location_lng", "update_at", "create_at"
	];

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
	}	

	public function userpic() {
		$imgs = app() -> factory -> getter() -> get_images_by_entity($this -> id(), "Profile", 1);
		return $imgs ? $imgs[0] : false;
	}

	public function userpic_url(String $size) {
		$userpic = $this -> userpic();
		return $userpic 
			? $userpic -> get_url($size) 
			: "/Store/Resources/img/default-avatar-img.png";
	}
}
<?php

namespace Store\Templates\Logic;

class ProfileSettings extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$user = app() -> sessions -> auth_user();
		$this -> inside_data["user"] = $user;

		$userpic = $user -> profile() -> userpic();
		$this -> inside_data["images"] = $userpic ? [ $userpic ] : [];

		// $location = [
		// 	"lat" => $user -> profile() -> location_lat,
		// 	"lng" => $user -> profile() -> location_lng,
		// ];

		// $last_uadpost = $user -> get_last_uadpost();
		// if($last_uadpost) {
		// 	$location = array_merge($location, [
		// 		"country_ru" => $last_uadpost -> country_ru,
		// 		"country_en" => $last_uadpost -> country_en,
		// 		"city_ru" => $last_uadpost -> city_ru,
		// 		"city_en" => $last_uadpost -> city_en,
		// 		"region_ru" => $last_uadpost -> region_ru,
		// 		"region_en" => $last_uadpost -> region_en
		// 	]);
		// }

		// $this -> inside_data["location"] = $location;
	}
}
<?php

namespace Store\Templates\Logic;

class UAdPostForm extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> inside_data["first_name"] = "";
		$this -> inside_data["second_name"] = "";
		$this -> inside_data["phone_number"] = "";
		$this -> inside_data["has_posts"] = false;

		if(app() -> sessions -> is_auth()) {
			$this -> inside_data["first_name"] = app() -> sessions -> auth_user() -> profile() -> first_name;
			$this -> inside_data["second_name"] = app() -> sessions -> auth_user() -> profile() -> second_name;
			$this -> inside_data["phone_number"] = app() -> sessions -> auth_user() -> profile() -> phone_number;
			$last_uadpost = app() -> sessions -> auth_user() -> get_last_uadpost();
			// dd($last_uadpost);
			if($last_uadpost) {
				$this -> inside_data["has_posts"] = true;
				$this -> inside_data["lat"] = $last_uadpost -> location_lat;
				$this -> inside_data["lng"] = $last_uadpost -> location_lng;
				$this -> inside_data["country_ru"] = $last_uadpost -> country_ru;
				$this -> inside_data["country_en"] = $last_uadpost -> country_en;
				$this -> inside_data["city_ru"] = $last_uadpost -> city_ru;
				$this -> inside_data["city_en"] = $last_uadpost -> city_en;
				$this -> inside_data["region_ru"] = $last_uadpost -> region_ru;
				$this -> inside_data["region_en"] = $last_uadpost -> region_en;
			}
		}
	}
}
<?php

namespace Store\Templates\Logic;

class UAdPostForm extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$data["first_name"] = "";
		$data["second_name"] = "";
		$data["phone_number"] = "";
		$data["has_posts"] = false;
		$data["condition_used"] = 2;
		$data["price"] = 0;
		$data["images"] = [];
		$data["cancel_url"] = "/";
		if(!isset($data["edit_mode"])){
			$data["edit_mode"] = false;
		}

		if(app() -> sessions -> is_auth()) {
			$data["first_name"] = app() -> sessions -> auth_user() -> profile() -> first_name;
			$data["second_name"] = app() -> sessions -> auth_user() -> profile() -> second_name;
			$data["patronymic"] = app() -> sessions -> auth_user() -> profile() -> patronymic;
			$data["phone_number"] = app() -> sessions -> auth_user() -> profile() -> phone_number;
			$uadpost = (isset($data["uadpost"]) and $data["uadpost"])
				? $data["uadpost"]
				: app() -> sessions -> auth_user() -> get_last_uadpost();

			if(isset($data["uadpost"]) and $data["uadpost"]) {
				$data["action_to_draft"] = app() -> routes -> urlto("UAdPostController@update_draft");
			}

			$profile = app() -> sessions -> auth_user() -> profile();

			if($uadpost) {
				$data["has_posts"] = true;
				$data["lat"] = $uadpost -> location_lat;
				$data["lng"] = $uadpost -> location_lng;
				$data["country_ru"] = $uadpost -> country_ru;
				$data["country_en"] = $uadpost -> country_en;
				$data["city_ru"] = $uadpost -> city_ru;
				$data["city_en"] = $uadpost -> city_en;
				$data["region_ru"] = $uadpost -> region_ru;
				$data["region_en"] = $uadpost -> region_en;
			} else if($profile -> location_lat and $profile -> location_lng) {
				$data["lat"] = $profile -> location_lat;
				$data["lng"] = $profile -> location_lng;
				$data["country_ru"] = $profile -> country_ru;
				$data["country_en"] = $profile -> country_en;
				$data["city_ru"] = $profile -> city_ru;
				$data["city_en"] = $profile -> city_en;
				$data["region_ru"] = $profile -> region_ru;
				$data["region_en"] = $profile -> region_en;
			}

			if(isset($data["uadpost"]) and $data["uadpost"]) {
				$data["uadpost_id"] = $uadpost -> id();
				$data["title"] = $uadpost -> title;
				$data["content"] = $uadpost -> content;
				$data["condition_used"] = $uadpost -> condition_used;
				$data["price"] = $uadpost -> price;
				$data["currency"] = $uadpost -> currency;
				$data["exchange_flag"] = $uadpost -> exchange_flag;
				$data["images"] = $uadpost -> get_images();
				$data["cancel_url"] = $uadpost -> get_url();
			}
		}

		return $data;
	}
}
<?php

namespace Store\Templates\Logic;

class UAdPostForm extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> inside_data["first_name"] = "";
		$this -> inside_data["second_name"] = "";
		$this -> inside_data["phone_number"] = "";
		$this -> inside_data["has_posts"] = false;
		$this -> inside_data["condition_used"] = 2;
		$this -> inside_data["price"] = 0;
		$this -> inside_data["images"] = [];
		$this -> inside_data["cancel_url"] = "/";
		if(!isset($this -> inside_data["edit_mode"])){
			$this -> inside_data["edit_mode"] = false;
		}

		if(app() -> sessions -> is_auth()) {
			$this -> inside_data["first_name"] = app() -> sessions -> auth_user() -> profile() -> first_name;
			$this -> inside_data["second_name"] = app() -> sessions -> auth_user() -> profile() -> second_name;
			$this -> inside_data["phone_number"] = app() -> sessions -> auth_user() -> profile() -> phone_number;
			$uadpost = (isset($this -> inside_data["uadpost"]) and $this -> inside_data["uadpost"])
				? $this -> inside_data["uadpost"]
				: app() -> sessions -> auth_user() -> get_last_uadpost();

			if(isset($this -> inside_data["uadpost"]) and $this -> inside_data["uadpost"]) {
				$this -> inside_data["action_to_draft"] = app() -> routes -> urlto("UAdPostController@update_draft");
			}

			if($uadpost) {
				$this -> inside_data["has_posts"] = true;
				$this -> inside_data["lat"] = $uadpost -> location_lat;
				$this -> inside_data["lng"] = $uadpost -> location_lng;
				$this -> inside_data["country_ru"] = $uadpost -> country_ru;
				$this -> inside_data["country_en"] = $uadpost -> country_en;
				$this -> inside_data["city_ru"] = $uadpost -> city_ru;
				$this -> inside_data["city_en"] = $uadpost -> city_en;
				$this -> inside_data["region_ru"] = $uadpost -> region_ru;
				$this -> inside_data["region_en"] = $uadpost -> region_en;
			}

			if(isset($this -> inside_data["uadpost"]) and $this -> inside_data["uadpost"]) {
				$this -> inside_data["uadpost_id"] = $uadpost -> id();
				$this -> inside_data["title"] = $uadpost -> title;
				$this -> inside_data["content"] = $uadpost -> content;
				$this -> inside_data["condition_used"] = $uadpost -> condition_used;
				$this -> inside_data["price"] = $uadpost -> price;
				$this -> inside_data["currency"] = $uadpost -> currency;
				$this -> inside_data["exchange_flag"] = $uadpost -> exchange_flag;
				$this -> inside_data["images"] = $uadpost -> get_images();
				$this -> inside_data["cancel_url"] = $uadpost -> get_url();
			}
		}
	}
}
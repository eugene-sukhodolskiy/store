<?php

namespace Store\Controllers;

use \Store\Models\UAdPost;

class UAdPostController extends \Store\Middleware\Controller {
	public function create_page() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		return $this -> new_template() -> make('site/create.uadpost', [
			'page_title' => 'Новое объявление',
			'page_alias' => 'page create-uadpost'
		]);
	}

	public function create() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> response_error("unlogged_user");
		}

		extract($this -> get_post_data());

		if(!isset($title) or strlen($title) < 10) {
			return $this -> utils() -> response_error("title_too_short", [ "title" ]);
		}

		if(!isset($content)) {
			$content = "";
		}

		if(!isset($condition) or ($condition != "used" and $condition != "new")) {
			$condition = 2;
		}

		if(!isset($exchange_flag)) {
			$exchange_flag = 0;
		}

		if($exchange_flag == "on") {
			$exchange_flag = 1;
		}

		if(!isset($price) or $price == "") {
			return $this -> utils() -> response_error("price_not_specified", [ "price" ]);
		}

		if(!isset($currency) or !in_array($currency, ["UAH", "USD", "EUR"])) {
			$currency = "UAH";
		}

		if(!isset($first_name) or $first_name == "") {
			return $this -> utils() -> response_error("empty_first_name", [ "first_name" ]);
		}

		if(!isset($second_name) or $second_name == "") {
			return $this -> utils() -> response_error("empty_second_name", [ "second_name" ]);
		}

		if(!isset($phone) or $phone == "") {
			return $this -> utils() -> response_error("empty_phone_number", [ "phone" ]);
		}

		if(
			!isset($lat) or $lat == "" or is_string($lat)
			or !isset($lng) or $lng == "" or is_string($lng)
		) {
			return $this -> utils() -> response_error("location_not_specified");
		}

		$condition = $condition == "new" ? 1 : $condition;
		$condition = $condition == "used" ? 2 : $condition;
		$country_en = !isset($country_en) ? "" : $country_en;
		$country_ru = !isset($country_ru) ? "" : $country_ru;
		$region_en = !isset($region_en) ? "" : $region_en;
		$region_ru = !isset($region_ru) ? "" : $region_ru;
		$city_en = !isset($city_en) ? "" : $city_en;
		$city_ru = !isset($city_ru) ? "" : $city_ru;

		if(!isset($rules_agree) or $rules_agree != "on") {
			return $this -> utils() -> response_error("disagree_with_rules", [ "rules_agree" ]);
		}

		$images_number = (!isset($imgs) or $imgs == "") ? 0 : substr_count($imgs, ",") + 1;

		$uadpost = app() -> factory -> creator() -> create_uadpost(
			app() -> sessions -> auth_user() -> id(),
			$title, $content, $condition, $exchange_flag, 
			$price, $currency, $lat, $lng, $country_en, 
			$country_ru, $region_en, $region_ru, $city_en, 
			$city_ru, $images_number
		);

		if(!$uadpost) {
			return $this -> utils() -> response_error("fail_creating_uadpost");
		}

		$profile = app() -> sessions -> auth_user() -> profile();
		if(
			$profile -> first_name != $first_name 
			or $profile -> second_name != $second_name
			or $profile -> phone_number != $phone
		) {
			$profile -> first_name = $first_name;
			$profile -> second_name = $second_name;
			$profile -> phone_number = $phone;
		}

		if($profile -> location_lat != $lat or $profile -> location_lng != $lng) {
			$profile -> location_lat = $lat;
			$profile -> location_lng = $lng;
		}

		$profile -> update();

		if($images_number) {
			$imgs_aliases = explode(",", $imgs);
			foreach($imgs_aliases as $i => $alias) {
				app() -> factory -> creator() -> create_image(
					app() -> sessions -> auth_user() -> id(),
					$uadpost -> id(),
					"UAdPost",
					$alias,
					$i
				);
			}
		}
		
		return $this -> utils() -> response_success();
	}

	public function create_draft() {
		extract($this -> get_post_data());

		$title = isset($title) ? $title : "";
		$content = isset($content) ? $content : "";
		$condition = $condition == "new" ? 1 : $condition;
		$condition = $condition == "used" ? 2 : $condition;
		$country_en = !isset($country_en) ? "" : $country_en;
		$country_ru = !isset($country_ru) ? "" : $country_ru;
		$region_en = !isset($region_en) ? "" : $region_en;
		$region_ru = !isset($region_ru) ? "" : $region_ru;
		$city_en = !isset($city_en) ? "" : $city_en;
		$city_ru = !isset($city_ru) ? "" : $city_ru;
		$lat = isset($lat) ? floatval($lat) : 0;
		$lng = isset($lng) ? floatval($lng) : 0;
		$images_number = (!isset($imgs) or $imgs == "") ? 0 : substr_count($imgs, ",") + 1;

		if(!isset($price) or $price == "") {
			return $this -> utils() -> response_error("price_not_specified", [ "price" ]);
		}

		if(!isset($currency) or !in_array($currency, ["UAH", "USD", "EUR"])) {
			$currency = "UAH";
		}

		if(!isset($exchange_flag)) {
			$exchange_flag = 0;
		}

		if($exchange_flag == "on") {
			$exchange_flag = 1;
		}

		$uadpost = app() -> factory -> creator() -> create_uadpost(
			app() -> sessions -> auth_user() -> id(),
			$title, $content, $condition, $exchange_flag, 
			$price, $currency, $lat, $lng, $country_en, 
			$country_ru, $region_en, $region_ru, $city_en, 
			$city_ru, $images_number, "draft"
		);

		if(!$uadpost) {
			return $this -> utils() -> response_error("fail_creating_uadpost");
		}

		if($images_number) {
			$imgs_aliases = explode(",", $imgs);
			foreach($imgs_aliases as $i => $alias) {
				app() -> factory -> creator() -> create_image(
					app() -> sessions -> auth_user() -> id(),
					$uadpost -> id(),
					"UAdPost",
					$alias,
					$i
				);
			}
		}

		return $this -> utils() -> response_success();
	}

	protected function get_post_data() {
		$expected_fields = [
			"title", "content", "condition", "price", "currency",
			"first_name", "second_name", "phone", "imgs", "lat", "lng", 
			"country_ru", "country_en", "region_ru", "region_en",
			"city_ru", "city_en", "rules_agree", "imgs", "exchange_flag"
		];

		$data = [];
		foreach($expected_fields as $field) {
			if(isset($_POST[$field])){
				$data[$field] = is_string($_POST[$field]) ? trim($_POST[$field]) : $_POST[$field];
			}
		}

		return $data;
	}
}
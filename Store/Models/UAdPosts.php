<?php

namespace Store\Models;

use \Store\Entities\UAdPost;

class UAdPosts extends \Store\Middleware\Model{
	public function update(Int $uadpost_id, Int $uid, String $title, String $content, Int $condition, 
		Int $exchange_flag, 
		Float $price, String $currency, Float $lat, Float $lng, String $country_en, 
		String $country_ru, String $region_en, String $region_ru, String $city_en, 
		String $city_ru, Int $images_number, String $state = "published") {
		return app() -> thin_builder -> update(UAdPost::$table_name, [
			"uid" => $uid,
			"title" => $title,
			"content" => $content,
			"condition_used" => $condition,
			"exchange_flag" => $exchange_flag,
			"state" => $state,
			"price" => $price,
			"currency" => $currency,
			"location_lat" => $lat,
			"location_lng" => $lng,
			"country_en" => $country_en,
			"country_ru" => $country_ru,
			"region_en" => $region_en,
			"region_ru" => $region_ru,
			"city_en" => $city_en,
			"city_ru" => $city_ru,
			"factor" => 1,
			"rating" => 0,
			"images_number" => intval($images_number),
			"update_at" => date("Y-m-d H:i:s")
		], [
			["id", "=", $uadpost_id]
		]);
	}

	public function get_by_user(Int $uid, String $state, Int $amount = 10, Int $page_num = 1, String $order_by = "id"): Array {
		$uadposts = $this -> thin_builder() -> select(
			UAdPost::$table_name,
			UAdPost::get_fields(),
			[
				[ "uid", "=", $uid ],
				"AND",
				[ "state", "=", $state ]
			],
			[ $order_by ],
			"DESC",
			[ ($page_num - 1) * $amount, $amount ]
		);

		$uadposts = array_map(fn($item) => new UAdPost($item["id"], $item), $uadposts);

		return $uadposts ? $uadposts : [];
	}

	public function total_by_user(Int $uid, String $state): Int {
		return $this -> thin_builder() -> count(
			UAdPost::$table_name, 
			[
				[ "uid", "=", $uid ],
				"AND",
				[ "state", "=", $state ]
			]
		);
	}

	public function check_uadpost_data(Array $post, $strict = true) {
		extract($this -> extract_post_data($post));

		if($strict) {
			if(!isset($title) or strlen($title) < 10) {
				return app() -> utils -> response_error("title_too_short", [ "title" ]);
			}

			if(strlen($title) > 100) {
				return app() -> utils -> response_error("textfield_too_large", [ "title" ]);
			}

			if(strlen($content) > 10000) {
				return app() -> utils -> response_error("textfield_too_large", [ "content" ]);
			}

			if(!isset($price) or $price == "") {
				return app() -> utils -> response_error("price_not_specified", [ "price" ]);
			}

			if(!isset($first_name) or $first_name == "") {
				return app() -> utils -> response_error("empty_first_name", [ "first_name" ]);
			}

			if(!isset($second_name) or $second_name == "") {
				return app() -> utils -> response_error("empty_second_name", [ "second_name" ]);
			}

			if(!isset($patronymic) or $patronymic == "") {
				return app() -> utils -> response_error("empty_patronymic", [ "patronymic" ]);
			}

			if(!isset($phone) or $phone == "") {
				return app() -> utils -> response_error("empty_phone_number", [ "phone" ]);
			}

			if(
				!isset($lat) or $lat == ""
				or !isset($lng) or $lng == ""
			) {
				return app() -> utils -> response_error("location_not_specified");
			}

			if(!isset($rules_agree) or $rules_agree != "on") {
				return app() -> utils -> response_error("disagree_with_rules", [ "rules_agree" ]);
			}
		}

		if(!isset($content)) {
			$content = "";
		}

		if(!isset($currency) or !in_array($currency, ["UAH", "USD", "EUR"])) {
			$currency = "UAH";
		}

		if(!isset($condition) or ($condition != "used" and $condition != "new")) {
			$condition = 2;
		}

		if(!isset($exchange_flag)) {
			$exchange_flag = 0;
		}

		if($exchange_flag === "on") {
			$exchange_flag = 1;
		}

		$condition = $condition == "new" ? 1 : $condition;
		$condition = $condition == "used" ? 2 : $condition;
		$country_en = !isset($country_en) ? "" : $country_en;
		$country_ru = !isset($country_ru) ? "" : $country_ru;
		$region_en = !isset($region_en) ? "" : $region_en;
		$region_ru = !isset($region_ru) ? "" : $region_ru;
		$city_en = !isset($city_en) ? "" : $city_en;
		$city_ru = !isset($city_ru) ? "" : $city_ru;

		$images_number = (!isset($imgs) or $imgs == "") ? 0 : substr_count($imgs, ",") + 1;

		return compact(
			"title", "content", "condition", "country_en", "country_ru", "images_number",
			"region_en", "region_ru", "city_en", "city_ru", "lat", "lng", "imgs",
			"phone", "first_name", "second_name", "patronymic", "price", "currency", "exchange_flag"
		);
	}

	protected function extract_post_data(Array $post) {
		$expected_fields = [
			"uadpost_id", "title", "content", "condition", "price", "currency",
			"first_name", "second_name", "patronymic", "phone", "imgs", "lat", "lng", 
			"country_ru", "country_en", "region_ru", "region_en",
			"city_ru", "city_en", "rules_agree", "exchange_flag"
		];

		$data = [];
		foreach($expected_fields as $field) {
			if(isset($post[$field])){
				$data[$field] = is_string($post[$field]) ? htmlspecialchars(trim($post[$field])) : $post[$field];
			}
		}

		return $data;
	}

	public function is_exists(Int $uadpost_id): Bool {
		return $this -> thin_builder() -> count(
			UAdPost::$table_name, 
			[ "id", "=", $uadpost_id ]
		) ? true : false;
	}
}


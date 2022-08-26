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

	public function get_by_user(Int $uid, String $state, Int $amount = 10, Int $page_num = 1): Array {
		$uadposts = $this -> thin_builder() -> select(
			UAdPost::$table_name,
			UAdPost::get_fields(),
			[
				[ "uid", "=", $uid ],
				"AND",
				[ "state", "=", $state ]
			],
			[ "id" ],
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
}


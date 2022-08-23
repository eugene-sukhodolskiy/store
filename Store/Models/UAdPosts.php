<?php

namespace Store\Models;

use \Store\Entities\UAdPost;

class UAdPosts extends \Store\Middleware\Model{
	protected $table_name = "uadposts";

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
}


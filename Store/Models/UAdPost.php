<?php

namespace Store\Models;
use Store\Entities\Product;

class UAdPost extends \Store\Middleware\Model{
	protected $table_name = "uadposts";

	public function __construct(){
		
	}

	public function create(
		Int $uid, String $title, String $content, Int $condition, Int $exchange_flag, 
		Float $price, String $currency, Float $lat, Float $lng, String $country_en, 
		String $country_ru, String $region_en, String $region_ru, String $city_en, 
		String $city_ru, Int $images_number, String $state = "published"
	) {
		return $this -> thin_builder() -> insert($this -> table_name, [
			"uid" => $uid,
			"alias" => $this -> utils() -> gen_from_text_alias($title),
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
			"city_ru" => $country_ru,
			"factor" => 1,
			"rating" => 0,
			"images_number" => intval($images_number)
		]);
	}

}


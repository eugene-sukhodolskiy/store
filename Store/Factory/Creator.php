<?php

namespace Store\Factory;

use \Store\Entities\Profile;
use \Store\Entities\User;
use \Store\Entities\Image;
use \Store\Entities\UAdPost;
use \Store\Entities\Meta;

class Creator {
	public function create_user(String $alias, String $email, String $password) {
		$password_hash = sha1($password);

		$uid = app() -> thin_builder -> insert(User::$table_name, [
			"alias" => $alias,
			"email" => $email,
			"password" => $password_hash,
			"create_at" => date("Y-m-d H:i:s")
		]);

		return $uid ? new User($uid) : null;
	}

	public function create_profile(Int $uid) {
		$profile_id = app() -> thin_builder -> insert(Profile::$table_name, [
			"uid" => $uid,
			"create_at" => date("Y-m-d H:i:s")
		]);

		return $profile_id ? new Profile($profile_id) : null;
	}

	public function create_image(Int $uid, Int $ent_id, String $assignment, String $alias, Int $sequence = 0) {
		$image_id = app() -> thin_builder -> insert(Image::$table_name, [
			"uid" => $uid,
			"ent_id" => $ent_id,
			"assignment" => $assignment,
			"alias" => $alias,
			"sequence" => $sequence,
			"create_at" => date("Y-m-d H:i:s")
		]);

		return $image_id ? new Image($image_id) : null;
	}

	public function create_uadpost(
		Int $uid, String $title, String $content, Int $condition, Int $exchange_flag, 
		Float $price, String $currency, Float $lat, Float $lng, String $country_en, 
		String $country_ru, String $region_en, String $region_ru, String $city_en, 
		String $city_ru, Int $images_number, String $state = "published"
	) {
		$uadpost_id = app() -> thin_builder -> insert(UAdPost::$table_name, [
			"uid" => $uid,
			"alias" => app() -> utils -> gen_from_text_alias(uniqid() . "-" . $title),
			"title" => $title,
			"content" => $content,
			"condition_used" => $condition,
			"exchange_flag" => $exchange_flag,
			"state" => $state,
			"price" => $price,
			"single_price" => app() -> utils -> convert_price_to_uah_from($currency, $price),
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
		]);

		return $uadpost_id ? new UAdPost($uadpost_id) : null;
	}

	public function create_meta(Int $ent_id, String $assignment, String $name, $value): Meta {
		$data = [
			"ent_id" => $ent_id,
			"assignment" => $assignment,
			"name" => $name,
			"value" => $value,
			"create_at" => date("Y-m-d H:i:s")
		];

		$meta_id = app() -> thin_builder -> insert(Meta::$table_name, $data);

		return new Meta($meta_id, array_merge(
			[
				"id" => $meta_id, 
				"update_at" => $data["create_at"]
			],
			$data
		));
	}
}
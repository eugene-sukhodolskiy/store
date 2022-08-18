<?php

namespace Store\Entities;

class UAdPost extends \Store\Middleware\Entity {
	public static $table_name = "uadposts";
	protected static $fields = [
		"id", "uid", "state", "alias", "rating", "factor",
		"title", "content", "price", "currency", "exchange_flag",
		"condition_used", "images_number", "location_lat", "location_lng",
		"country_ru", "country_en", "region_ru", "region_en",
		"city_ru", "city_en", "create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
	}

	public function get_images() {
		return app() -> factory -> getter() -> get_images_by_entity($this -> id(), "UAdPost");
	}

	public function get_first_image() {
		$imgs = app() -> factory -> getter() -> get_images_by_entity($this -> id(), "UAdPost", 1);
		if(!$imgs) {
			return null;
		}

		return $imgs[0];
	}

	public function user() {
		return $this -> get_pet_instance("User", fn() => new User($this -> uid));
	}

	public function get_url() {
		return app() -> routes -> urlto("UAdPostController@view_page", [
			"alias" => "{$this -> alias}.html"
		]);
	}

	public function has_images() {
		return $this -> images_number ? true : false;
	}

	public function get_formatted_timestamp() {
		return date("d.m.Y", strtotime($this -> create_at));
	}
}
<?php

namespace Store\Entities;

use \Store\Models\Favourites;

class UAdPost extends \Store\Middleware\Entity {
	public static $table_name = "uadposts";
	protected static $fields = [
		"id", "uid", "state", "alias", "rating", "factor",
		"title", "content", "price", "currency", "exchange_flag",
		"condition_used", "images_number", "location_lat", "location_lng",
		"country_ru", "country_en", "region_ru", "region_en",
		"city_ru", "city_en", "create_at", "update_at"
	];

	protected $favorite_state_for_current_user = null;

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
		return app() -> utils -> formatted_timestamp($this -> create_at);
	}

	public function get_formatted_price() {
		$price = number_format($this -> price, 0, ",", " ");
		return $price;
	}

	public function get_formatted_currency() {
		$t = [
			"UAH" => "грн",
			"EUR" => "€",
			"USD" => "$"
		];

		return $t[ $this -> currency ];
	}

	public function remove() {
		if($this -> has_images()) {
			$imgs = $this -> get_images();
			foreach($imgs as $img) {
				$img -> remove();
			}
		}

		if($this -> state == "published") {
			$this -> deactivate();
		}

		$this -> remove_entity();
	}

	public function make_removed(){
		if($this -> state == "published") {
			$this -> deactivate();
		}

		$this -> state = "removed";
		$this -> update();
	}

	public function deactivate() {
		$this -> state = "unpublished";
		$this -> update();
		$this -> user() -> statistics() -> total_published_uadposts_decrease();
		(new Favourites()) -> remove_for_assignment_unit($this -> id(), "UAdPost");
	}

	public function activate() {
		$this -> state = "published";
		$this -> update();
		$this -> user() -> statistics() -> total_published_uadposts_increase();
	}

	public function is_favorite_for_current_user(): Bool {
		if(is_null($this -> favorite_state_for_current_user)) {
			throw new \Exception("Favorite state is not inited");
		}

		return $this -> favorite_state_for_current_user;
	}

	public function set_favorite_state_for_current_user(Bool $state): void {
		$this -> favorite_state_for_current_user = $state;
	}
}
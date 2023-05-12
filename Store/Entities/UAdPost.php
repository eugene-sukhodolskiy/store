<?php

namespace Store\Entities;

use \Store\Models\Favourites;
use \Store\Models\Keywords;
use \Store\Containers\KeywordsContainer;
use \Store\Wrappers\UAdPostStatistics;

class UAdPost extends \Store\Middleware\Entity {
	public static $table_name = "uadposts";
	protected static $fields = [
		"id", "uid", "state", "alias", "rating", "factor",
		"title", "content", "price", "single_price", "currency", "exchange_flag",
		"condition_used", "images_number", "location_lat", "location_lng",
		"country_ru", "country_en", "region_ru", "region_en",
		"city_ru", "city_en", "create_at", "update_at"
	];

	protected $favorite_state_for_current_user = null;
	public $imgs = [];
	public $exists_imgs = true;

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
	}

	public function get_images() {
		if($this -> exists_imgs) {
			$this -> imgs = app() -> factory -> getter() -> get_images_by_entity($this -> id(), "UAdPost");
		}

		if(!$this -> imgs) {
			$this -> exists_imgs = false;
		}

		return $this -> imgs ? $this -> imgs[0] : false;
	}

	public function get_first_image() {
		if(count($this -> imgs)) {
			return $this -> imgs[0];
		}

		$this -> get_images();

		return $this -> imgs ? $this -> imgs[0] : false;
	}

	public function user(): User {
		return $this -> get_pet_instance("User", fn() => new User($this -> uid));
	}

	public function statistics() {
		return $this -> get_pet_instance("UAdPostStatistics", function() {
			return new UAdPostStatistics($this -> id, "UAdPost");
		});
	}

	public function get_url(): String {
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

	public function get_formatted_price(): String {
		$price = number_format($this -> price, 2, ",", " ");
		return $price;
	}

	public function get_price_particles(): Array {
		list($banknotes, $coins) = explode(",", $this -> get_formatted_price()) ;
		return compact("banknotes", "coins");
	}

	public function get_single_price_particles(): Array {
		list($banknotes, $coins) = explode(",", number_format($this -> single_price, 2, ",", " "));
		return compact("banknotes", "coins");	
	}

	public function get_formatted_currency(String $currency = ""): String {
		$t = [
			"UAH" => "грн",
			"EUR" => "€",
			"USD" => "$"
		];

		return $t[ strlen($currency) ? $currency : $this -> currency ];
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

		$this -> statistics() -> clear_all_fields();
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
		$this -> remove_keywords();
		(new Favourites()) -> remove_for_assignment_unit($this -> id(), "UAdPost");
	}

	public function activate() {
		$this -> state = "published";
		$this -> update();
		$this -> user() -> statistics() -> total_published_uadposts_increase();
		$this -> refresh_keywords();
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

	public function generate_keywords(): Array {
		$keywords = (new Keywords) -> create_keywords_by_content(
			"{$this -> title}",
			$this -> id
		);

		$keywords_reload_url = FCONF["services"]["keywords"]["keywords_reload"];
		if($keywords_reload_url) {
			@file_get_contents($keywords_reload_url);
		}
		return $keywords;
	}

	public function remove_keywords() {
		$res = (new Keywords) -> remove_keywords_by_uap_id($this -> id);
		$keywords_reload_url = FCONF["services"]["keywords"]["keywords_reload"];
		if($keywords_reload_url) {
			@file_get_contents($keywords_reload_url);
		}

		return $res;
	}

	public function refresh_keywords(): Array {
		if(!$this -> remove_keywords()) {
			return [];
		}

		return $this -> generate_keywords();
	}

	public function keywords(): KeywordsContainer {
		return $this -> get_pet_instance(
			"KeywordsContainer", 
			fn() => (new Keywords) -> get_keywords_by_uap_id($this -> id)
		);
	}
}
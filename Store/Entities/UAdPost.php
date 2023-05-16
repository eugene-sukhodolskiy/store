<?php

namespace Store\Entities;

use \Store\Models\Favourites;
use \Store\Models\Keywords;
use \Store\Containers\KeywordsContainer;
use \Store\Containers\ImgsContainer;
use \Store\Containers\UAdPostStatistics;
use \Store\Containers\Registration\UAdPostsContainer;
use \Store\Entities\User;

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
	protected $imgs_container = null;
	protected UAdPostStatistics $statistics;
	protected ?User $user = null;

	public function __construct(Int $id, Array $data = []) {
		parent::__construct(self::$table_name, $id, $data);
		UAdPostsContainer::add_entity_item($this);
		$this -> statistics = new UAdPostStatistics($id);
		$this -> imgs_container = new ImgsContainer($id, "UAdPost");
	}

	public function get_images(): Array {
		if(!$this -> imgs_container -> was_filled()) {
			$this -> imgs_container -> fill_container();
		}

		return $this -> imgs_container -> get_imgs();
	}

	public function get_first_image(): ?Image {
		return $this -> imgs_container -> get_first_img();
	}

	public function has_images(): Bool {
		return count($this -> get_images()) != 0;
	}

	public function fill(Array $data = []) {
		parent::fill($data);
		$this -> user();
	}

	public function user(): User {
		if(!$this -> user) {
			$this -> user = new User($this -> uid);
		}

		return $this -> user;
	}

	public function statistics() {
		return $this -> statistics;
	}

	public function get_url(): String {
		return app() -> routes -> urlto("UAdPostController@view_page", [
			"alias" => "{$this -> alias}.html"
		]);
	}

	public function get_formatted_timestamp(): String {
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

	public function remove(): Void {
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

	public function make_removed(): Void {
		if($this -> state == "published") {
			$this -> deactivate();
		}

		$this -> state = "removed";
		$this -> update();
	}

	public function deactivate(): Void {
		$this -> state = "unpublished";
		$this -> update();
		$this -> user() -> statistics() -> total_published_uadposts_decrease();
		$this -> remove_keywords();
		(new Favourites()) -> remove_for_assignment_unit($this -> id(), "UAdPost");
	}

	public function activate(): Void {
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

	public function remove_keywords(): Bool {
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
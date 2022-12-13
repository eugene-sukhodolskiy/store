<?php

namespace Store\Controllers;

use \Store\Models\UAdPosts;
use \Store\Models\Profiles;
use \Store\Models\Images;
use \Store\Entities\UAdPost;
use \Store\Templates\Logic\UserUAdPosts;

class UAdPostController extends \Store\Middleware\Controller {
	public function create_page() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		return $this -> new_template() -> make("site/create.uadpost", [
			"page_title" => "Новое объявление",
			"page_alias" => "page create-uadpost"
		]);
	}

	public function view_page($alias) {
		$alias = strstr($alias, ".html", true);
		$uadposts = app() -> factory -> getter() -> get_uadposts_by("alias", $alias, 1);

		if(!count($uadposts)) {
			return $this -> new_template() -> make("site/404.php");
		}

		app() -> factory -> initer() -> init_group_profiles_for_users( $uadposts );

		return $this -> new_template() -> make("site/view.uadpost", [
			"page_title" => $uadposts[0] -> title,
			"page_alias" => "page view-uadpost",
			"uadpost" => $uadposts[0],
			"displaying_btn_favorite" => $uadposts[0] -> state == "published"
		]);
	}

	public function edit_page($alias) {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		$alias = strstr($alias, ".html", true);
		$uadposts = app() -> factory -> getter() -> get_uadposts_by("alias", $alias, 1);

		if(!count($uadposts)) {
			return $this -> new_template() -> make("site/404.php");
		}

		if($uadposts[0] -> uid != $uadposts[0] -> user() -> id()) {
			return $this -> new_template() -> make("site/404.php");
		}

		return $this -> new_template() -> make("site/edit.uadpost", [
			"page_title" => "Редактирование: " . $uadposts[0] -> title,
			"page_alias" => "page edit-uadpost",
			"uadpost" => $uadposts[0]
		]);
	}

	public function update() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> response_error("unlogged_user");
		}

		$uadposts_model = new UAdPosts();
		$result = $uadposts_model -> check_uadpost_data($_POST);

		if(is_string($result)) {
			return $result;
		}

		extract($result);

		$uadpost_id = intval($_POST["uadpost_id"]);
		$uadposts = app() -> factory -> getter() -> get_uadposts_by("id", $uadpost_id, 1);
		
		if(!count($uadposts)) {
			return $this -> utils() -> response_error("fail_publishing_uadpost");
		}

		$uadpost = $uadposts[0];
		if($uadpost -> state != "published") {
			$uadpost -> activate();
		}

		$prev_imgs = $uadpost -> get_images();

		$uadposts_model -> update(
			$uadpost -> id(),
			app() -> sessions -> auth_user() -> id(),
			$title, $content, $condition, $exchange_flag, 
			$price, $currency, $lat, $lng, $country_en, 
			$country_ru, $region_en, $region_ru, $city_en, 
			$city_ru, $images_number
		);

		(new Profiles()) -> update_with_update_uadpost(
			app() -> sessions -> auth_user() -> profile(), 
			$first_name, 
			$second_name, 
			$patronymic,
			$phone,
			$lat,
			$lng
		);

		// IMGS

		$imgs_aliases = explode(",", $imgs);
		$prev_imgs_aliases = array_map(fn($item) => $item -> alias, $prev_imgs);
		
		$new_imgs_aliases = array_filter($imgs_aliases, function($img_alias) use($prev_imgs_aliases) {
			return !in_array($img_alias, $prev_imgs_aliases);
		});

		$legacy_imgs = array_filter($prev_imgs, function($prev_img) use($imgs_aliases) {
			return !in_array($prev_img -> alias, $imgs_aliases) ? true : false;
		});

		$images_model = new Images();
		$images_model -> create_from_aliases( $new_imgs_aliases, $uadpost );

		foreach($legacy_imgs as $i => $legacy_img) {
			$legacy_img -> remove();
		}

		$images_model -> update_sequence_by_aliases($imgs_aliases, $uadpost);
		
		return $this -> utils() -> response_success([
			"redirect_url" => $uadpost -> get_url(),
			"redirect_delay" => 300
		]);
	}

	public function create() {
		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("unlogged_user");
		}

		$uadposts_model = new UAdPosts();
		$result = $uadposts_model -> check_uadpost_data($_POST);

		if(is_string($result)) {
			return $result;
		}

		extract($result);

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

		(new Profiles()) -> update_with_update_uadpost(
			app() -> sessions -> auth_user() -> profile(), 
			$first_name, 
			$second_name, 
			$patronymic,
			$phone,
			$lat,
			$lng
		);

		if($images_number) {
			(new Images()) -> create_from_aliases( explode(",", $imgs), $uadpost );
		}

		if($uadpost -> state == "published") {
			$uadpost -> user() -> statistics() -> total_published_uadposts_increase();
		}
		
		return $this -> utils() -> response_success([
			"redirect_url" => $uadpost -> get_url(),
			"redirect_delay" => 300
		]);
	}

	public function create_draft() {
		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("unlogged_user");
		}

		$uadposts_model = new UAdPosts();
		$result = $uadposts_model -> check_uadpost_data($_POST, false);

		if(is_string($result)) {
			return $result;
		}

		extract($result);

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
			(new Images()) -> create_from_aliases( explode(",", $imgs), $uadpost );
		}

		return $this -> utils() -> response_success([
			"redirect_url" => app() -> routes -> urlto("UAdPostController@ready_uadposts_cur_user_page", [
				"state" => "draft"
			]),
			"redirect_delay" => 300
		]);
	}

	public function update_draft () {
		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("unlogged_user");
		}

		$uadposts_model = new UAdPosts();
		$result = $uadposts_model -> check_uadpost_data($_POST, false);

		if(is_string($result)) {
			return $result;
		}

		extract($result);

		$uadpost_id = intval($_POST["uadpost_id"]);
		$uadposts = app() -> factory -> getter() -> get_uadposts_by("id", $uadpost_id, 1);
		
		if(!count($uadposts)) {
			return $this -> utils() -> response_error("fail_publishing_uadpost");
		}

		$uadpost = $uadposts[0];
		$uadpost -> deactivate();

		$prev_imgs = $uadpost -> get_images();

		$uadposts_model -> update(
			$uadpost -> id(),
			app() -> sessions -> auth_user() -> id(),
			$title, $content, $condition, $exchange_flag, 
			$price, $currency, $lat, $lng, $country_en, 
			$country_ru, $region_en, $region_ru, $city_en, 
			$city_ru, $images_number, "draft"
		);

		// IMGS

		$imgs_aliases = explode(",", $imgs);
		$prev_imgs_aliases = array_map(fn($item) => $item -> alias, $prev_imgs);
		
		$new_imgs_aliases = array_filter($imgs_aliases, function($img_alias) use($prev_imgs_aliases) {
			return !in_array($img_alias, $prev_imgs_aliases);
		});

		$legacy_imgs = array_filter($prev_imgs, function($prev_img) use($imgs_aliases) {
			return !in_array($prev_img -> alias, $imgs_aliases) ? true : false;
		});

		$images_model = new Images();
		$images_model -> create_from_aliases( $new_imgs_aliases, $uadpost );

		foreach($legacy_imgs as $i => $legacy_img) {
			$legacy_img -> remove();
		}

		$images_model -> update_sequence_by_aliases($imgs_aliases, $uadpost);

		return $this -> utils() -> response_success([
			"redirect_url" => app() -> routes -> urlto("UAdPostController@ready_uadposts_cur_user_page", [
				"state" => "draft"
			]),
			"redirect_delay" => 300
		]);
	}

	public function remove($uadpost_id) {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		$uadpost = new UAdPost(intval($uadpost_id));
		if(!$uadpost) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		if(app() -> sessions -> auth_user() -> id() != $uadpost -> uid) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		$uadpost -> make_removed();

		return $this -> utils() -> redirect( app() -> routes -> urlto(
			"UAdPostController@ready_uadposts_cur_user_page",
			[ "state" => "published" ]
		));
	}

	public function ready_uadposts_cur_user_page($state) {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		if(!in_array($state, ["published", "unpublished", "draft"])) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		$pnum = isset($_GET["np"]) ? intval($_GET["pn"]) : 1;

		$user = app() -> sessions -> auth_user();
		$total = $user -> total_uadposts($state);
		$uadposts = $total ? $user -> get_uadposts($state, $pnum ? $pnum : 1) : [];
		
		switch($state) {
			case "published": 
				$page_title = "Опубликованные объявления";
			break;
			case "unpublished": 
				$page_title = "Деактивированные объявления";
			break;
			case "draft":
				$page_title = "Черновики";
			break;
		}

		return (new UserUAdPosts(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("site/user.uadposts", [
			"page_title" => $page_title,
			"page_alias" => "page user-uadposts",
			"uadposts" => $uadposts,
			"total_uadposts" => $total,
			"per_page" => FCONF["profile_uadposts_per_page"]
		]);
	}

	public function change_uadpost_state($uadpost_id, $state) {
		$exists_states = ["published", "unpublished"];

		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		if(!in_array($state, $exists_states)) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		$uadpost = new UAdPost(intval($uadpost_id));
		if(!$uadpost) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		if(app() -> sessions -> auth_user() -> id() != $uadpost -> uid) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		if($state == "unpublished") {
			$redirect_url = app() -> routes -> urlto(
				"UAdPostController@ready_uadposts_cur_user_page", 
				["state" => "published"]
			) . "#deactivate-success";

			$uadpost -> deactivate();
		} elseif($state == "published") {
			$redirect_url = app() -> routes -> urlto(
				"UAdPostController@ready_uadposts_cur_user_page", 
				["state" => "unpublished"]
			) . "#activate-success";

			$uadpost -> activate();
		}

		return app() -> utils -> redirect($redirect_url);
	}
}
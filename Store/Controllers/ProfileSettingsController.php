<?php

namespace Store\Controllers;

use \Store\Templates\Logic\ProfileSettings;

class ProfileSettingsController extends \Store\Middleware\Controller {
	public function profile_settings_page() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		return (new ProfileSettings(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("site/profile.settings", [
			"page_title" => "Настройки профиля",
			"page_alias" => "page profile-settings"
		]);
	}

	public function update(
		String $first_name, String $second_name, String $phone_number, String $imgs,
		Float $lat, Float $lng, String $country_en, String $country_ru, String $region_en,
		String $region_ru, String $city_en, String $city_ru
	) {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		$user = app() -> sessions -> auth_user();
		$user -> profile() -> first_name = trim(strip_tags($first_name));
		$user -> profile() -> second_name = trim(strip_tags($second_name));
		$user -> profile() -> phone_number = trim(strip_tags($phone_number));
		$user -> profile() -> location_lat = $lat;
		$user -> profile() -> location_lng = $lng;
		$user -> profile() -> country_en = trim(strip_tags($country_en));
		$user -> profile() -> country_ru = trim(strip_tags($country_ru));
		$user -> profile() -> region_en = trim(strip_tags($region_en));
		$user -> profile() -> region_ru = trim(strip_tags($region_ru));
		$user -> profile() -> city_en = trim(strip_tags($city_en));
		$user -> profile() -> city_ru = trim(strip_tags($city_ru));
		
		$userpic = $user -> profile() -> userpic();
		if($imgs) {
			if(!$userpic or $imgs != $userpic -> alias) {
				if($userpic) {
					$userpic -> remove();
				}

				app() -> factory -> creator() -> create_image(
					$user -> id(), 
					$user -> profile() -> id(),
					"Profile",
					$imgs
				);
			} 
		} else {
			if($userpic) {
				$userpic -> remove();
			}
		}

		$user -> profile() -> update();

		return app() -> utils -> redirect( app() -> routes -> urlto("ProfileSettingsController@profile_settings_page") . "#save-success" );
	}
}
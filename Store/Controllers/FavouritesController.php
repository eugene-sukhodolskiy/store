<?php

namespace Store\Controllers;

use \Store\Models\Favourites;
use \Store\Models\UAdPosts;
use \Store\Templates\Logic\UserUAdPosts;

class FavouritesController extends \Store\Middleware\Controller {
	public function make(Int $uadpost_id) {
		if( !app() -> sessions -> is_auth() ) {
			return $this -> utils() -> response_error("unlogged_user");
		}

		$user = app() -> sessions -> auth_user();
		
		$uadposts_model = new UAdPosts();
		if( !$uadposts_model -> is_exists( $uadpost_id ) ) {
			return $this -> utils() -> response_error("uadpost_not_exist");
		}

		$favourites_model = new Favourites();
		
		if( !$favourites_model -> is_exists_by( $user -> id(), $uadpost_id, "UAdPost" ) ) {
			$result = $favourites_model -> create( $user -> id(), $uadpost_id, "UAdPost" );
		} else {
			$result = $favourites_model -> remove_by( $user -> id(), $uadpost_id, "UAdPost" );
		}

		if(!$result) {
			return $this -> utils() -> response_error("undefined_error");
		}

		return $this -> utils() -> response_success();
	}

	public function favourites_page() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		$pn = isset($_GET["pn"]) ? intval($_GET["pn"]) : 1;
		$user = app() -> sessions -> auth_user();

		$favourites_model = new Favourites();
		$favs = $favourites_model -> get_by( $user -> id(), "UAdPost", $pn );

		$uadposts = app() -> factory -> getter() -> get_uadposts_by(
			"id", 
			array_map(fn($fav) => $fav -> ent_id, $favs),
			count($favs)
		);

		$uadposts = array_filter( $uadposts, fn($uadpost) => $uadpost -> state == "published" );
		$total = $user -> total_favourites_uadposts();

		return (new UserUAdPosts(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("site/favourites", [
			"page_title" => "Избранные",
			"page_alias" => "page user-uadposts favourites",
			"uadposts" => $uadposts,
			"total_uadposts" => $total,
			"per_page" => FCONF["favourites_uadposts_per_page"]
		]);
	}
}
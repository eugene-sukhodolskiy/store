<?php

namespace Store\Controllers;

use \Store\Models\Favourites;
use \Store\Models\UAdPosts;

class FavouritesController extends \Store\Middleware\Controller {
	public function make(Int $uadpost_id) {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> response_error("unlogged_user");
		}

		$user = app() -> sessions -> auth_user();
		
		$uadposts_model = new UAdPosts();
		if(!$uadposts_model -> is_exists( $uadpost_id )) {
			return $this -> utils() -> response_error("uadpost_not_exist");
		}

		$favourites_model = new Favourites();
		
		if( !$favourites_model -> is_exists_by( $user -> id(), $uadpost_id, "UAdPost" ) ) {
			$result = $favourites_model -> create( $user -> id(), $uadpost_id, "UAdPost" )
		} else {
			$result = $favourites_model -> remove_by( $user -> id(), $uadpost_id, "UAdPost" );
		}

		if(!$result) {
			return $this -> utils() -> response_error("undefined_error");
		}

		return $this -> utils() -> response_success();
	}

	public function favourites_page() {

	}
}
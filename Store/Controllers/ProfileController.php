<?php

namespace Store\Controllers;

use \Store\Containers\Registration\UsersContainer;
use \Store\Containers\Registration\ProfilesContainer;
use \Store\Containers\ImgsContainer;
use \Store\Containers\MetaContainer;

class ProfileController extends \Store\Middleware\Controller {
	public function profile_page($user_alias) {
		$user = app() -> factory -> getter() -> get_user_by("alias", $user_alias);
		$total_uadposts = $user -> total_uadposts();
		$pn = isset($_GET["pn"]) ? intval($_GET["pn"]) : 1;
		$uadposts = $total_uadposts ? $user -> get_uadposts("published", $pn) : [];

		UsersContainer::fill();
		ProfilesContainer::fill();
		ImgsContainer::fill();
		MetaContainer::fill();

		return $this -> new_template() -> make("site/profile.php", [
			"page_title" => "Profile",
			"page_alias" => "page profile",
			"user" => $user,
			"total_uadposts" => $total_uadposts,
			"uadposts" => $uadposts,
			"per_page" => FCONF["profile_uadposts_per_page"],
		]);
	}

	public function goto_self_profile() {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		return $this -> utils() -> redirect( app() -> routes -> urlto("ProfileController@profile_page", [
			"user_alias" => app() -> sessions -> auth_user() -> alias
		]) );
	}
}
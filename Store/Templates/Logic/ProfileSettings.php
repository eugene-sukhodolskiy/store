<?php

namespace Store\Templates\Logic;

class ProfileSettings extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$user = app() -> sessions -> auth_user();
		$this -> inside_data["user"] = $user;

		$userpic = $user -> profile() -> userpic();
		$this -> inside_data["images"] = $userpic ? [ $userpic ] : [];
	}
}
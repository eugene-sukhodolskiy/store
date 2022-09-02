<?php

namespace Store\Templates\Logic;

class ProfileSettings extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$user = app() -> sessions -> auth_user();
		$data["user"] = $user;

		$userpic = $user -> profile() -> userpic();
		$data["images"] = $userpic ? [ $userpic ] : [];

		return $data;
	}
}
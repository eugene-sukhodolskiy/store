<?php

namespace Store\Templates\Logic;

class UserUAdPosts extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$user = app() -> sessions -> auth_user();
		$this -> inside_data["user"] = $user;
	}
}
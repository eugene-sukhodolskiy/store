<?php

namespace Store\Templates\Logic;

class UserUAdPosts extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$user = app() -> sessions -> auth_user();
		$data["user"] = $user;
		return $data;
	}
}
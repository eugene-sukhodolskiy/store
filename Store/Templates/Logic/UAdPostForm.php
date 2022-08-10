<?php

namespace Store\Templates\Logic;

class UAdPostForm extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> inside_data["first_name"] = "";
		$this -> inside_data["second_name"] = "";
		$this -> inside_data["phone_number"] = "";

		if(app() -> sessions -> is_auth()) {
			$this -> inside_data["first_name"] = app() -> sessions -> auth_user() -> profile() -> first_name;
			$this -> inside_data["second_name"] = app() -> sessions -> auth_user() -> profile() -> second_name;
			$this -> inside_data["phone_number"] = app() -> sessions -> auth_user() -> profile() -> phone_number;
		}
	}
}
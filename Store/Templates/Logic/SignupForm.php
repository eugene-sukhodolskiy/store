<?php

namespace Store\Templates\Logic;

class SignupForm extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> check_required_arguments();
		$this -> prepare_argument_addition_classes();
	}

	protected function check_required_arguments(){
		if(!isset($this -> inside_data["action"])) {
			return dd("Required argument `action` not found");
		}
	}

	protected function prepare_argument_addition_classes(){
		if(isset($this -> inside_data["addition_classes"]) and is_array($this -> inside_data["addition_classes"])){
			$this -> inside_data["addition_classes"] = implode(" ", $this -> inside_data["addition_classes"]);
		}

		return true;
	}
}
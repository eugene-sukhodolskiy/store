<?php

namespace Store\Templates\Logic;

class SignupForm extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$data = $this -> check_required_arguments($data);
		$data = $this -> prepare_argument_addition_classes($data);
		return $data;
	}

	protected function check_required_arguments(Array $data): Array {
		if(!isset($data["action"])) {
			throw new \Exception("Required argument `action` not found");
		}

		return $data;
	}

	protected function prepare_argument_addition_classes(Array $data): Array{
		if(isset($data["addition_classes"]) and is_array($data["addition_classes"])){
			$data["addition_classes"] = implode(" ", $data["addition_classes"]);
		}

		return $data;
	}
}
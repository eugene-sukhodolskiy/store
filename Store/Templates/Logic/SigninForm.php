<?php

namespace Store\Templates\Logic;

class SigninForm extends SignupForm {
	public function heir_manipulation(Array $data): Array {
		return parent::heir_manipulation($data);
	}
}
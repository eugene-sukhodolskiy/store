<?php

namespace Store\Templates\Logic;

class UserArea extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$data = array_merge($data, $this -> parent() -> get_inside_data());
		return $data;
	}
}
<?php

namespace Store\Templates\Logic;

class UserArea extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> inside_data = array_merge($this -> inside_data, $this -> parent() -> get_inside_data());
	}
}
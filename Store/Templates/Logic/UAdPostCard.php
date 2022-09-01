<?php

namespace Store\Templates\Logic;

class UAdPostCard extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> inside_data["displaying_btn_favorite"] = true;

		if($this -> inside_data["uadpost"] and $this -> inside_data["uadpost"] -> state != "published") {
			$this -> inside_data["displaying_btn_favorite"] = false;
		}
	}
}
<?php

namespace Store\Templates\Logic;

class UAdPostCard extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$data["displaying_btn_favorite"] = true;

		if($data["uadpost"] and $data["uadpost"] -> state != "published") {
			$data["displaying_btn_favorite"] = false;
		}

		return $data;
	}
}
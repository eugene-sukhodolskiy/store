<?php

namespace Store\Templates\Logic;

class UserArea extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$data = array_merge($data, $this -> parent() -> get_inside_data());
		$user = app() -> sessions -> auth_user();

		$data["total_published_uadposts"] = $user -> statistics() -> total_published_uadposts;
		if($data["total_published_uadposts"] > 99) {
			$data["total_published_uadposts"] = "99+";
		}

		$data["total_favourites"] = $user -> total_favourites_uadposts();
		if($data["total_favourites"] > 99) {
			$data["total_favourites"] = "99+";
		}

		$data["total_unconfirm_sales"] = $user -> total_orders("seller", "unconfirmed");
		return $data;
	}
}
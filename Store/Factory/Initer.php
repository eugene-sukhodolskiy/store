<?php

namespace Store\Factory;

use \Store\Models\Favourites;

class Initer {
	public function init_uadposts_group_favorite_state(Array $uadposts): void {
		if(count($uadposts)) {
			(new Favourites()) -> assignment_group_is_favorite("UAdPost", $uadposts);
		}
	}
}
<?php

namespace Store\Models;

use \Store\Entities\UAdPost;
use \Store\Entities\Profile;

class Profiles extends \Store\Middleware\Model {
	public function update_with_update_uadpost(
		Profile $profile, 
		String $first_name, 
		String $second_name, 
		String $patronymic, 
		String $phone,
		Float $lat,
		Float $lng
	) {
		if(
			$profile -> first_name != $first_name 
			or $profile -> second_name != $second_name
			or $profile -> patronymic != $patronymic
			or $profile -> phone_number != $phone
		) {
			$profile -> first_name = $first_name;
			$profile -> second_name = $second_name;
			$profile -> patronymic = $patronymic;
			$profile -> phone_number = $phone;
		}

		if($profile -> location_lat != $lat or $profile -> location_lng != $lng) {
			$profile -> location_lat = $lat;
			$profile -> location_lng = $lng;
		}

		return $profile -> update();
	}
}
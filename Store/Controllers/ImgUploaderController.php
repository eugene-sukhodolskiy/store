<?php

namespace Store\Controllers;

use \Store\Entities\User;
use \Store\Models\Images;

class ImgUploaderController extends \Store\Middleware\Controller {
	public function upload_img(String $img) {
		$images = new Images();
		$result = $images -> upload($img);
		if(!$result) {
			return $this -> utils() -> response_error("error_of_img_upload");
		}

		return $this -> utils() -> response_success([
			"image" => $result
		]);
	}	
}
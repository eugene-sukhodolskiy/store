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

	public function show_img(String $img_name) {
		if(strpos($img_name, "..") !== false) {
			return false;
		}
		
		header('Content-Type: image/' . (strpos($img_name, ".jpg") ? "jpeg" : "png"));
		return file_get_contents(FCONF["users_folder"] . "/{$img_name}");
	}
}
<?php

namespace Store\Models;

use \Store\Entities\UAdPost;

class Images extends \Store\Middleware\Model {

	public function upload(String $img) {
		list(, $img) = explode(";base64", $img);
		$img = base64_decode($img);
		$alias = uniqid(mt_rand(), true);
		$filepath = $this -> get_path_to_image($alias);
		if(!file_put_contents($filepath, $img)) {
			return false;
		}

		$this -> utils() -> image_resize(
			$filepath, 
			$filepath, 
			FCONF["image_resize_map"]["original"][1], 
			FCONF["image_resize_map"]["original"][0], 
		);

		$prev_filepath = $filepath;
		foreach(FCONF["image_resize_map"] as $size_name => $size_setting) {
			if($size_name == "original") {
				continue;
			}

			$filepath_ = $this -> get_path_to_image($alias . "_" . $size_name);
			$this -> utils() -> image_resize($prev_filepath, $filepath_, $size_setting[1], $size_setting[0]);
			$prev_filepath = $filepath_;
		}

		return [
			"alias" => $alias,
			"path" => $filepath,
			"url" => $this -> get_url_by_alias($alias)
		];
	}

	// TODO: this is copy of analog function in entity Image, FIXIT
	public function get_path_to_image(String $alias) {
		return FCONF["users_folder"] . "/{$alias}.jpg";
	}

	// TODO: this is copy of analog function in entity Image, FIXIT
	public function get_url_by_alias(String $alias) {
		return "/" . FCONF["users_folder"] . "/{$alias}.jpg";
	}

	public function create_from_aliases(Array $imgs_aliases, UAdPost $uadpost) {
		$result = [];

		foreach($imgs_aliases as $i => $alias) {
			$res_img = app() -> factory -> creator() -> create_image(
				app() -> sessions -> auth_user() -> id(),
				$uadpost -> id(),
				"UAdPost",
				$alias,
				$i
			);

			if($res_img) {
				$result[] = $res_img;
			}
		}

		return $result;
	}
}
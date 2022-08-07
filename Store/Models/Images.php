<?php

namespace Store\Models;

/**
 * Model for working with user images 
 */
class Images extends \Store\Middleware\Model {
	public $table_name = "images";

	public function __construct() {

	}

	/**
	 * Saving img only on disk
	 * @param  String $img [Image in base64 format. ONLY JPEG]
	 * @return Mixed      
	 */
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

	public function get_path_to_image(String $alias) {
		return FCONF["users_folder"] . "/{$alias}.jpg";
	}

	public function get_url_by_alias(String $alias) {
		return "/" . FCONF["users_folder"] . "/{$alias}.jpg";
	}
}
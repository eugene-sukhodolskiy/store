<?php

namespace Store\Entities;

class Image extends \Store\Middleware\Entity {
	public static $table_name = "images";
	protected static $fields = [
		"id", "uid", "ent_id", "assignment", 
		"alias", "sequence", "create_at", "update_at"
	];

	public function __construct(Int $id, Array $data = []){
		parent::__construct(
			self::$table_name,
			$id,
			$data
		);
	}

	public function image_exists(String $size = "original") {
		return file_exists($this -> get_path_to_image($size));
	}

	public function get_url(String $size = "original") {
		if(!isset(FCONF["image_resize_map"][$size])){
			// TODO: NORMAL ERR VIEW
			dd("Error of size name `{$size}`");
		}

		$postfix = $size == "original" ? "" : "_{$size}";

		return $this -> image_exists($size) 
			? "/" . FCONF["users_folder"] . "/{$this -> alias}{$postfix}.jpg" 
			: $this -> default_image();
	}

	public function get_path_to_image(String $size = "original") {
		if(!isset(FCONF["image_resize_map"][$size])){
			// TODO: NORMAL ERR VIEW
			dd("Error of size name `{$size}`");
		}

		$postfix = $size == "original" ? "" : "_{$size}";
		return FCONF["users_folder"] . "/{$this -> alias}{$postfix}.jpg";
	}

	protected function remove_files() {
		foreach (FCONF["image_resize_map"] as $size => $props) {
			if($this -> image_exists($size)) {
				unlink($this -> get_path_to_image($size));
			}
		}

		return true;
	}

	public function remove() {
		$this -> remove_files();
		return app() -> thin_builder -> delete(self::$table_name, [ ["id", "=", $this -> id()] ]);
	}

	public function default_image() {
		return $this -> image_exists("original") 
			? $this -> get_path_to_image("original") 
			: "/" . FCONF["users_folder"] . "/default-product-img.png";
	}
}
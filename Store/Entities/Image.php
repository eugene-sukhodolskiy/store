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

	public function image_exists() {
		return file_exists($this -> get_path_to_image());
	}

	public function get_url() {
		return $this -> image_exists() 
			? "/" . FCONF["users_folder"] . "/{$this -> alias}.jpg" 
			: $this -> default_image();
	}

	public function get_path_to_image() {
		return FCONF["users_folder"] . "/{$this -> alias}.jpg";
	}

	public function remove() {
		if($this -> image_exists() and unlink($this -> get_path_to_image())) {
			return app() -> thin_builder -> delete(self::$table_name, [ ["id", "=", $this -> id()] ]);
		}

		return false;
	}

	public function default_image() {
		return "/" . FCONF["users_folder"] . "/default-product-img.png";
	}
}
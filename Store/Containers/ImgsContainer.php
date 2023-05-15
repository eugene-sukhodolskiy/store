<?php

namespace Store\Containers;

use \Store\Entities\Image;

class ImgsContainer {
	public Array $imgs = [];
	protected Int $ent_id;
	protected String $assignment;
	public Bool $was_filled = false;
	protected static Array $containers = [];

	public function __construct(Int $ent_id, String $assignment) {
		if(!isset(self::$containers[$assignment])) {
			self::$containers[$assignment] = [];
		}

		self::$containers[$assignment][] = $this;

		$this -> ent_id = $ent_id;
		$this -> assignment = $assignment;
	}

	public function fill_container(): ?Array {
		if($this -> was_filled) {
			return null;
		}

		$this -> imgs = app() -> factory -> getter() -> get_images_by_entity(
			$this -> ent_id, 
			$this -> assignment
		);

		$this -> was_filled = true;

		return $this -> imgs;
	}

	public function add_img(Image $img) {
		$this -> imgs[] = $img;
	}

	public static function fill_containers(): Array {
		foreach (self::$containers as $name => $group) {
			$count_items = count($group);
			$ids = array_map(fn($container) => $container -> get_ent_id(), $group);
			
			$rows = app() -> thin_builder -> select(
				Image::$table_name, 
				Image::get_fields(), 
				[ ["ent_id", "IN", $ids], "AND", ["assignment", "=", $name] ],
				[], "",
				[0, $count_items]
			);
			
			foreach($group as $container) {
				foreach($rows as $row) {
					if($container -> get_ent_id() == $row["ent_id"]) {
						$container -> add_img( new Image($row["id"], $row) );
					}
				}
				
				$container -> was_filled = true;
			}
		}

		return self::$containers;
	}

	public function total_items(): Int {
		return count($this -> imgs);
	}

	public function get_ent_id(): Int {
		return $this -> ent_id;
	}

	public function get_assignment(): String {
		return $this -> assignment;
	}

	public function was_filled(): Bool {
		return $this -> was_filled;
	}

	public function get_imgs(): Array {
		return $this -> imgs;
	}

	public function get_first_img(): ?Image {
		$this -> fill_container();
		return $this -> total_items() ? $this -> imgs[0] : null;
	}
}
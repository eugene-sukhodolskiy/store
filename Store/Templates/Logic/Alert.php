<?php 

namespace Store\Templates\Logic;

class Alert extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		if(!$this -> inside_data["id"]){
			// Err about no id
			$this -> inside_data["content"] = "ID NOT FOUND";
			$this -> inside_data["type"] = "danger";
		}

		$this -> inside_data["id"] = "alert-id-{$this -> inside_data['id']}";
		$this -> inside_data["type"] = $this -> inside_data["type"] ? " alert-{$this -> inside_data['type']}" : " type-default";
		$this -> inside_data["visible"] = $this -> inside_data["visible"] ? " show" : "";
	}
}
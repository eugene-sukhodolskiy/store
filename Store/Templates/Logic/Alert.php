<?php 

namespace Store\Templates\Logic;

class Alert extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		if(!$this -> inside_data["id"]){
			// Err about no id
			dd("Alert component must have ID");
		}

		$this -> inside_data["id"] = "alert-id-{$this -> inside_data['id']}";
		$this -> inside_data["type"] = (isset($this -> inside_data["type"]) and $this -> inside_data["type"]) 
			? " alert-{$this -> inside_data['type']}" 
			: " type-default";
		$this -> inside_data["visible"] = (isset($this -> inside_data["visible"]) and $this -> inside_data["visible"]) 
			? " show" 
			: "";
	}
}
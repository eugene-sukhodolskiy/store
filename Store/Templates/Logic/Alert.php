<?php 

namespace Store\Templates\Logic;

class Alert extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		if(!$data["id"]){
			throw new \Exception("Alert component must have ID");
		}

		$data["id"] = "alert-id-{$data['id']}";
		$data["type"] = (isset($data["type"]) and $data["type"]) 
			? " alert-{$data['type']}" 
			: " type-default";
		$data["visible"] = (isset($data["visible"]) and $data["visible"]) 
			? " show" 
			: "";

		return $data;
	}
}
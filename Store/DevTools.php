<?php

namespace Store;

use \Fury\Modules\Template\Template;

class DevTools {
	protected Array $template_map = [];
	protected Array $templates_counter = [];
	protected Int $total_uniq_template_parts = 0;
	protected Int $total_template_calls = 0;
	protected $root_template;

	public function __construct() {

	}

	public function add_template_to_map($template, $template_name) {
		if(!$this -> root_template) {
			$this -> root_template = $template;
		}

		if(!isset($this -> templates_counter[$template_name])) {
			$this -> templates_counter[$template_name] = 0;
			$this -> total_uniq_template_parts++;
		}

		$this -> templates_counter[$template_name]++;
		$this -> total_template_calls++;
	}

	public function make_template_map(Array $templates) {
		$arr = [];
		foreach($templates as $template) {
			$arr[$template -> template_name] = [
				"calls" => $this -> templates_counter[$template -> template_name], 
				"childs" => $this -> make_template_map($template -> childs())
			];
		}

		return $arr;
	}

	public function show_template_map() {
		if($this -> root_template) {
			$this -> template_map = $this -> make_template_map([ $this -> root_template ]);
			echo (new Template(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("devtools/devtools-panel", [
				"template_map" => $this -> template_map,
				"total_template_calls" => $this -> total_template_calls,
				"total_uniq_template_parts" => $this -> total_uniq_template_parts
			]);
		}
	}
}

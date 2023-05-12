<?php

namespace Store;

use \Fury\Modules\Template\Template;

class DevTools {
	protected Array $template_map = [];
	protected Array $templates_counter = [];
	protected Array $templates_timelog = [];
	protected Int $total_uniq_template_parts = 0;
	protected Int $total_template_calls = 0;
	protected $root_template;

	protected String $action_name = "";
	protected String $action_type = "";
	protected Array $action_params = [];
	protected Float $action_execute_time = 0;

	protected Array $models = [];

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

		if(!isset($this -> templates_timelog[$template_name])) {
			$this -> templates_timelog[$template_name] = [
				"rendering_start" => 0, 
				"rendering_time" => 0
			];
		}

		$this -> templates_timelog[$template_name]["rendering_start"] = microtime(true);
		$this -> templates_counter[$template_name]++;
		$this -> total_template_calls++;
	}

	public function make_template_map(Array $templates) {
		$arr = [];
		foreach($templates as $template) {
			$arr[$template -> template_name] = [
				"calls" => $this -> templates_counter[$template -> template_name], 
				"rendering_time" => $this -> templates_timelog[$template -> template_name]["rendering_time"],
				"childs" => $this -> make_template_map($template -> childs())
			];
		}

		return $arr;
	}

	public function render_template_done(String $template_name) {
		$render_time = microtime(true) - $this -> templates_timelog[$template_name]["rendering_start"];
		$this -> templates_timelog[$template_name]["rendering_time"] += $render_time;
	}

	public function loging_action_call(String $action_name, String $action_type, Array $action_params) {
		$this -> action_name = $action_name;
		$this -> action_type = $action_type;
		$this -> action_params = $action_params;
		$this -> action_execute_time = microtime(true);
	}

	public function loging_action_time() {
		$this -> action_execute_time = microtime(true) - $this -> action_execute_time;
	}

	public function using_model(String $model_name) {
		$this -> models[] = $model_name;
	}

	public function show_template_map() {
		if($this -> root_template) {
			$this -> template_map = $this -> make_template_map([ $this -> root_template ]);
			echo (new Template(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("devtools/devtools-panel", [
				"template_map" => $this -> template_map,
				"total_template_calls" => $this -> total_template_calls,
				"total_uniq_template_parts" => $this -> total_uniq_template_parts,
				
				"action_name" => $this -> action_name,
				"action_type" => $this -> action_type,
				"action_params" => $this -> action_params,
				"action_execute_time" => $this -> action_execute_time,

				"models" => $this -> models,
			]);
		}
	}
}

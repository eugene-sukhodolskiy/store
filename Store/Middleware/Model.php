<?php

namespace Store\Middleware;

class Model extends \Fury\Kernel\Model{
	protected $utils_ins;

	public function __construct(){
		parent::__construct();

		// TODO: Add normal event to Fury\Kernel\Model
		app() -> devtools -> using_model(get_class($this));
	}

	public function utils(){
		if(!$this -> utils_ins){
			$this -> utils_ins = new \Store\Utils();
		}

		return $this -> utils_ins;
	}

	public function thin_builder(){
		return app() -> thin_builder;
	}
}
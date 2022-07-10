<?php

namespace Store\Middleware;

class Model extends \Fury\Kernel\Model{
	protected $utils_ins;

	public function __construct(){
		parent::__construct();
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
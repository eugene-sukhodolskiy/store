<?php

namespace Fury\Drivers;

class ThinBuilderDriver implements \Fury\Modules\ThinBuilder\DriverInterface{
	protected $bootstrap;

	public function __construct(\Fury\Kernel\Bootstrap $bootstrap){
		$this -> bootstrap = $bootstrap;
	}

	public function event_ready_sql(String $sql){
		events() -> module_call('ThinBuilder.ready_sql', ['sql' => $sql]);
	}

	public function event_query(String $sql, $result){
		events() -> module_call('ThinBuilder.query', [
			'sql' => $sql, 
			'result' => $result
		]);
	}
}
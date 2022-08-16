<?php

namespace Store;

use \Fury\Modules\Router\Router;
use \Fury\Modules\ThinBuilder\ThinBuilder;
use \Fury\Modules\ErrorHandler\ErrorHandler;
use \Store\Factory\Factory;

class App extends \Fury\Kernel\BaseApp{
	public $routes;
	public $router;
	public $events_handlers;
	public $error_handlers;
	public $thin_builder;
	public $console_flag;

	// CUSTOM
	public $utils;
	public $sessions;
	public $factory;

	public function __construct(){
		parent::__construct();

		global $argv;
		$this -> console_flag = isset($argv) ? true : false;
		$this -> app_init();
	}

	public function app_init(){
		$this -> error_handlers = new ErrorHandler();
		$this -> router = new Router();
		$this -> routes = new Routes($this -> router);
		$this -> thin_builder = new ThinBuilder(FCONF['db']);
		$this -> events_handlers = new EventsHandlers();
		$this -> events_handlers -> handlers();

		// CUSTOM
		$this -> utils = new Utils();
		$this -> sessions = new Sessions();
		$this -> factory = new Factory();
	}

	public function root_folder(){
		list($root) = explode('Store', __DIR__);
		return $root;
	}

}

new App();
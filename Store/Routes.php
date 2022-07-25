<?php

namespace Store;

class Routes {
	/**
	 * Instance of Router module
	 * @var [type]
	 */
	protected $router;

	/**
	 * Controllers folder
	 * @var [type]
	 */
	protected $cf;

	/**
	 * Controllers namespace
	 * @var [type]
	 */
	protected $cn;

	/**
	 * @method __construct
	 * @param \Fury\Modules\Router\Router $router [description]
	 */
	public function __construct(\Fury\Modules\Router\Router $router) {
		$this -> router = $router;
		$this -> cf = FCONF['controllers_folder'];
		$this -> cn = "\\" . FCONF['app_name'] . "\\" . FCONF['controllers_folder'];
	}

	public function routes_init() {
		$this -> uri_routes();
		$this -> get_routes();
		$this -> post_routes();
	}

	protected function uri_routes() {
		$this -> router -> uri('/', "{$this -> cn}\\Index@index");
		$this -> router -> uri('/auth/signup.html', "{$this -> cn}\\Auth@signup_page");
		$this -> router -> uri('/auth/signin.html', "{$this -> cn}\\Auth@signin_page");
	}

	protected function get_routes() {
	}

	protected function post_routes() {
		$this -> router -> post(
			[ "email", "password", "password_again" ], 
			"{$this -> cn}\\Auth@signup", 
			"/api/signup"
		);

		$this -> router -> post(
			[ "email", "password" ], 
			"{$this -> cn}\\Auth@signin",
			"/api/signin"
		);
	}

	/**
	 * urlto, get url by action name [with arguments]
	 * @var String   $action_name - Action name, like a "HelloController@world_action"
	 * @var Array   $url_args - Assoc array with arguments (ONLY FOR REQUEST TYPE GET)
	 * 
	 * @return String  Url to action, ready for use
	 */
	public function urlto(String $action_name, Array $url_args = []) {
		$routes_map = $this -> router -> get_routes_map();
		$desired_action = "{$this -> cn}\\{$action_name}";
		foreach($routes_map["uri"] as $url => $action) {
			if($action == $desired_action) {
				return $url;
			}
		}

		foreach($routes_map["post"] as $url_pattern => $action){
			if($action == $desired_action) {
				list($url) = explode("?", $url_pattern); 
				return $url;
			}
		}

		foreach($routes_map["get"] as $url_pattern => $action){
			if($action == $desired_action) {
				list($url, $param_names) = explode("?", $url_pattern); 
				if(count($url_args)) {
					$param_names = explode("&", $param_names);
					$params = array_flip($param_names);
					foreach($params as $key => $val) {
						if(!isset($url_args[$key])) {
							continue;
						}

						$params[$key] = $url_args[$key];
					}
				}else{
					$params = [];
				}

				return $url . "?" . http_build_query($params);
			}
		}
	}
}
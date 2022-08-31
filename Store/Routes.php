<?php

namespace Store;

class Routes {
	/**
	 * Instance of Router module
	 */
	protected \Fury\Modules\Router\Router $router;

	/**
	 * Controllers folder
	 */
	protected String $cf;

	/**
	 * Controllers namespace
	 */
	protected String $cn;

	/**
	 * @method __construct
	 * @param \Fury\Modules\Router\Router $router [description]
	 */
	public function __construct(\Fury\Modules\Router\Router $router) {
		$this -> router = $router;
		$this -> cf = FCONF["controllers_folder"];
		$this -> cn = "\\" . FCONF["app_name"] . "\\" . FCONF["controllers_folder"];
	}

	public function routes_init() {
		$this -> uri_routes();
		$this -> get_routes();
		$this -> post_routes();
	}

	protected function uri_routes() {
		$this -> router -> uri("/", "{$this -> cn}\\SearchController@search_page");
		$this -> router -> uri("/auth/signup.html", "{$this -> cn}\\AuthController@signup_page");
		$this -> router -> uri("/auth/signin.html", "{$this -> cn}\\AuthController@signin_page");
		$this -> router -> uri('/uadpost/$alias', "{$this -> cn}\\UAdPostController@view_page");
		$this -> router -> uri("/uadpost/f/create.html", "{$this -> cn}\\UAdPostController@create_page");
		$this -> router -> uri('/uadpost/f/remove/$uadpost_id', "{$this -> cn}\\UAdPostController@remove");
		$this -> router -> uri('/uadpost/edit/$alias', "{$this -> cn}\\UAdPostController@edit_page");
		$this -> router -> uri('/not-found.html', "{$this -> cn}\\InfoPagesController@not_found_page");
		$this -> router -> uri(
			'/profile/settings.html', 
			"{$this -> cn}\\ProfileSettingsController@profile_settings_page"
		);
		$this -> router -> uri(
			'/profile/uadposts/$state', 
			"{$this -> cn}\\UAdPostController@ready_uadposts_cur_user"
		);
	}

	protected function get_routes() {
		$this -> router -> get(["redirect_to"], "{$this -> cn}\\AuthController@signout_page", "/auth/signout.html");
		$this -> router -> get(
			[ "uadpost_id", "state" ], 
			"{$this -> cn}\\UAdPostController@change_uadpost_state", 
			"/profile/uadposts/change-state.html"
		);
	}

	protected function post_routes() {
		$this -> router -> post(
			[ "email", "password", "password_again" ], 
			"{$this -> cn}\\AuthController@signup", 
			"/auth/signup"
		);

		$this -> router -> post(
			[ "email", "password" ], 
			"{$this -> cn}\\AuthController@signin",
			"/auth/signin"
		);

		$this -> router -> post(
			[ "img" ], 
			"{$this -> cn}\\ImgUploaderController@upload_img",
			"/upload/f/img"
		);
		
		$this -> router -> post(
			[ "title" ], 
			"{$this -> cn}\\UAdPostController@create",
			"/uadpost/f/create"
		);

		$this -> router -> post(
			[ "title" ],
			"{$this -> cn}\\UAdPostController@create_draft",
			"/uadpost/f/create-draft"
		);

		$this -> router -> post(
			[ "uadpost_id", "title" ], 
			"{$this -> cn}\\UAdPostController@update",
			"/uadpost/f/update"
		);

		$this -> router -> post(
			[ "uadpost_id", "title" ], 
			"{$this -> cn}\\UAdPostController@update_draft",
			"/uadpost/f/update-draft"
		);

		$this -> router -> post(
			[ "first_name", "second_name", "phone_number", "imgs" ], 
			"{$this -> cn}\\ProfileSettingsController@update",
			"/profile/f/update"
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
				foreach($url_args as $arg_name => $arg_val) {
					$url = str_replace("\${$arg_name}", $arg_val, $url);
				}

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
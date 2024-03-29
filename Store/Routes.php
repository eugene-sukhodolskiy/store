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
		// pages
		$this -> router -> uri("/", "{$this -> cn}\\SearchController@search_page");
		$this -> router -> uri('/not-found.html', "{$this -> cn}\\InfoPagesController@not_found_page");
		$this -> router -> uri(
			'/favoutites.html', 
			"{$this -> cn}\\FavouritesController@favourites_page"
		);
		
		// auth
		$this -> router -> uri("/auth/signup.html", "{$this -> cn}\\AuthController@signup_page");
		$this -> router -> uri("/auth/signin.html", "{$this -> cn}\\AuthController@signin_page");
		
		// uadpost
		$this -> router -> uri('/uadpost/$alias', "{$this -> cn}\\UAdPostController@view_page");
		$this -> router -> uri("/uadpost/f/create.html", "{$this -> cn}\\UAdPostController@create_page");
		$this -> router -> uri('/uadpost/f/remove/$uadpost_id', "{$this -> cn}\\UAdPostController@remove");
		$this -> router -> uri('/uadpost/edit/$alias', "{$this -> cn}\\UAdPostController@edit_page");
		$this -> router -> uri(
			'/uadpost/f/regenerate-keywords/$uadpost_alias',
			"{$this -> cn}\\UAdPostController@regenerate_keywords"
		);
		$this -> router -> uri(
			'/uadpost/$uap_id/view-phone-number', 
			"{$this -> cn}\\UAdPostController@view_phone_number"
		);
		
		// profile
		$this -> router -> uri(
			'/profile/settings.html', 
			"{$this -> cn}\\ProfileSettingsController@profile_settings_page"
		);
		$this -> router -> uri(
			'/profile/uadposts/$state', 
			"{$this -> cn}\\UAdPostController@ready_uadposts_cur_user_page"
		);
		
		$this -> router -> uri(
			'/profile/orders/$utype/exclude-states', 
			function($args) {
				return app() -> utils -> redirect(
					app() -> routes -> urlto("OrderController@orders_cur_user_page", ["utype" => $args["utype"]])
				);
			}
		);
		
		$this -> router -> uri(
			'/profile/orders/$utype', 
			"{$this -> cn}\\OrderController@orders_cur_user_page"
		);

		$this -> router -> uri(
			'/profile/orders/change-state/$state/$order_id', 
			"{$this -> cn}\\OrderController@change_order_state"
		);

		$this -> router -> uri(
			'/profile/$user_alias', 
			"{$this -> cn}\\ProfileController@profile_page"
		);

		$this -> router -> uri(
			'/profile', 
			"{$this -> cn}\\ProfileController@goto_self_profile"
		);

		// orders
		$this -> router -> uri(
			'/new-order/$uadpost_alias', 
			"{$this -> cn}\\OrderController@new_order_page"
		);

		$this -> router -> uri(
			'/order/success/$order_id', 
			"{$this -> cn}\\OrderController@order_success_page"
		);

		$this -> router -> uri("/test", function(){
			return (new \Fury\Modules\Template\Template(PROJECT_FOLDER, FCONF['templates_folder'])) -> make("site/test", [
				"page_title" => "TEST",
				"page_alias" => "test"
			]);
		});
	}

	protected function get_routes() {
		$this -> router -> get(["redirect_to"], "{$this -> cn}\\AuthController@signout_page", "/auth/signout.html");
		$this -> router -> get(
			[ "uadpost_id", "state" ], 
			"{$this -> cn}\\UAdPostController@change_uadpost_state", 
			"/profile/uadposts/change-state.html"
		);

		$this -> router -> get(
			[ "img_name" ],
			"{$this -> cn}\\ImgUploaderController@show_img",
			'/user/image.html',
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
			[ "first_name", "second_name", "phone_number", "imgs", 
				"lat", "lng", "country_ru", "country_en", "region_ru", 
				"region_en", "city_ru", "city_en" ], 
			"{$this -> cn}\\ProfileSettingsController@update",
			"/profile/f/update"
		);

		$this -> router -> post(
			[ "uadpost_id" ],
			"{$this -> cn}\\FavouritesController@make",
			"/favourites/f/make"
		);

		$this -> router -> post(
			[ "uap_id", "price", "currency", "single_price", 
			"comment", "delivery_method", "nova_poshta_addr", 
			"np_city_ref", "np_city_name", "np_department" ],
			"{$this -> cn}\\OrderController@create",
			"/order/f/create"
		);

		$this -> router -> post(
			[ "req" ],
			"{$this -> cn}\\NPDeliveryController@api_req",
			"/tech/nova_poshta_api"
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
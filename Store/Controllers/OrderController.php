<?php

namespace Store\Controllers;

use \Store\Entities\UAdPost;
use \Store\Models\UAdPosts;
use \Store\Models\Orders;

class OrderController extends \Store\Middleware\Controller {
	public function new_order_page($uadpost_alias) {
		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		$uadpost_alias = urldecode($uadpost_alias);
		$uadpost_alias = addslashes($uadpost_alias);
		$uadposts = app() -> factory -> getter() -> get_uadposts_by("alias", $uadpost_alias, 1);
		if(!count($uadposts)) {
			return app() -> utils -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		if($uadposts[0] -> uid == app() -> sessions -> auth_user() -> id()) {
			return app() -> utils -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}
		
		return $this -> new_template() -> make("site/new.order", [
			"page_title" => "Оформление заказа",
			"page_alias" => "page new-order",
			"uadpost" => $uadposts[0]
		]);
	}

	public function create(
		Int $uap_id, 
		Float $price, 
		String $currency, 
		Float $single_price, 
		String $comment, 
		Int $delivery_method,
		String $nova_poshta_addr,
		String $np_city_ref,
		String $np_city_name,
		String $np_department
	) {
		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("not_found_any_sessions");
		}

		$uap_id = intval($uap_id);
		if(!(new UAdPosts()) -> is_exists($uap_id)) {
			return app() -> utils -> response_error("uadpost_not_exist");
		}

		$uadposts = app() -> factory -> getter() -> get_uadposts_by("id", $uap_id); 
		if(!count($uadposts)) {
			return app() -> utils -> response_error("undefined_error");
		}

		$uadpost = $uadposts[0];
		if($uadpost -> state != "published") {
			return app() -> utils -> response_error("uadpost_no_available");
		}

		$auth_user = app() -> sessions -> auth_user();
		if($auth_user -> id == $uadpost -> uid) {
			return app() -> utils -> response_error("undefined_error");	
		}

		if($uadpost -> price != $price or $uadpost -> currency != $currency or $uadpost -> single_price != $single_price) {
			return app() -> utils -> response_error("price_was_changed");
		}

		$comment = trim(strip_tags($comment));

		// Handling delivery method data

		$orders = new Orders();
		$result = $orders -> create($auth_user -> id, $uap_id, $price, $currency, $single_price, $comment, $delivery_method);

		if(!$result) {
			return app() -> utils -> response_error("fail_creating_order");
		}

		return app() -> utils -> response_success([
			"details" => [
				"order_id" => $result -> id,
				"uap_id" => $uap_id, 
				"price" => $price, 
				"currency" => $currency, 
				"comment" => $comment, 
				"delivery_method" => $delivery_method
			]
		]);
	}

	public function order_success_page($order_id) {
		$orders = app() -> factory -> getter() -> get_orders_by("id", $order_id, 1);
		if(!count($orders)) {
			return app() -> utils -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		$order = $orders[0];
		if(time() - strtotime($order -> create_at) > 60 * 30 || !$order -> uadpost()) {
			return app() -> utils -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		return $this -> new_template() -> make("site/order.success", [
			"page_title" => "Заказ оформлен",
			"page_alias" => "page order-success",
			"order" => $order
		]);
	}

	public function orders_cur_user_page($utype, $excluding = "") {
		if(!app() -> sessions -> is_auth()) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("AuthController@signin_page") );
		}

		if(!isset(FCONF["utype_map"][$utype])) {
			return $this -> utils() -> redirect( app() -> routes -> urlto("InfoPagesController@not_found_page") );
		}

		$pnum = isset($_GET["np"]) ? intval($_GET["pn"]) : 1;
		$states = FCONF["orders"]["existing_states"];
		$excluding = explode("+", $excluding);
		$including_states = array_filter($states, function($item) use($excluding) {
			return !in_array($item, $excluding);
		});

		$user = app() -> sessions -> auth_user();
		$total = $user -> total_orders($utype, $including_states);
		$orders = $total ? $user -> get_orders($utype, $pnum ? $pnum : 1, $including_states) : [];
		
		switch($utype) {
			case "seller":
				$page_title = "Мои продажи";
			break;
			case "customer": 
				$page_title = "Мои покупки";
			break;
		}

		return $this -> new_template() -> make("site/user.orders", [
			"page_title" => $page_title,
			"page_alias" => "page user-orders",
			"orders" => $orders,
			"total_orders" => $total,
			"per_page" => FCONF["user_orders_per_page"],
			"utype" => $utype,
			"excluding_states" => $excluding
		]);
	}

	public function confirm_order($order_id) {
		$order_id = intval($order_id);

		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("not_found_any_sessions");
		}

		$orders = app() -> factory -> getter() -> get_orders_by("id", $order_id, 1);
		$order = count($orders) ? $orders[0] : null;

		if(!$order) {
			return app() -> utils -> response_error("uadpost_not_exist");
		}

		if(app() -> sessions -> auth_user() -> id != $order -> seller_id) {
			return app() -> utils -> response_error("fail_access_to_order");
		}

		if($order -> state == "canceled") {
			return app() -> utils -> response_error("fail_access_to_order");
		}

		if($order -> state == "unconfirmed") {
			if(!$order -> confirm()) {
				return app() -> utils -> response_error("undefined_error");
			}
		}

		return app() -> utils -> response_success([
			"order_id" => $order -> id,
			"msg" => app() -> utils -> get_msg_by_alias("confirmed"),
			"order_state_label" => 
				(new \Store\Templates\Logic\OrderStateLabel(PROJECT_FOLDER, FCONF['templates_folder'])) 
					-> make("site/components/order/order-state-label.php", [
						"order" => $order,
						"utype" => "seller"
					])
		]);
	}

	public function cancel_order($order_id) {
		$order_id = intval($order_id);

		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("not_found_any_sessions");
		}

		$orders = app() -> factory -> getter() -> get_orders_by("id", $order_id, 1);
		$order = count($orders) ? $orders[0] : null;

		if(!$order) {
			return app() -> utils -> response_error("uadpost_not_exist");
		}

		$utype = app() -> sessions -> auth_user() -> id == $order -> customer_id ? "customer" : "seller";

		if($order -> state == "confirmed" and $utype == "customer") {
			return app() -> utils -> response_error("fail_access_to_order");
		}

		if($order -> state != "canceled") {
			if(!$order -> cancel()) {
				return app() -> utils -> response_error("undefined_error");
			}
		}

		return app() -> utils -> response_success([
			"order_id" => $order -> id,
			"msg" => app() -> utils -> get_msg_by_alias("canceled"),
			"order_state_label" => 
				(new \Store\Templates\Logic\OrderStateLabel(PROJECT_FOLDER, FCONF['templates_folder'])) 
					-> make("site/components/order/order-state-label.php", [
						"order" => $order,
						"utype" => $utype
					])
		]);	
	}

	public function change_order_state($order_id, $state) {
		$order_id = intval($order_id);
		$data_map = [
			"cancel" => ["msg" => app() -> utils -> get_msg_by_alias("canceled")],
			"confirm" => ["msg" => app() -> utils -> get_msg_by_alias("confirmed")],
			"complete" => ["msg" => app() -> utils -> get_msg_by_alias("completed")],
		];

		$states = array_keys($data_map);

		if(!app() -> sessions -> is_auth()) {
			return app() -> utils -> response_error("not_found_any_sessions");
		}

		if(!in_array($state, $states)) {
			return app() -> utils -> response_error("selected_state_not_exists");
		}

		$orders = app() -> factory -> getter() -> get_orders_by("id", $order_id, 1);
		$order = count($orders) ? $orders[0] : null;

		if(!$order) {
			return app() -> utils -> response_error("uadpost_not_exist");
		}

		$utype = app() -> sessions -> auth_user() -> id == $order -> customer_id ? "customer" : "seller";

		// for canceling
		if($state == "cancel") {
			if($order -> state == "canceled" or $order -> state == "completed") {
				return app() -> utils -> response_error("undefined_error");
			}

			if($order -> state == "confirmed" and $utype == "customer") {
				return app() -> utils -> response_error("fail_access_to_order");
			}

			if(!$order -> cancel()) {
				return app() -> utils -> response_error("undefined_error");
			}
		}

		// for confirming
		if($state == "confirm") {
			if($utype != "seller") {
				return app() -> utils -> response_error("fail_access_to_order");
			}

			if($order -> state == "canceled" or $order -> state == "completed") {
				return app() -> utils -> response_error("fail_access_to_order");
			}

			if($state == "confirm" and $order -> state == "unconfirmed") {
				if(!$order -> confirm()) {
					return app() -> utils -> response_error("undefined_error");
				}
			}
		}

		// for complete
		if($state == "complete") {
			if($order -> state != "confirmed") {
				return app() -> utils -> response_error("undefined_error");
			}

			if(time() - strtotime($order -> create_at) < FCONF["orders"]["timeout_of_state_complete"]) {
				return app() -> utils -> response_error("undefined_error");
			}		

			if(!$order -> complete()) {
				return app() -> utils -> response_error("undefined_error");
			}
		}

		return app() -> utils -> response_success([
			"order_id" => $order -> id,
			"msg" => $data_map[$state]["msg"],
			"order_state_label" => 
				(new \Store\Templates\Logic\OrderStateLabel(PROJECT_FOLDER, FCONF['templates_folder'])) 
					-> make("site/components/order/order-state-label.php", [
						"order" => $order,
						"utype" => $utype
					])
		]);
	}

	public function nova_poshta_api($nova_poshta_api_request) {
		$url = 'https://api.novaposhta.ua/v2.0/json/';
		$data = json_decode($nova_poshta_api_request, true);
		$data["apiKey"] = FCONF["nova_poshta"]["api_key"];
		$data["methodProperties"]["Language"] = "RU";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($curl);

		curl_close($curl);

		if (!$response) {
			return $this -> utils() -> response_error("server_not_available");
		}
		
		return $this -> utils() -> response_success(json_decode($response, true));
	}
}
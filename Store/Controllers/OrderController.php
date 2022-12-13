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

	public function create($uap_id, $price, $currency, $comment, $delivery_method) {
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

		if($uadpost -> price != $price or $uadpost -> currency != $currency) {
			return app() -> utils -> response_error("price_was_changed");
		}

		$comment = trim(strip_tags($comment));

		// Handling delivery method data

		$orders = new Orders();
		$result = $orders -> create($auth_user -> id, $uap_id, $price, $currency, $comment, $delivery_method);

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
}
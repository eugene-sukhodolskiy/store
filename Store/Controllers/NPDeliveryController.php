<?php

namespace Store\Controllers;

class NPDeliveryController extends \Store\Middleware\Controller {
	public function api_req($req) {
		$url = FCONF["nova_poshta"]["api_url"];
		$data = json_decode($req, true);
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
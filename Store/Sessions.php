<?php

namespace Store;
use \Store\Entities\Session;

class Sessions {
	protected $auth_user_instance;
	protected $current_session_instance;
	protected $table_name = "sessions";

	public function create(Int $uid) {
		$token = uniqid($uid . time());
		$result = app() -> thin_builder -> insert($this -> table_name, [
			"uid" => $uid,
			"token" => $token,
			"create_at" => date("Y-m-d H:i:s")
		]);

		return $result ? $token : false;
	}

	public function close($token) {
		$session = $this -> get_session_by_token($token);
		if(!$session) {
			return false;
		}

		$session -> set("state", 2);
		return $session -> update();
	}

	public function close_current_session() {
		return $this -> close($this -> get_auth_token());
	}

	public function set_session(String $token) {
		setcookie("auth_token", $token, time() + 3600 * 24 * 30, "/");
	}

	public function init_session(Int $uid) {
		$token = $this -> create($uid);
		
		if($token){
			$this -> set_session($token);
		}

		return $token;
	}

	public function is_auth() {
		return $this -> get_current_session() ? true : false;
	}

	public function get_auth_token() {
		return isset($_COOKIE["auth_token"]) ? $_COOKIE["auth_token"] : null;
	}

	public function auth_user() {
		if(!$this -> get_auth_token()) {
			return null;
		}

		if(!$this -> auth_user_instance) {
			$session = $this -> get_current_session();
			if(!$session){
				return null;
			}

			$this -> auth_user_instance = new User($session["uid"]);
		}

		return $this -> auth_user_instance;
	}

	public function get_current_session() {
		if(!$this -> current_session_instance){
			$token = $this -> get_auth_token();
			if(!$token) {
				return null;
			}

			$this -> current_session_instance = $this -> get_session_by_token($token);
			if($this -> current_session_instance){
				$this -> current_session_instance -> set("last_using_at", date("Y-m-d H:i:s")) -> update();
			}
		}

		return $this -> current_session_instance;
	}

	public function get_session_by_token(String $token) {
		$result = app() -> thin_builder -> select(
			$this -> table_name,
			["id"],
			[ 
				["token", "=", $token],
				"AND",
				["state", "=", 1]
			]
		);

		if(!$result) {
			return null;
		}

		return new Session(intval($result[0]["id"]));
	}
}
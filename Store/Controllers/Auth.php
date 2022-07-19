<?php

namespace Store\Controllers;

use \Store\Models\AuthModel;
use \Store\Entities\User;

class Auth extends \Store\Middleware\Controller {
	public function signup_page() {
		return $this -> new_template() -> make('site/signup', [
			'page_title' => 'Регистрация',
			'page_alias' => 'page signup'
		]);
	}

	public function signup($email, $password, $password_again) {
		if(strlen($email) < 4 or !strpos($email, "@") or !strpos($email, ".")) {
			return json_encode([
				"status" => false,
				"err_in_field" => [ "email" ],
				"error_alias" => "incorrect_email",
				"error_msg" => "Не корректный E-mail"
			]);
		}

		if(strlen($password) < 8) {
			return json_encode([
				"status" => false,
				"err_in_field" => [ "password" ],
				"error_alias" => "too_short_password",
				"error_msg" => "Слишком короткий пароль"
			]);
		}

		if($password != $password_again) {
			return json_encode([
				"status" => false,
				"err_in_field" => [ "password", "password_again" ],
				"error_alias" => "different_passwords",
				"error_msg" => "Пароли не совпадают"
			]);
		}

		if(User::is_exists_by("email", $email)){
			return json_encode([
				"status" => false,
				"err_in_field" => [ "email" ],
				"error_alias" => "email_already_exists",
				"error_msg" => "Пользователь с таким E-mail уже существует"
			]);
		}

		$auth = new AuthModel();
		$user = $auth -> signup($email, $password);

		if(!$user) {
			return json_encode([
				"status" => false,
				"error_alias" => "undefined_error",
				"error_msg" => "Ой, что-то пошло не так"
			]);
		}

		// force login user
		return json_encode([
			"status" => true
		]);
	}

	public function signin() {

	}

	public function signout() {

	}
}
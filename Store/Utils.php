<?php

namespace Store;

class Utils {
	public function redirect(String $url) {
		return header("Location: {$url}");
	}

	public function gen_alias_from_email(String $email) {
		list($alias) = explode("@", $email);
		return uniqid() . "-" . $alias;
	}

	public function table_row_is_exists(\Fury\Modules\ThinBuilder\ThinBuilder $tb_instance, String $tablename, String $field_name, String $value) {
		return $tb_instance -> count($tablename, [ [$field_name, "=", $value] ]) ? true : false;
	}

	public function response_error(String $error_alias, Array $failed_fields = [], Array $extra = []) {
		return json_encode(array_merge([		
			"status" => false,
			"failed_fields" => $failed_fields,
			"error_alias" => $error_alias,
			"msg" => $this -> get_msg_by_alias($error_alias)
		], $extra));
	}

	public function response_success(Array $resp_data = []) {
		return json_encode([ 
			"status" => true,
			"response" => $resp_data
		]);
	}

	public function get_msg_by_alias(String $alias){
		return FCONF['text_msgs'][$alias];
	}
}
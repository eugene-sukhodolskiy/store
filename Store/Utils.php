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
}
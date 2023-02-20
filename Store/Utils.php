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
			"error_alias" => $error_alias,
			"failed_fields" => $failed_fields,
			"msg" => $this -> get_msg_by_alias($error_alias)
		], $extra));
	}

	public function response_success(Array $resp_data = []) {
		return json_encode([ 
			"status" => true,
			"data" => $resp_data
		]);
	}

	public function get_msg_by_alias(String $alias){
		return FCONF['text_msgs'][$alias];
	}

	public function compress_image(String $source, String $destination, Int $quality) {
		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}

	public function image_resize(String $file_name, String $output, Int $quality, Int $width, $height = 0) {
		list($wid, $ht) = \getimagesize($file_name);
		$r = $wid / $ht;
		$height = $height ? $height : $width / $r;

		if ($width / $height > $r) {
			$new_width = $height * $r;
			$new_height = $height;
		} else {
			$new_height = $width / $r;
			$new_width = $width;
		}
		
		$source = \imagecreatefromjpeg($file_name);
		$dst = \imagecreatetruecolor($new_width, $new_height);
		\imagecopyresampled($dst, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
		\imagejpeg($dst, $output, $quality);
	}

	public function transliterate_cyr_lat(String $str) {
		$cyr = [
			'Љ','Њ','Џ','џ','ш','ђ','ч','ћ','ж','љ','њ','Ш','Ђ','Ч','Ћ', 
			'Ж','Ц','ц','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н',
			'о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 
			'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р',
			'С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','Є','є',
			'Ї','ї','і'
		];

		$lat = [
			'Lj','Nj','Dž','dž','š','đ','č','ć','ž','lj','nj','Š','Đ','Č','Ć','Ž','C','c',
			'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s',
			't','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V',
			'G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F',
			'H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya','Ye','ye','Yi','yi','i',
		];

		return str_replace($cyr, $lat, $str);
	}

	public function gen_from_text_alias(String $str) {
		return str_replace(
			[" ", ".", ",", "@", "!", "#", '$', "%", "^", "&", "?", "*", "(", ")", "+", "[", "]", "{", "}", ":", ";", "/", "<", ">", "\\"], 
			["-", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""], 
			$this -> transliterate_cyr_lat(strtolower($str))
		);
	}

	public function get_limits_for_select_query(Int $per_page) {
		$current_page = max(1, intval(isset($_GET["pn"]) ? $_GET["pn"] : 0));
		$from = ($current_page - 1) * $per_page;
		return [$from, $per_page];
	}

	public function lang_mistake_flip(String $str) {
		$str = str_replace(
			["{", "}", "!", "@", "#", '$', "%", "^", "&", "*", "(", ")"],
			["", "", "", "", "", '$', "", "", "", "", "", ""],
			$str
		);
		$vocabluary_lat = "`qwertyuiop[]asdfghjkl;'zxcvbnm,. {}<>-+_1234567890";
		$vocabluary_cyr = "ёйцукенгшщзхъфывапролджэячсмитьбю хъбю-+_1234567890";

		$len = mb_strlen($str);
		$new_str = "";
		for($i = 0; $i < $len; $i++) {
			$in_lat = mb_strpos($vocabluary_lat, mb_substr($str, $i, 1));
			$in_cyr = mb_strpos($vocabluary_cyr, mb_substr($str, $i, 1));

			if($in_lat !== false) {
				$new_str .= mb_substr($vocabluary_cyr, $in_lat, 1);
				continue;
			}

			if($in_cyr !== false) {
				$new_str .= mb_substr($vocabluary_lat, $in_cyr, 1);
				continue;
			}

			$new_str .= $str[$i];
		}

		return $new_str;
	}

	public function get_default_val_for_type(String $type) {
		$default_val = null;
		$types_default_vals = [
			"Int" => 0,
			"String" => "",
			"JSON" => "{}",
			"Float" => 0
		];

		return $types_default_vals[$type];
	}

	public function link_is_active(String $action, Array $params = []) {
		return app() -> routes -> urlto($action, $params) == app() -> router -> uri;
	}

	public function formatted_timestamp(String $timestamp, $with_clock = false) {
		if($with_clock) {
			return date("d.m.Y H:i", strtotime($timestamp));
		}

		return date("d.m.Y", strtotime($timestamp));
	}

	public function get_delivery_method_map() {
		return [
			1 => "Новая почта",
			2 => "Укр почта",
			3 => "Самовивоз",
			4 => "Другое",
		];
	}
}
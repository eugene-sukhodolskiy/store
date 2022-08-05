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

	public function image_resize(String $file_name, String $output, $quality = 100, Int $width, $height = 0) {
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
}
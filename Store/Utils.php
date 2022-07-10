<?php

namespace Store;

class Utils{
	public function redirect(String $url){
		return header("Location: {$url}");
	}
}
<?php

namespace Store\Templates\Logic;

class SiteBase extends \Fury\Modules\Template\Template {
	public function heir_manipulation(Array $data): Array {
		$data["is_auth"] = app() -> sessions -> is_auth();
		return $data;
	}
}
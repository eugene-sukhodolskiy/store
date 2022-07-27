<?php

namespace Store\Templates\Logic;

class SiteBase extends \Fury\Modules\Template\Template {
	public function heir_manipulation() {
		$this -> inside_data["is_auth"] = app() -> sessions -> is_auth();
	}
}
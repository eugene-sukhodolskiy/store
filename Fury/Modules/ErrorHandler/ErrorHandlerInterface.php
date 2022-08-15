<?php

namespace Fury\Modules\ErrorHandler;

interface ErrorHandlerInterface {
	protected Array $important_errors;

	public function create(String $msg);

	public function fatal_error_handler();

	public function error_handler(Int $errno, String $errstr, String $errfile, Int $errline);

	protected function error_is_important(String $errtype);


}
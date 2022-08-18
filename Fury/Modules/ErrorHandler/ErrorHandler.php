<?php

namespace Fury\Modules\ErrorHandler;

/**
 * Class: ErrorHandler
 * @author Eugene Sukhodolskiy <eugene.sukhodolskiy@gmail.com>
 * @version 0.1
 * Date: 19.07.2022
 */

class ErrorHandler{
	/**
	 * With all errs in source view
	 */
	private Array $errs_src;
	
	/**
	 * What errors need to be displayed and logined
	 */
	private Array $important_errors;

	public function __construct(){
		$this -> important_errors = FCONF["error_handler"]["important_errors"];
		
		if(!FCONF["debug"]){
			error_reporting(-1);
		}else{
			error_reporting(0);
		}

		$this -> set_err_handler();
	}

	/**
	 * Set custom error handler
	 */
	public function set_err_handler(){
		set_error_handler([$this, "error_handler"], E_ALL);
		register_shutdown_function([$this, "fatal_error_handler"]);
		// set_exception_handler([$this, "exception_handler"]);
	}

	// FIXME
	public function exception_handler(\Exception $e) {
		$this -> error_handler(
			$e -> getCode(),
			$e -> getMessage(),
			$e -> getFile(),
			$e -> getLine()
		);
	}

	/**
	 * Set custom FATAL error handler
	 */
	public function fatal_error_handler(){
		$error = error_get_last();
		if ($error){
			$this -> view_fatal_error($error["type"], $error["message"], $error["file"], $error["line"]);
		}
	}

	/**
	 * Handle of error
	 */
	public function error_handler(Int $errno, String $errstr, String $errfile, Int $errline){
		$err_type = $this -> get_err_type($errno);
		if(!$this -> error_is_important($err_type)){
			return true;
		}

		$this -> view_fatal_error($errno, $errstr, $errfile, $errline);
		return true;
	}

	/**
	 * Get type of error
	 */
	private function get_err_type(Int $errno){
		$errors = array(
			E_ERROR => "E_ERROR",
			E_WARNING => "E_WARNING",
			E_PARSE => "E_PARSE",
			E_NOTICE => "E_NOTICE",
			E_CORE_ERROR => "E_CORE_ERROR",
			E_CORE_WARNING => "E_CORE_WARNING",
			E_COMPILE_ERROR => "E_COMPILE_ERROR",
			E_COMPILE_WARNING => "E_COMPILE_WARNING",
			E_USER_ERROR => "E_USER_ERROR",
			E_USER_WARNING => "E_USER_WARNING",
			E_USER_NOTICE => "E_USER_NOTICE",
			E_STRICT => "E_STRICT",
			E_RECOVERABLE_ERROR => "E_RECOVERABLE_ERROR",
			E_DEPRECATED => "E_DEPRECATED",
			E_USER_DEPRECATED => "E_USER_DEPRECATED",
		);

		return isset($errors[$errno]) ? $errors[$errno] : "EXCEPTION";
	}

	/**
	 * Get lines with errors from file
	 */
	public function get_prog_code(String $errfile, Int $errline) {
		$file = file($errfile);
		$code = [];
		for($i = $errline - 8; $i < $errline + 6; $i++){
			if(trim($file[$i]) == "") continue;
			$code[$i + 1] = str_replace("\t", "&nbsp;&nbsp;", htmlspecialchars($file[$i]));
		}
		return $code;
	}

	protected function error_is_important(String $errtype){
		foreach($this -> important_errors as $important_error){
			if($errtype == $important_error){
				return true;
			}
		}
		return false;
	}

	/**
	 * show styles and html code for fatal error
	 */
	public function view_fatal_error(Int $errno, String $errstr, String $errfile, Int $errline){
		http_response_code(500);     
		if(!FCONF["debug"]) return false;
		$err_type = $this -> get_err_type($errno);
		$code = $this -> get_prog_code($errfile, $errline);
		$errstr = str_replace(["\\", "\n", "\r", "\t"], ["&#92", "", "", ""], str_replace("`", "'", $errstr));
		$code = str_replace(["\\", "\n"], ["&#92", ""], str_replace("`", "'", $code));
		$this -> show_err_page(compact("errno", "err_type", "errstr", "errfile", "errline", "code"));
	}

	protected function show_err_page(Array $data) {
		$json_data = json_encode($data);
		echo "<title></title>";
		echo '<link rel="stylesheet" type="text/css" href="/Store/Resources/css/server-error-handler.css">';
		echo "<script>const eh_err = `{$json_data}`;</script>";
		echo '<script src="/Store/Resources/js/server-error-handler.js"></script>';
		echo "<div class='error-handler'></div>";
		die();
	}
}
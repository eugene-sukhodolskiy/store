<?php

namespace Fury\Modules\ErrorHandler;

use \Fury\Modules\Template\Template;

// use \Fury\Kernel\CallControl;

/**
 * Class: ErrorHandler
 * @author Eugene Sukhodolskiy <eugene.sukhodolskiy@gmail.com>
 * @version 0.1
 * Date: 19.07.2022
 */

class ErrorHandler{
  /**
   * $errs container with all errs for display in html
   */
  private Array $errs;

  /**
   * $errs_src container with all errs in source view
   */
  private Array $errs_src;
  
  /**
   * $important_errors what errors need to be displayed and logined
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
   * [add error]
   *
   * @param  [int] $errno [number of error code]
   * @param  [string] $errstr [error message]
   * @param  [string] $errfile [file with error]
   * @param  [int] $errline [number line with error]
   *
   * @return [void] []
   */
  public function add($errno, $errstr, $errfile, $errline){   
    $err_type = $this -> get_err_type($errno);
    $this -> errs_src[] = compact("errno", "err_type", "errstr", "errfile", "errline", "code");
  }

  /**
   * [set_err_handler set custom error handler]
   */
  public function set_err_handler(){
    set_error_handler([$this, "error_handler"], E_ALL);
    register_shutdown_function([$this, "fatal_error_handler"]);
  }

  /**
   * [fatal_error_handler set custom FATAL error handler]
   *
   * @return [null] [nothing]
   */
  public function fatal_error_handler(){
    $error = error_get_last();
    if ($error){
      if($error["type"] == E_ERROR || $error["type"] == E_PARSE || $error["type"] == E_COMPILE_ERROR || $error["type"] == E_CORE_ERROR){
        $this -> view_fatal_error($error["type"], $error["message"], $error["file"], $error["line"]);
      }
    }
  }

  /**
   * [handle of error]
   *
   * @param  [int] $errno [number of error code]
   * @param  [string] $errstr [error message]
   * @param  [string] $errfile [file with error]
   * @param  [int] $errline [number line with error]
   *
   * @return [bool] [true]
   */
  public function error_handler($errno, $errstr, $errfile, $errline){
    $err_type = $this -> get_err_type($errno);
    if(!$this -> error_is_important($err_type)){
      return true;
    }

    $this -> add($errno, $errstr, $errfile, $errline);
    return true;
  }

  /**
   * [get_err_type get type of error]
   *
   * @param  [int] $errno [error code]
   *
   * @return [string] [name of error]
   */
  private function get_err_type($errno){
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
   * [get lines with errors from file]
   *
   * @param  [string] $errfile [file with error]
   * @param  [int] $errline [number line with error]
   *
   * @return [type] [description]
   */
  public function get_prog_code($errfile, $errline){
    $file = file($errfile);
    $code = [];
    for($i=$errline - 4; $i<$errline+4; $i++){
      if(trim($file[$i]) == "") continue;
      $code[$i+1] = str_replace("\t", "&nbsp;&nbsp;", htmlspecialchars($file[$i]));
    }
    return $code;
  }

  /**
   * [isImportantError description]
   *
   * @param  [string] $errtype [type of error]
   *
   * @return boolean [true if err typr is important]
   */
  protected function error_is_important($errtype){
    foreach($this -> important_errors as $important_error){
      if($errtype == $important_error){
        return true;
      }
    }
    return false;
  }

  /**
   * [view all errors (after another code of site)]
   *
   * @return [void] [nothing]
   */
  public function view_errs(){
    if(!is_array($this -> errs_src) or !count($this -> errs_src))
      return false;

    foreach($this -> errs_src as $err){
      $errno = $err["errno"];
      $err_type = $err["err_type"];
      $errstr = $err["errstr"];
      $errfile = $err["errfile"];
      $errline = $err["errline"];
      $code = $this -> get_prog_code($errfile, $errline);
      $page = (new Template(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("error-handler/error-page-dev", compact("errno", "err_type", "errstr", "errfile", "errline", "code"));
      $errs[] = $page;
    }

    echo (new Template(PROJECT_FOLDER, FCONF["templates_folder"])) -> make("error-handler/error", compact("errs"));
  }

  /**
   * [view_fatal_error show styles and html code for fatal error]
   *
   * @param  [int] $errno [number of error code]
   * @param  [string] $errstr [error message]
   * @param  [string] $errfile [file with error]
   * @param  [int] $errline [number line with error]
   *
   * @return [type] [description]
   */
  public function view_fatal_error($errno, $errstr, $errfile, $errline){
    http_response_code(500);     
    if(!FCONF["debug"]) return false;
    $err_type = $this -> get_err_type($errno);
    $code = $this -> get_prog_code($errfile, $errline);
    $errstr = str_replace("\\", "&#92", str_replace("`", "'", $errstr));
    $code = str_replace(["\\", "\n"], ["&#92", ""], str_replace("`", "'", $code));
    $this -> show_err_page(compact("errno", "err_type", "errstr", "errfile", "errline", "code"));
  }

  protected function show_err_page(Array $data) {
    $json_data = json_encode($data);
    echo "<html><head><title></title>";
    echo '<link rel="stylesheet" type="text/css" href="/Store/Resources/css/server-error-handler.css">';
    echo "<script>const err = `{$json_data}`;</script>";
    echo '<script src="/Store/Resources/js/server-error-handler.js"></script>';
    echo "</head><body class='error-handler'></body></html>";
  }
}
<?php
/* ?module=$1&action=$2&extra-param=$3 */

//debug
//echo '<pre>';
//print_r($_GET);
//echo '</pre>';

//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");

if(include_once "libs/".$_GET['module'].".php") {

  if(!call_user_func(array($_GET['module'], $_GET['action']), $_GET['extra-param'])) {
    exit;
  }

}

?>

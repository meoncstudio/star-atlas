<?php

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

//error handler function
function customError($errno, $errstr)
{
	echo '{"code": -999, "message": "request error, ' . $errstr . '."}';
	die();
}

//set error handler
set_error_handler("customError");


require('language.php');

require('function/' . lang  . '/request.php');


?>
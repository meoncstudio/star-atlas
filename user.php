<?php

require('database.php');

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');


if(empty($_COOKIE['token'])){
	
	define("isLogin",false,true);
	
}else{

	$token = $_COOKIE['token'];

	define("token", $token, false);

	$return = verifyToken($token);

	if($return['code'] == 0){
		
		define("isLogin",true,true);
		define("SA_USER",JSON_encode($return['user']),true);
		
	}else{
		
		define("isLogin",false,true);
		
	}

}

?>
<?php

function verifyToken($token){
	
	
	$sql = "select * from sa_user WHERE token = '" . $token . "'";
	$result = mysqli_query($GLOBALS['conn'], $sql);
	
	$results = array();

	while ($row = mysqli_fetch_assoc($result)){
	$results[] = $row;
	}
	
	if(empty($results)){
		
		return JSON_decode('{"code": -1, "message": "token不存在"}',true);
		
	}
	
	return JSON_decode('{"code": 0, "message": "成功", "user": ' . JSON_encode($results[0]) . '}',true);
	
}


?>
<?php

function SA_USER(){
	
	return JSON_decode(SA_USER, true);

}

?>
<?php

ini_set('display_errors', '1'); 
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

require('database.php');



if(empty($_REQUEST['func'])){
	
	return;
	
}

$func = $_REQUEST['func'];

if($func == "login"){
	
	$un = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	
	if(check_email($un)){//有@和.的——邮箱
		
		$sql = "select * from sa_user WHERE email = '" . $un . "'";
		
	}else if(is_numeric($un)){//纯数字的——uid【也就是说注册时username不能为纯数字 必须带有字母 否则这里会被当成uid检测登陆而失败】
		
		$sql = "select * from sa_user WHERE uid = '" . $un . "'";
		
	}else{//其他的
		
		$sql = "select * from sa_user WHERE username = '" . $un . "'";
	}
	
	$result = mysqli_query($GLOBALS['conn'],$sql);
	
	$results = array();

	while ($row = mysqli_fetch_assoc($result)){
	$results[] = $row;
	}
	
	
	if(empty($results)){
		
		echo '{"code": -1, "message": "Incorrect username or password."}';
		die();
		
	}
	
	if($_REQUEST['password'] != $results[0]['password']){
		
		echo '{"code": -1, "message": "Incorrect username or password."}';
		die();
		
	}
	
	//设置token
	$token = md5(rand(100000,999999) . time() . "STAR ATLAS" . rand(1000,9999) . "CLOUDY YOUNG" . $results[0]['uid'] . "MEONC STUDIO" . $results[0]['username'] . rand(1000,9999) . $results[0]['password'] . rand(1000,9999) . "TOKEN TOKEN" . $results[0]['email'] . rand(100000,999999));
	$sql = "update sa_user set token='" . $token ."' WHERE uid='" . $results[0]['uid'] . "';";
	$result2 = mysqli_query($GLOBALS['conn'],$sql);
	
	setcookie("token", $token, time()+3600*24, "/");
	
	echo '{"code": 0, "message": "Signed in"}';
	
	die();
	
}else if($func == "reg"){
	
	$un = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$password2 = $_REQUEST['password2'];
	$email = $_REQUEST['email'];
	$code = $_REQUEST['code'];
	
	if(is_numeric($un)){
		
		echo '{"code": -1, "message": "Alphabets must be included in username."}';
		die();
		
	}else if(strlen($password)<6){
		
		echo '{"code": -2, "message": "At least 6 digits required for password"}';
		die();
		
	}else if(strlen($password)>18){
		
		echo '{"code": -3, "message": "At most 18 digits required for password"}';
		die();
		
	}else if($password != $password2){
		
		echo '{"code": -4, "message": "Two passwords are not the same"}';
		die();
		
	}else if(!check_email($email)){
		
		echo '{"code": -5, "message": "Invalid email address"}';
		die();
		
	}else if(!ctype_alnum($un)){
	
		echo '{"code": -6, "message": "Username can only be a combination of letters and numbers."}';
		die();
		
	}
	
	
	
	if($code == "StarAtlas170829"){
		
		$agroup = "editor";
		
	}else{
		
		$agroup = "";
		
	}
	
	$sql = "insert into sa_user (username, email, password, ugroup, agroup) values('$un', '$email', '$password', 'base', '$agroup')";	
	$result = mysqli_query($GLOBALS['conn'],$sql);
	
	if(!$result){
		
		if(strpos(mysql_error(),"username")){
			
			echo '{"code": -61, "message": "User name ' . $un . ' already exist."}';
			die();
			
		}else if(strpos(mysql_error(),"email")){
			
			echo '{"code": -62, "message": "email address ' . $email . ' has been registered"}';
			die();
			
		}else{
		
			echo '{"code": -69, "message": "Undefined error, please try again later' . mysql_error() . '"}';
			die();
		
		}
		
	}
	
	echo '{"code": 0, "message": "Register completed, Welcome to start journey at Star Atlas!"}';
	
}

?>
<?php

function check_email($email_address){
	$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    if ( preg_match( $pattern, $email_address ) )
    {
      return true;
    }
    else
    {
      return false;
    }
}

?>
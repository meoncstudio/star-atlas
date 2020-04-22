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
		
		$sql = "select * from `sa_user` WHERE `email` = '$un'    ";
		
	}else if(is_numeric($un)){//纯数字的——uid【也就是说注册时username不能为纯数字 必须带有字母 否则这里会被当成uid检测登陆而失败】
		
		$sql = "select * from `sa_user` WHERE `uid` = '$un'    ";
		
	}else{//其他的
		
		$sql = "select * from `sa_user` WHERE `username` = '$un'    ";
		
	}
	
	$result = mysqli_query($GLOBALS['conn'],$sql);
	
	$results = array();
	while ($row = mysqli_fetch_assoc($result)){
		$results[] = $row;
	}
	
	
	if(empty($results)){
		
		echo '{"code": -1, "message": "用户名或密码错误。"}';
		die();
		
	}
	
	if($_REQUEST['password'] != $results[0]['password']){
		
		echo '{"code": -1, "message": "用户名或密码错误。"}';
		die();
		
	}
	
	//设置token
	$token = md5(rand(100000,999999) . time() . "STAR ATLAS" . rand(1000,9999) . "CLOUDY YOUNG" . $results[0]['uid'] . "MEONC STUDIO" . $results[0]['username'] . rand(1000,9999) . $results[0]['password'] . rand(1000,9999) . "TOKEN TOKEN" . $results[0]['email'] . rand(100000,999999));
	$sql = "update sa_user set token='" . $token ."' WHERE uid='" . $results[0]['uid'] . "';";
	$result2 = mysqli_query($GLOBALS['conn'],$sql);
	
	setcookie("token", $token, time() + 3600 * 24, "/");
	
	echo '{"code": 0, "message": "登陆成功。"}';
	
	die();
	
}else if($func == "reg"){
	
	$un = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$password2 = $_REQUEST['password2'];
	$email = $_REQUEST['email'];
	$code = $_REQUEST['code'];
	
	if(is_numeric($un)){
		
		echo '{"code": -1, "message": "用户名必须含有字母。"}';
		die();
		
	}else if(strlen($password)<6){
		
		echo '{"code": -2, "message": "密码过短，要求6位以上。"}';
		die();
		
	}else if(strlen($password)>18){
		
		echo '{"code": -3, "message": "密码过长，要求18位以下。"}';
		die();
		
	}else if($password != $password2){
		
		echo '{"code": -4, "message": "两次密码不一致。"}';
		die();
		
	}else if(!check_email($email)){
		
		echo '{"code": -5, "message": "邮箱不合法。"}';
		die();
		
	}else if(!ctype_alnum($un)){
	
		echo '{"code": -6, "message": "用户名只能为字母和数字的组合。"}';
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
			
			echo '{"code": -61, "message": "用户名 ' . $un . ' 已经存在。"}';
			die();
			
		}else if(strpos(mysql_error(),"email")){
			
			echo '{"code": -62, "message": "邮箱 ' . $email . ' 已被注册。"}';
			die();
			
		}else{
		
			echo '{"code": -69, "message": "出现未知错误，请稍后重试。' . mysql_error() . '"}';
			die();
		
		}
		
	}
	
	//设置token
	$token = md5(rand(100000,999999) . time() . "STAR ATLAS" . rand(1000,9999) . "CLOUDY YOUNG" . $results[0]['uid'] . "MEONC STUDIO" . $results[0]['username'] . rand(1000,9999) . $results[0]['password'] . rand(1000,9999) . "TOKEN TOKEN" . $results[0]['email'] . rand(100000,999999));
	$sql = "update sa_user set token='" . $token ."' WHERE uid='" . $results[0]['uid'] . "';";
	$result2 = mysqli_query($GLOBALS['conn'],$sql);
	
	echo '{"code": 0, "message": "注册成功。欢迎开启星图之旅！"}';
	
}else if($func == "admin-edit-article"){
	
	//检查USER权限——这里不是应该用token去判断么
	
	if(empty($_COOKIE['token'])){
		
		echo '{"code": -6, "message": "用户Token失效。"}';
		die();
		
	}
	
	$token = $_COOKIE['token'];
	
	$sql = "select * from sa_user WHERE token = '$token'";
	$result = mysqli_query($GLOBALS['conn'], $sql);
	
	$user = array();
	while ($row = mysqli_fetch_assoc($result)){
		$user[] = $row;
	}
	
	if(empty($user)){
		
		echo '{"code": -5, "message": "用户不存在。"}';
		die();
		
	}
	
	$artid = $_REQUEST['artid'];
	
	$sql = "select * from sa_article WHERE artid = '$artid'";
	$result2 = mysqli_query($GLOBALS['conn'], $sql);
	
	$results = array();
	while ($row = mysqli_fetch_assoc($result2)){
		$results[] = $row;
	}
	
	if(empty($results)){
		
		echo '{"code": -1, "message": "文章不存在。"}';
		die();
		
	}
	
	if($results[0]['status'] != 'editing'){
		
		echo '{"code": -2, "message": "当前文章已不在编辑中状态。"}';
		die();
		
	}

	
	if($results[0]['creator'] == $user[0]['username']){
		$power = 1;//最高权限，创建者
	}else if(strpos($user[0]['agroup'], "admin") !== false){
		$power = 0;//最高权限，管理员
	}else if(strpos($results[0]['editor'], SA_USER()['username']) !== false){
		$power = 2;//普通编辑
	}else{
		$power = -1;//没有权限
	}
	
	if($power == -1){
	
		echo '{"code": -3, "message": "非文章编辑，编辑权限不足。"}';
		die();
	
	}
	
	//所有的参数必须要用addslashes以防止'符号与sql语句产生歧义
	$title_CN_zh = addslashes($_REQUEST['title_CN_zh']);
	$title_US_en = addslashes($_REQUEST['title_US_en']);
	$content_CN_zh = addslashes($_REQUEST['content_CN_zh']);
	$content_US_en = addslashes($_REQUEST['content_US_en']);
	$editors = $_REQUEST['editors'];
	
	
	if($power == 1 || $power == 0){
		
		$sql2 = "update sa_article set title_CN_zh = '$title_CN_zh', title_US_en = '$title_US_en', content_CN_zh = '$content_CN_zh', content_US_en = '$content_US_en', editor = '$editors' WHERE artid = '$artid';";
		
	}else{
		
		$sql2 = "update sa_article set content_CN_zh = '$content_CN_zh', content_US_en = '$content_US_en' WHERE artid = '$artid';";
		
	}
	
	
	$result3 = mysqli_query($GLOBALS['conn'], $sql2);
	
	if($result3 == false){
		
		echo '{"code": -4, "message": "未知错误。"}';
		die();
		
	}
	
	echo '{"code": 0, "message": "成功。"}';
	die();
	
}else if($func == "admin-post-article"){
	
	
		//检查USER权限——这里不是应该用token去判断么
	
	if(empty($_COOKIE['token'])){
		
		echo '{"code": -6, "message": "用户Token失效。"}';
		die();
		
	}
	
	$token = $_COOKIE['token'];
	
	$sql = "select * from sa_user WHERE token = '$token'";
	$result = mysqli_query($GLOBALS['conn'], $sql);
	
	$user = array();
	while ($row = mysqli_fetch_assoc($result)){
		$user[] = $row;
	}
	
	if(empty($user)){
		
		echo '{"code": -5, "message": "用户不存在。"}';
		die();
		
	}
	
	
	
	$artid = $_REQUEST['artid'];
	
	$sql = "select * from sa_article WHERE artid = '$artid'";
	$result2 = mysqli_query($GLOBALS['conn'], $sql);
	
	$results = array();
	while ($row = mysqli_fetch_assoc($result2)){
		$results[] = $row;
	}
	
	if(empty($results)){
		
		echo '{"code": -1, "message": "文章不存在。"}';
		die();
		
	}
	
	if($results[0]['status'] == 'published'){
		
		echo '{"code": -2, "message": "当前文章已在发布中状态。"}';
		die();
		
	}
	
	
	if($results[0]['creator'] == $user[0]['username']){
		$power = 1;//最高权限，创建者
	}else if(strpos($user[0]['agroup'], "admin") !== false){
		$power = 0;//最高权限，管理员
	}else if(strpos($results[0]['editor'], SA_USER()['username']) !== false){
		$power = 2;//普通编辑
	}else{
		$power = -1;//没有权限
	}
	
	if($power> 1){
	
		echo '{"code": -3, "message": 发布权限不足。"}';
		die();
	
	}
	
	$sql2 = "update sa_article set status = 'published' WHERE artid = '$artid';";
	
	$result3 = mysqli_query($GLOBALS['conn'], $sql2);
	
	if($result3 == false){
		
		echo '{"code": -4, "message": "未知错误。"}';
		die();
		
	}
	
	echo '{"code": 0, "message": "成功。"}';
	die();
	
}else if($func == "admin-revoke-article"){
	
	
		//检查USER权限——这里不是应该用token去判断么
	
	if(empty($_COOKIE['token'])){
		
		echo '{"code": -6, "message": "用户Token失效。"}';
		die();
		
	}
	
	$token = $_COOKIE['token'];
	
	$sql = "select * from sa_user WHERE token = '$token'";
	$result = mysqli_query($GLOBALS['conn'], $sql);
	
	$user = array();
	while ($row = mysqli_fetch_assoc($result)){
		$user[] = $row;
	}
	
	if(empty($user)){
		
		echo '{"code": -5, "message": "用户不存在。"}';
		die();
		
	}
	
	
	
	$artid = $_REQUEST['artid'];
	
	$sql = "select * from sa_article WHERE artid = '$artid'";
	$result2 = mysqli_query($GLOBALS['conn'], $sql);
	
	$results = array();
	while ($row = mysqli_fetch_assoc($result2)){
		$results[] = $row;
	}
	
	if(empty($results)){
		
		echo '{"code": -1, "message": "文章不存在。"}';
		die();
		
	}
	
	if($results[0]['status'] != 'published'){
		
		echo '{"code": -2, "message": "当前文章已不在发布中状态。"}';
		die();
		
	}
	
	
	if($results[0]['creator'] == $user[0]['username']){
		$power = 1;//最高权限，创建者
	}else if(strpos($user[0]['agroup'], "admin") !== false){
		$power = 0;//最高权限，管理员
	}else if(strpos($results[0]['editor'], SA_USER()['username']) !== false){
		$power = 2;//普通编辑
	}else{
		$power = -1;//没有权限
	}
	
	if($power > 1){
	
		echo '{"code": -3, "message": "撤回权限不足。"}';
		die();
	
	}
	
	$sql2 = "update sa_article set status = 'editing' WHERE artid = '$artid';";
	
	$result3 = mysqli_query($GLOBALS['conn'], $sql2);
	
	if($result3 == false){
		
		echo '{"code": -4, "message": "未知错误。"}';
		die();
		
	}
	
	echo '{"code": 0, "message": "成功。"}';
	die();
	
}else if($func == "admin-delete-ariticle"){
	
		//检查USER权限——这里不是应该用token去判断么
	
	if(empty($_COOKIE['token'])){
		
		echo '{"code": -6, "message": "用户Token失效。"}';
		die();
		
	}
	
	$token = $_COOKIE['token'];
	
	$sql = "select * from sa_user WHERE token = '$token'";
	$result = mysqli_query($GLOBALS['conn'], $sql);
	
	$user = array();
	while ($row = mysqli_fetch_assoc($result)){
		$user[] = $row;
	}
	
	if(empty($user)){
		
		echo '{"code": -5, "message": "用户不存在。"}';
		die();
		
	}
	
	
	
	$artid = $_REQUEST['artid'];
	
	$sql = "select * from sa_article WHERE artid = '$artid'";
	$result2 = mysqli_query($GLOBALS['conn'], $sql);
	
	$results = array();
	while ($row = mysqli_fetch_assoc($result2)){
		$results[] = $row;
	}
	
	if(empty($results)){
		
		echo '{"code": -1, "message": "文章不存在。"}';
		die();
		
	}
	
	if($results[0]['status'] != 'deleted'){
		
		echo '{"code": -2, "message": "当前文章已为被删除状态。"}';
		die();
		
	}
	
	
	if($results[0]['creator'] == $user[0]['username']){
		$power = 1;//最高权限，创建者
	}else if(strpos($user[0]['agroup'], "admin") !== false){
		$power = 0;//最高权限，管理员
	}else if(strpos($results[0]['editor'], SA_USER()['username']) !== false){
		$power = 2;//普通编辑
	}else{
		$power = -1;//没有权限
	}
	
	if($power > 1){
	
		echo '{"code": -3, "message": "删除权限不足。"}';
		die();
	
	}
	
	$sql2 = "update sa_article set status = 'deleted' WHERE artid = '$artid';";
	
	$result3 = mysqli_query($GLOBALS['conn'], $sql2);
	
	if($result3 == false){
		
		echo '{"code": -4, "message": "未知错误。"}';
		die();
		
	}
	
	echo '{"code": 0, "message": "成功。"}';
	die();
	
	
}else if($func == "admin-new-article"){
	
		//检查USER权限——这里不是应该用token去判断么
	
	if(empty($_COOKIE['token'])){
		
		echo '{"code": -6, "message": "用户Token失效。"}';
		die();
		
	}
	
	$token = $_COOKIE['token'];
	
	$sql = "select * from sa_user WHERE token = '$token'";
	$result = mysqli_query($GLOBALS['conn'], $sql);
	
	$user = array();
	while ($row = mysqli_fetch_assoc($result)){
		$user[] = $row;
	}
	
	if(empty($user)){
		
		echo '{"code": -5, "message": "用户不存在。"}';
		die();
		
	}
	
	
	//所有的参数必须要用addslashes以防止'符号与sql语句产生歧义
	$title_CN_zh = addslashes($_REQUEST['title_CN_zh']);
	$title_US_en = addslashes($_REQUEST['title_US_en']);
	$content_CN_zh = addslashes($_REQUEST['content_CN_zh']);
	$content_US_en = addslashes($_REQUEST['content_US_en']);
	$editors = $_REQUEST['editors'];
	$creator = $user[0]['username'];
	
	$sql2 = "INSERT INTO `sa_article` (`artid`, `creator`, `category`, `title_CN_zh`, `content_CN_zh`, `title_US_en`, `content_US_en`, `editor`, `time`, `view`, `pic`, `status`) values(NULL, '$creator', '', '$title_CN_zh', '$content_CN_zh', '$title_US_en', '$content_US_en', '$editors', CURRENT_TIMESTAMP, '0', '', 'editing')";
	
	$result3 = mysqli_query($GLOBALS['conn'], $sql2);
	
	if($result3 == false){
		
		echo '{"code": -4, "message": "未知错误。"}';
		die();
		
	}
	
	echo '{"code": 0, "message": "成功。"}';
	die();
	
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
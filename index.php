<!--

       _/_/_/_/_/  _/_/_/_/_/    _/_/_/    _/_/_/_/  
      _/              _/      _/      _/  _/      _/
     _/              _/      _/      _/  _/      _/
    _/_/_/_/_/      _/      _/_/_/_/_/  _/_/_/_/  
           _/      _/      _/      _/  _/     _/
          _/      _/      _/      _/  _/      _/
 _/_/_/_/_/      _/      _/      _/  _/       _/
 
 
         _/_/_/   _/_/_/_/_/  _/            _/_/_/    _/_/_/_/_/
      _/      _/     _/      _/          _/      _/  _/
     _/      _/     _/      _/          _/      _/  _/
    _/_/_/_/_/     _/      _/          _/_/_/_/_/  _/_/_/_/_/
   _/      _/     _/      _/          _/      _/          _/
  _/      _/     _/      _/          _/      _/          _/
 _/      _/     _/      _/_/_/_/_/  _/      _/  _/_/_/_/_/

 Interested in join us?
 Email us for website engine job: i@istaratlas.com
 
-->
<?php

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

//=========数据库=========
require('database.php');

//========常量===========
require("config.php");

//========LANGUAGE===========

require("language.php");

//========用户=========
require('user.php');


//=======T==============

if(empty($_REQUEST['t'])){
	$t = 'index';
}else{
	$t = $_REQUEST['t'];
}

	
?>
<?php

if($t == 'index'){
	
	index();
	
}else if($t == "user"){
	
	getPage("usercenter");
	
}else if($t == "article"){
	
	getPage("article");
	
}else if($t == "admin"){
	
	getPage("admin");
	
}

?>
<?php

function keyWordFilter($content){
	
	$sql = "select * from sa_page_keywords";
	$result = mysql_query($sql);

	$results = array();
		
	while ($row = mysql_fetch_assoc($result)){
		$results[] = $row;
	}
	
	
	for($t = 0; $t < count($results); $t++){
		
		eval($results[$t]['eval']);
		$content = str_replace($results[$t]['key'], $eval, $content);
		
	}
	
	return $content;
	
}


?>
<?php

function index(){
	
	$url = SAurl . 'function/' . lang . '/index.php';
	
	echo '<!--';
	$check = @fopen($url,"r");
	echo '-->';
	
	if($check == false){
		require('function/CN_zh/index.php');
	}else{
		require('function/' . lang . '/index.php');
	}
}

?>
<?php


function getPage($file){
	
	$url = SAurl . 'function/' . lang . '/' . $file . '.php';
	
	echo '<!--';
	$check = @fopen($url,"r");
	echo '-->';
	
	if(!$check){
		
		$url = SAurl . 'function/CN_zh/' . $file . '.php';
		echo '<!--';
		$check = @fopen($url,"r");
		echo '-->';
		
		if(!$check){
			echo '<!--你所访问的页面不存在或存在问题-->';
			require('function/CN_zh/index.php');
		}else{
			echo '<!--你所访问的页面不支持你使用的语言-->';
			require('function/CN_zh/' . $file . '.php');
		}
		
	}else{
		
		echo '<!--访问正常-->';
		require('function/' . lang . '/' . $file . '.php');
		
	}
	
	
}



?>
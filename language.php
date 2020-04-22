<?php

if(!empty($_REQUEST['lang'])){

	$lang_ = $_REQUEST['lang'];
	
	if($lang_ == "CN_zh"){
		$lang = "CN_zh";
	}else if ($lang_ == "US_en"){
		$lang = "US_en";
	}else{
		$lang = "CN_zh";
	}
	
	define("lang",$lang,true);
	setcookie("language",$lang);
	
}else if(!empty($_COOKIE['language'])){
	
	define("lang",$_COOKIE['language'],true);
	
}else{
	
	$lang = "CN_zh";
	define("lang",$lang,true);
	setcookie("language",$lang);
	
}

?>
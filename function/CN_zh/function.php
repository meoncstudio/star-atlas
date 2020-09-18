<?php


function Head($title,$addition=''){

$onPhone = true;

?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css?vr0.2" rel="stylesheet" />
<link href="<?php echo SAurl ?>font-awesome.min.css" rel="stylesheet">
<!--Import materialize.css-->
<link rel="shortcut icon" type="image/ico" href="http://www.istaratlas.com/res/icon.ico" />
      <link href="https://cdn.bootcss.com/materialize/0.100.2/css/materialize.min.css?vr0.2" rel="stylesheet" />
<script type="text/javascript" src="http://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js?"></script>
<!--Let browser know website is optimized for mobile-->

<?php
if($onPhone){
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
}
?>

<link type="text/css" rel="stylesheet" href="<?php echo SAurl ?>style.css"/>

<title><?php echo $title ?></title>

<!--LanguageLabel=<?php echo lang ?>;-->

<?php echo $addition ?>

</head>

<?php


}


function Body_Pre(){
	
	if(isLogin == false){
		$user_box = '<a href="?t=user" class="waves-effect waves-dark dropdown-button" style="min-width: 170px;"><i class="fa fa-user-circle"></i> 登陆</a>';
		$user_drop = '';
	}else{
		$user_box = '<a href="#" class="waves-effect waves-dark dropdown-button" data-activates="dropdown1" style="min-width: 170px;"><i class="fa fa-user-circle"></i> ' . SA_USER()['username'] . '</a>';
		
		if(!empty(SA_USER()['agroup'])){
			$user_drop = '<ul id="dropdown1" class="dropdown-content"><li><a href="?t=user" class="purple-text"><i class="material-icons">account_circle</i>用户中心</a></li><li class="divider"></li><li><a href="?t=admin" class="purple-text"><i class="material-icons">build</i>后台管理</a></li><li class="divider"></li><li class="divider"></li><li><a href="?t=user&f=exit" class="purple-text"><i class="material-icons">lock_open</i>退出登录</a></li></ul>';
		}else{
			$user_drop = '<ul id="dropdown1" class="dropdown-content"><li><a href="?t=user" class="purple-text">用户中心</a></li><li class="divider"></li> <li class="divider"></li><li><a href="?t=user&f=exit" class="purple-text">退出</a></li></ul>';
		}
		
	}

?>

<body>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js?vr0.2"></script>
<script type="text/javascript" src="<?php echo SAurl ?>js/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo SAurl ?>js/init.js"></script>
<script type="text/javascript" src="<?php echo SAurl ?>js/post.js"></script>
<script type="text/javascript" src="<?php echo SAurl . 'function/' . lang . '/' ?>class.php"></script>
<script type="text/javascript" src="<?php echo SAurl ?>js/StackBlur.js"></script>


<nav class="nav-extended navbar-fixed grey darken-4">
<div class="nav-wrapper container">
<a href="?t=index" class="brand-logo center"><i class="title" style="font-size: 35px;"></i></a>
<ul id="nav-mobile" class="right hide-on-med-and-down">
<li><?php echo $user_box ?></li>
</ul>
</div>
</nav>

<?php echo $user_drop ?>


<?php

}

function Body_Post(){
	
?>

<?php if(lang == "CN_zh"){ ?>
<!--Possible JavaScript Tip Character for CN_zh-->
<p style="display: none;">用户名或密码错误确定</p>
<?php }else if(lang == "US_en"){ ?>
<!--Possible JavaScript Tip Character for US_en-->
<p style="display: none;">qwertyuiopasdfghjklzcvbnmQWTYUIOPAGHJKLZVBNM1234567890-=[]\;',./`~!@#$%^&*()_+{}|:"<>?</p>
<?php } ?>


<footer class="page-footer grey darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text"><i class="title" style="font-size: 32px;"></i></h5>
                <p class="grey-text text-lighten-4">星图是由一群有着不同兴趣爱好的学生组成的团队，在这个团队里，大家以文学、科学、美术多种方式表达着的大家共同的目标爱好。用多元的角度诠释着科学。</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">联系我们</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="mailto: i@istaratlas.com">官方邮箱 i@istaratlas.com</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!" target="_blank">官方QQ号 3582721160</a></li>
                  <li><a class="grey-text text-lighten-3" href="http://www.jimschenchen.top/meonc" target="_blank">技术支持 Meonc Studio</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © <?php echo date('Y') ?> Copyright StarAtlas
            <a class="grey-text text-lighten-4 right" href="http://www.jimschenchen.top/meonc" target="_blank">Powered by Meonc Studio</a>
            </div>
          </div>
        </footer>
            

<script type="text/javascript">
$youziku.load("body", "ccb6195904b74f98829257185ecdf845", "Source-Han-Light");
$youziku.load("#title", "cc932f544f8f412b83755a6f1205fc59", "Source-Han-Sans-Medium");
/*$youziku.load("#id1,.class1,h1", "ccb6195904b74f98829257185ecdf845", "Source-Han-Light");*/
/*．．．*/
$youziku.draw();
</script>
</body>
</html>

<?php
}


function agroup2String(){
	
	$agroup = SA_USER()['agroup'];
	$each = explode(",", $agroup);
	$return ='';
	
	for($t = 0; $t < count($each); $t++){
		
		if($each[$t] == "admin"){
			$groupname = "管理员";
		}else if($each[$t] == "editor"){
			$groupname = "文章编辑";
		}else if($each[$t] == "s-editor"){
			$groupname = "文章主编辑";
		}else{
			$groupname = "";
		}
		
		if($groupname != "" && $t != count($each)-1){
			$groupname .= ", ";
		}
		
		$return .= $groupname;
		
	}
	
	return $return;
	
}

function ugroup2String(){
	
	$ugroup = SA_USER()['ugroup'];
	$each = explode(",", $ugroup);
	$return ='';
	
	for($t = 0; $t < count($each); $t++){
		
		if($each[$t] == "base"){
			$groupname = "普通用户";
		}else{
			$groupname = "";
		}
		
		if($groupname != "" && $t != count($each)-1){
			$groupname .= ", ";
		}
		
		$return .= $groupname;
		
	}
	
	return $return;
	
}

function get404(){
	
	require('404.php');
	die();
	
}



?>
<?php

require_once('function.php');

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');


Head("404 - 抱歉，您所浏览的页面不存在 | Star Atlas","
<style>
.rot{text-align: center;
	margin-top: 100px;}

	@-webkit-keyframes rotation{
	from {-webkit-transform: rotate(0deg);}
	to {-webkit-transform: rotate(360deg);}
	}

.Rotation{
	-webkit-transform: rotate(360deg);
	animation: rotation 3s linear infinite;
	-moz-animation: rotation 3s linear infinite;
	-webkit-animation: rotation 3s linear infinite;
	-o-animation: rotation 3s linear infinite;
	}

.img{border-radius: 250px;}

</style>
");

Body_Pre();
?>


<div class="banner-login">
<div style="padding-top: 95px; font-size: 40px; line-height: 30px;">糟糕！您的页面被黑洞吞噬。</div>

<div class="rot">
<img class="Rotation img" src="<?php echo SAUrl ?>img/blackhole.png">
</div>

<a class="btn purple" onclick="Materialize.toast('不给你！', 4000)">给我吐出来</a>

</div>


<?

Body_Post();

?>
<?php

require('function.php');

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');


Head("Star Atlas 星图 | 大千世界，无奇不有。");
Body_Pre();
?>

<div class="banner-index" id="banner" style="height: 500px;">
<div class="container">
<div class="row">
<div id="bgt" class="col m12 s12" style="padding-top: 120px;">
<div>
<div id="title" style="line-height: 100px;"><h1>大千世界，无奇不有</h1></div>
<div id="info" style="line-height: 100px;"><a class="waves-effect waves-dark hower btn-large purple darken-3 white-text flow-text z-depth-5 pulse" href="?t=user">开始</a></div>
</div>
</div>

</div>
</div>
</div>

<script>

var clientHeight = window.innerHeight;

bannerSize();

function bannerSize(){
var bannerH = clientHeight - 50;
document.getElementById("banner").style.height = bannerH + "px";
var leaveHeight = (bannerH - document.getElementById("title").offsetHeight) / 2 - 65 ;
document.getElementById("bgt").style.paddingTop = leaveHeight + "px";
}

window.onresize = function(){
bannerSize();
}

//alert(leaveHeight);

</script>


<div class="container">
<p class="right-align">上次更新：2017-8-28</p>
<div class="row">
<div class="col s12">

<div class="card-panel z-depth-2 valign-wrapper pink-text text-lighten-1">
<div class="col s12 m2" >
<img alt="空间" class="circle responsive-img" src="<?php echo SAurl ?>img/space.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
牛顿的空间
</p>
<p class="flow-text">
量子物理学
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
全息图理论
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
爱因斯坦：时空可塑性
</p>
</div>
</div>

<div class="card-panel z-depth-2 valign-wrapper blue-text text-lighten-1">
<div class="col s12 m2" >
<img alt="时间" class="circle responsive-img" src="<?php echo SAurl ?>img/time.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
时空
</p>
<p class="flow-text">
熵
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
大爆炸
</p>
<p class="flow-text">
标准时间
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
时间穿越
</p>
<p class="flow-text">
马格努斯现象
</p>
</div>
</div>

<div class="card-panel z-depth-2 valign-wrapper grey-text text-darken-1">
<div class="col s12 m2" >
<img alt="量子跃迁" class="circle responsive-img" src="<?php echo SAurl ?>img/quantumtransition.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
双缝实验
</p>
<p class="flow-text">
薛定谔方程
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
幽灵效应
</p>
<p class="flow-text">
贝尔的纠缠机器
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
瞬间转移
</p>
<p class="flow-text">
量子计算机
</p>
</div>
</div>


<div class="card-panel z-depth-2 valign-wrapper purple-text text-lighten-1">
<div class="col s12 m2" >
<img alt="宇宙" class="circle responsive-img" src="<?php echo SAurl ?>img/universe.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
太阳系
</p>
<p class="flow-text">
行星类别、特点及生存环境
</p>
<p class="flow-text">
日食与月食
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
暗物质与暗能量
</p>
<p class="flow-text">
虫洞/白洞/黑洞解析
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
流星雨
</p>
<p class="flow-text">
河内外星云争论
</p>
<p class="flow-text">
多重宇宙
</p>
</div>
</div>

<div class="card-panel z-depth-2 valign-wrapper orange-text text-lighten-1">
<div class="col s12 m2" >
<img alt="文学" class="circle responsive-img" src="<?php echo SAurl ?>img/literature.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
古典物理萌芽
</p>
<p class="flow-text">
现代学思的革新
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
宗教与科学
</p>
<p class="flow-text">
对四大板块的文学整修
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
两次世界大战对科学的影响
</p>

</div>
</div>

</div>
</div>
</div>

<?

Body_Post();

?>
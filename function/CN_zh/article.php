<?php

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

require('function.php');


if(empty($_REQUEST['artid'])){
	echo '<!--文章不存在-->';
	Header("Location: ?t=index");//跳转回index
	exit();
}

$artid = $_REQUEST['artid'];

$sql = "select * from sa_article WHERE artid = '" . $artid . "' AND status = 'published'";
$result = mysqli_query($GLOBALS['conn'], $sql);
	
$results = array();

while ($row = mysqli_fetch_assoc($result)){
	$results[] = $row;
}

if(empty($results)){
	echo '<!--文章不存在-->';
	Header("Location: ?t=index");//跳转回index
	exit();
}

$title = $results[0]['title_' . lang];
$content = $results[0]['content_' . lang];
$editor = $results[0]['editor'];
$time = date('Y-m-d', strtotime($results[0]['time']));
//$tag = $results[0]['tag_' . lang];
$category = $results[0]['category'];
$view = $results[0]['view'];
$pic = $results[0]['pic'];


Head($title . " | Star Atlas");
Body_Pre();


?>


<div class="banner-article" id="banner" style="height: 500px;">

<canvas id="blur" style="position: fixed; top: -200px; display: none;"></canvas>


<div class="container">
<div class="row">

<div id="bgt" class="col m12 s12" style="padding-top: 0px;">
<div id="title" style="font-size: 70px; line-height: 75px; word-spacing: 5px; letter-spacing: 5px;" class=""><?php echo $title ?></div>
<div id="info" style="font-size: 16px; line-height: 75px;" class=""><?php echo $category ?> / <?php echo $time ?> / <?php echo $view ?> 次浏览</div>
</div>
</div>
</div>

<div class="container">
<div class="row">
<div id="article-pic-div" class="col m12 s12" style="padding-top: 55px;">
<img id="article-pic" class="article-pic z-depth-2" src="<?php echo SAurl ?>img/banner_user.png" />
</div>
</div>
</div>

</div>


<div class="container" id="content">
<div class="row">
<div class="col m12 s12 flow-text left-align">
<p>
<?php echo $content ?>
<p>
</div>
</div>
</div>

<div class="container" id="editor">
<div class="row">
<div class="col m12 s10 flow-text left-align">
<p>
文章编辑
<?php

$each = explode(",", $editor);
for($t = 0; $t < count($each); $t++){

?>
<div class="chip">
<img src="<?php echo SAurl ?>img/head.png">
<?php echo $each[$t] ?>
</div>
<?

}


?>


<p>
</div>
</div>
</div>



<script>

bannerSize();

function bannerSize(){
var clientHeight = window.innerHeight - 40;

document.getElementById("banner").style.height = clientHeight + "px";
var leaveHeight = (clientHeight - document.getElementById("title").offsetHeight) / 2 - 60 ;
document.getElementById("bgt").style.paddingTop = leaveHeight + "px";
document.getElementById("article-pic").style.width = document.getElementById("title").offsetWidth + "px";
var articlepic = clientHeight - (leaveHeight + document.getElementById("bgt").offsetHeight);
document.getElementById("article-pic-div").style.paddingTop = articlepic + "px";
}

window.onresize = function(){
bannerSize();
}

stackBlurImage("article-pic", "blur", 30, false );


document.getElementById("banner").style.background = "url('" + document.getElementById('blur').toDataURL("image/png") + "') rgb(35, 0, 38) fixed center center no-repeat";

//alert(leaveHeight);

</script>


</div>
</div>

<?

Body_Post();

?>
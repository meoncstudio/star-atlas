<?php

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

require('function.php');

if(isLogin == false || empty(SA_USER()['agroup'])){
	Header("Location: ?t=user");//跳转回index
	exit();
}


if(!empty($_REQUEST['f'])){
	
	$f = $_REQUEST['f'];
	
}else{
	
	$f = 'index';
	
}

if($f == 'index'){
	
//====开始准备一堆东西=====

//====拉取所有文章====
$sql = "select * from sa_article";
$result = mysqli_query($GLOBALS['conn'], $sql);
	
$results = array();

while ($row = mysqli_fetch_assoc($result)){
	$results[] = $row;
}

//=====计算编辑中=====
$sql = "select count(*) from sa_article WHERE status = 'editing'";
$result = mysqli_query($GLOBALS['conn'], $sql);
	
$results_editing = array();

while ($row = mysqli_fetch_assoc($result)){
	$results_editing[] = $row;
}

$article_editing = $results_editing[0]['count(*)'];

//=====计算已发布=====
$sql = "select count(*) from sa_article WHERE status = 'published'";
$result = mysqli_query($GLOBALS['conn'], $sql);
	
$results_published = array();

while ($row = mysqli_fetch_assoc($result)){
	$results_published[] = $row;
}

$article_published = $results_published[0]['count(*)'];

//=====计算浏览量=====
$sql = "select sum(view) from sa_article";
$result = mysqli_query($GLOBALS['conn'], $sql);
	
$results_view = array();

while ($row = mysqli_fetch_assoc($result)){
	$results_view[] = $row;
}

$article_view = $results_view[0]['sum(view)'];




Head("主页 | Star Atlas 管理中心","<style>body{background-color: rgb(171, 71, 188);}</style>");

Body_Pre();
?>


<script type="text/javascript" src="<?php echo SAurl ?>function/<?php echo lang ?>/admin_class.php"></script>

<div class="container">
<h2 class="white-text flow-text right-align"><i class="material-icons">account_circle</i> <?php echo SA_USER()['username'] ?> 的管理台</h2>
<p class="white-text right-align"><?php echo agroup2String(SA_USER()['agroup']) ?></p>
</div>

<div>
<div class="container">
  <div class="row">
        <div class="col s12 m4">
          <div class="card white darken-1">
            <div class="card-content purple-text">
              <span class="card-title"><?php echo $article_editing ?> 篇</span>
              <p>编辑中文章</p>
            </div>
            <div class="card-action black-text">
              <a href="#" class="black-text">现在编辑</a>
            </div>
          </div>
        </div>
		<div class="col s12 m4">
          <div class="card white darken-1">
            <div class="card-content purple-text">
              <span class="card-title"><?php echo $article_published ?> 篇</span>
              <p>已发布文章</p>
            </div>
            <div class="card-action black-text">
              <a href="#" class="black-text">查看这些文章</a>
            </div>
          </div>
        </div>
		<div class="col s12 m4">
          <div class="card white darken-1">
            <div class="card-content purple-text">
              <span class="card-title"><?php echo $article_view ?> 次</span>
              <p>总浏览量</p>
            </div>
            <div class="card-action black-text">
              <a href="#" class="black-text">刷新</a>
            </div>
          </div>
        </div>
      </div>
	  
	  <div class="divider"></div>
	  
	  <div class="row">
        <div class="col s12 m12">
          <div class="card white darken-1">
            <div class="card-content purple-text">
              <span class="card-title">编辑中文章<span class="badge purple white-text"><?php echo $article_editing ?> 篇</span></span>
              <p>这里显示的是正在编辑中的文章</p>
			  
			    <table class="black-text responsive-table">
        <thead>
          <tr>
              <th style="min-width: 30px; width: 5%;">Artid</th>
              <th style="min-width: 110px; width: 10%;">标题</th>
              <th style="min-width: 150px; width: 20%;">文章编辑</th>
			  <th style="min-width: 100px; width: 30%">文章摘要</th>
			  <th style="min-width: 100px; width: 15%">上次修改时间</th>
			  <th style="min-width: 100px; width: 20%">操作</th>
          </tr>
        </thead>
        <tbody>
<?php

for($t = 0; $t < count($results); $t++){

	if($results[$t]['status'] == 'editing'){

?>
          <tr>
           <td><?php echo $results[$t]['artid'] ?></td>
           <td><?php echo $results[$t]['title_' . lang] ?></td>
           <td><!--编辑-->
			<?php
				
				//把editors按 , 分隔，然后for
				$each = explode(",", $results[$t]['editor']);
				
				for($e = 0; $e < count($each); $e++){
			
			?>
					<div class="chip"><img src="<?php echo SAurl . "img/head.png" ?>" alt=""><nobr><?php echo $each[$e] ?></nobr></div>
			<?php
			
				}
			
			?>
			</td>
			<td><?php echo substr($results[$t]['content_' . lang], 0 , 100) . "……" ?></td>
			<td><?php echo $results[$t]['time'] ?></td>
			<td>
			<?php if(strpos($results[$t]['editor'], SA_USER()['username']) !== false || strpos(SA_USER()['agroup'], 'admin') !== false){ ?>
			<a class="btn-floating waves-effect waves-dark hower btn-small purple-text text-darken-3 white flow-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="编辑" href="?t=admin&f=edit&artid=<?php echo $results[$t]['artid'] ?>"><i class="material-icons purple-text">edit</i></a>
			<?php } ?>
			<?php if($results[$t]['creator'] == SA_USER()['username'] || strpos(SA_USER()['agroup'], 'admin') !== false){ ?>
			<a class="btn-floating waves-effect waves-dark hower btn-small purple-text text-darken-3 white flow-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="发布" href="javascript: admin.post_article(<?php echo $results[$t]['artid'] ?>)"><i class="material-icons purple-text">cloud_upload</i></a>
			<a class="btn-floating waves-effect waves-dark hower btn-small purple-text text-darken-3 white flow-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="删除"  href="javascript: admin.delete_article(<?php echo $results[$t]['artid'] ?>)"><i class="material-icons purple-text">close</i></a>
			<?php } ?>
			</td>
          </tr>
<?php

	}

}

?>
        </tbody>
      </table>
            </div>
          </div>
        </div>
		
		<div class="col s12 m12">
          <div class="card white darken-1">
            <div class="card-content purple-text">
              <span class="card-title">已发布文章<span class="badge purple white-text"><?php echo $article_published ?> 篇</span></span>
              <p>这里显示的是已经发布的文章</p>
			  
			    <table class="black-text responsive-table">
        <thead>
          <tr>
              <th style="min-width: 30px; width: 5%;">Artid</th>
              <th style="min-width: 110px; width: 10%;">标题</th>
              <th style="min-width: 150px; width: 20%;">文章编辑</th>
			  <th style="min-width: 100px; width: 30%">文章摘要</th>
			  <th style="min-width: 100px; width: 15%">发布时间</th>
			  <th style="min-width: 100px; width: 20%">操作</th>
          </tr>
        </thead>
        <tbody>
<?php

for($t = 0; $t < count($results); $t++){

	if($results[$t]['status'] == 'published'){

?>
         <tr>
            <td><?php echo $results[$t]['artid'] ?></td>
            <td><?php echo $results[$t]['title_' . lang] ?><a class="purple-text" target="_blank" href="?t=article&artid=<?php echo $results[$t]['artid'] ?>"><i class="fa fa-link purple-text"></i></a></td>
            <td><!--编辑-->
			<?php
				
				//把editors按逗号分隔，然后for
				$each = explode(",", $results[$t]['editor']);
				
				for($e = 0; $e < count($each); $e++){
			
			?>
					<div class="chip"><img src="<?php echo SAurl . "img/head.png" ?>" alt=""><nobr><?php echo $each[$e] ?></nobr></div>
			<?php
			
				}
			
			?>
			</td>
			<td><?php echo substr($results[$t]['content_' . lang], 0 , 100) . "……" ?></td>
			<td><?php echo $results[$t]['time'] ?></td>
			<td>
			<?php if($results[$t]['creator'] == SA_USER()['username'] || strpos(SA_USER()['agroup'], 'admin') !== false){ ?>
			<a class="btn-floating waves-effect waves-dark hower btn-small purple-text text-darken-3 white flow-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="撤回" href="javascript: admin.revoke_article(<?php echo $results[$t]['artid'] ?>)"><i class="material-icons purple-text">cloud_download</i></a>
			<a class="btn-floating waves-effect waves-dark hower btn-small purple-text text-darken-3 white flow-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="删除" href="javascript: admin.delete_article(<?php echo $results[$t]['artid'] ?>)"><i class="material-icons purple-text">close</i></a>
			<?php } ?>
			</td>
          </tr>
<?php

	}

}

?>
        </tbody>
      </table>
            </div>
          </div>
        </div>
		
      </div>
</div>
</div>

<?php 

if(strpos(SA_USER()['agroup'], 'admin') !== false || strpos(SA_USER()['agroup'], 's-editor') !== false){

?>
  <div class="fixed-action-btn toolbar">
    <a class="btn-floating btn-large purple darken-3">
      <i class="large material-icons">mode_edit</i>
    </a>
    <ul>
      <li class="waves-effect waves-light"><a href="?t=admin&f=new" target="_blank"><i class="material-icons">add</i></a></li>
    </ul>
  </div>

<?php

}

?>
<?

Body_Post();

die();

}else if($f == 'edit'){
	
	if(empty($_REQUEST['artid'])){
		
		get404();
		die();
		
	}

//======开始准备一堆东西======
	
//======先读个文章=======
$artid = $_REQUEST['artid'];
$uid = SA_USER()['uid'];

$sql = "select * from sa_article WHERE artid = '$artid'";
$result = mysqli_query($GLOBALS['conn'], $sql);
	
$results = array();
while ($row = mysqli_fetch_assoc($result)){
	$results[] = $row;
}


if(empty($results)){
	
	//没有
	get404();
	die();
	
}

if($results[0]['status'] != 'editing'){
	
	//不是编辑状态
	get404();
	die();
	
}

//======判断一下权限=======
if($results[0]['creator'] == SA_USER()['username']){

	$power = 1;//创建者

}else if(strpos(SA_USER()['agroup'], 'admin') !== false){
	
	$power = 0;//管理员
	
}else if(strpos($results[0]['editor'], SA_USER()['username']) !== false){
	
	$power = 2;//普通编辑
	
}else{
	
	$power = -1;//没有权限
	
}

if($power == -1){
	
	//不是文章编辑
	get404();
	die();
	
}

//======获取所有是editor或者s-editor用户组的人=====
$sql = "select * from sa_user WHERE  find_in_set('editor',agroup) OR find_in_set('s-editor',agroup)";
$result2 = mysqli_query($GLOBALS['conn'], $sql);
	
$results_editor = array();
while ($row = mysqli_fetch_assoc($result2)){
	$results_editor[] = $row;
}


	
	
	
Head("文章编辑页 | Star Atlas 管理中心","
<style>
.input-field input:focus {
border-bottom: 1px solid rgb(173, 88, 194)  !important;
box-shadow: 0 1px 0 0 rgb(173, 88, 194)  !important;
}
.input-field input:focus + label {
color: rgb(173, 88, 194)  !important;
}
.input-field .prefix.active {
color: rgb(173, 88, 194)  !important;
}


.input-field input:disabled{
	color: rgb(173, 88, 194)  !important;
}

.input-field input{
	font-weight: bold;
}


</style>
<style>body{background-color: rgb(171, 71, 188);}</style>
<style>

.chips:active, .chips:hover, .chips:focus, .chips.focus{

	border-bottom-color: rgb(35, 0, 38) !important;
	box-shadow:  0 1px 0 0 #fff !important;

}

.chip.selected{
	
	color: #fff !important;
	background-color: rgb(173, 88, 194) !important;
	
}


</style>
");

Body_Pre();
	
?>

<script type="text/javascript" src="<?php echo SAurl ?>function/<?php echo lang ?>/admin_class.php"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/ueditor.all.min.js"> </script>
<?php

//这里手动加载语言，避免在ie下有时因为加载语言失败导致编辑器加载失败 
//这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文

if(lang == "CN_zh"){

?>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/lang/zh-cn/zh-cn.js"></script>

<?php

}else if(lang == "US_en"){

 ?>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/lang/en/en.js"></script>
 
 <?php

}

 ?>


<div class="container">
<h2 class="white-text flow-text right-align"><i class="material-icons">account_circle</i> <?php echo SA_USER()['username'] ?> 的管理台</h2>
<p class="white-text right-align"><?php echo agroup2String(SA_USER()['agroup']) ?></p>
</div>


<div class="container">
  <div class="row">
        <div class="col s12 m12">
          <div class="card white darken-1">
		  <div class="card-image">
          <img src="<?php echo SAurl ?>img/banner.png">
          <a class="btn-floating halfway-fab waves-effect waves-light purple"><i class="material-icons">add</i></a>
			</div>
            <div class="card-content purple-text darken-2">
			
			<?php
				$power == 1 || $power == 0 ? $disabled = '' : $disabled = 'disabled="disabled"';
			?>
			<div class="input-field">
          <input id="chinese-title" type="text" <?php echo $disabled ?> value="<?php echo $results[0]['title_CN_zh'] ?>">
          <label for="chinense-title">文章标题 (简体中文)</label>
			<div class="input-field">
          <input id="english-title" type="text" <?php echo $disabled ?> value="<?php echo $results[0]['title_US_en'] ?>">
          <label for="english-title">文章标题 (English)</label>
			</div>
			
			<?php if($power == 1 || $power == 0){ //接下来可以有编辑框来更改editors ?>
			<div class="chips chips-initial chips-placeholder chips-autocomplete" id="editors"></div>
			<script>
				
				var editors = new Array(<?php 

				for($e = 0; $e < count($results_editor); $e++){
					
?>"<?php echo $results_editor[$e]['username'] ?>"<?php	
					
					if($e != count($results_editor) - 1){
						
						echo ',';
						
					}
					
				}
				?>);
				var Vplaceholder = '添加文章编辑';
				var VsecondaryPlaceholder = '添加文章编辑';
				
				 $('.chips-placeholder').material_chip({
					placeholder: Vplaceholder,
					secondaryPlaceholder: VsecondaryPlaceholder,
					data: [
					<?php 
					
					$each = explode(",", $results[0]['editor']);
					for($e = 0; $e < count($each); $e++){
					?>
					{
					  tag: '<?php echo $each[$e] ?>',
					  image: '<?php echo SAurl ?>img/head.png', //optional
					},
					<?php } ?>],
					
				  });
				  
				  
				  
									
				  
				    $('.chips').on('chip.add', function(e, chip){
					//alert(chip['tag']);
					
					if(jQuery.inArray(chip['tag'], editors) == -1){
						
						//删掉新增加的chip
						var chip_editors = $('.chips-initial').material_chip('data');
						chip_editors.pop();
						
						 $('.chips-placeholder').material_chip({
							placeholder: Vplaceholder,
							secondaryPlaceholder: VsecondaryPlaceholder,
							data: chip_editors,
						  });
						
						var $toastContent = $('<span>文章编辑“' + chip['tag'] + '”不存在。' + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
						Materialize.toast($toastContent, 4000);
						
					}else{
					
						//为新增chip加一个img——先删除最后一个，然后新构建一个element并加到数组
						var chip_editors = $('.chips-initial').material_chip('data');
						chip_editors.pop();
						
						 var chip_new_editor = {
							tag: chip['tag'],
							image: '<?php echo SAurl ?>img/head.png', //optional
							//id: 1, //optional
						  };
						  
						chip_editors.push(chip_new_editor);
						
						$('.chips-placeholder').material_chip({
							placeholder: Vplaceholder,
							secondaryPlaceholder: VsecondaryPlaceholder,
							data: chip_editors,
						  });
					
					}

					return;
				  });
				  
				   $('.chips').on('chip.delete', function(e, chip){
						// you have the deleted chip here
						if(chip['tag'] == "<?php echo SA_USER()['username'] ?>"){
							//不可以删掉自己啊啊啊！！
							
							var chip_editors = $('.chips-initial').material_chip('data');
							
							 var chip_new_editor = {
								tag: chip['tag'],
								image: '<?php echo SAurl ?>img/head.png', //optional
								//id: 1, //optional
							  };
							  
							chip_editors.push(chip_new_editor);
							
							$('.chips-placeholder').material_chip({
								placeholder: Vplaceholder,
								secondaryPlaceholder: VsecondaryPlaceholder,
								data: chip_editors,
						    });
							
							var $toastContent = $('<span>不可以删掉自己哦</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
						Materialize.toast($toastContent, 4000);
							
						}
						
						
					  });
				  
				</script>
			  
			<?php }else{ 
			
				$each = explode(",", $results[0]['editor']);
				for($e = 0; $e < count($each); $e++){
			
			?>
			
			 <div class="chip">
				<img src='<?php echo SAurl ?>img/head.png'><?php echo $each[$e] ?>
			 </div>
			
			<?php } ?>
			
			<?php } ?>
            </div>
			</div>
        </div>
	</div>
	
	<div class="col s12 m12">
	<div class="card-tabs">
      <ul class="tabs tabs-fixed-width purple darken-2 tabs-transparent">
        <li class="tab"><a class="active" href="#CN_zh">简体中文</a></li>
        <li class="tab"><a class="" href="#English">English</a></li>
      </ul>
    </div>
	
	 <div class="card-content grey lighten-4">
      <div id="CN_zh">
			<script id="editor_CN_zh" type="text/plain" style="width:100%;height:300px;"><?php echo $results[0]['content_CN_zh'] ?></script>
			<script>var ue_CN_zh = UE.getEditor('editor_CN_zh');</script>
		</div>
      <div id="English">
			<script id="editor_US_en" type="text/plain" style="width:100%;height:300px;"><?php echo $results[0]['content_US_en'] ?></script>
			<script>var ue_US_en = UE.getEditor('editor_US_en');</script>
		</div>
	</div>
    </div>
	
	
	</div>
	
	<div class="col s12 m12">
	<div class="card white darken-1">
	<div class="card-content purple-text right-align">
		Tip: 若编辑组件未成功加载，请刷新重试。完成编辑后点击右下角<i class="material-icons">check</i>按钮提交。
	</div>
	</div>
	</div>
	
      </div>
	 

</div>

  <div class="fixed-action-btn" style="z-index: 99999;">
    <a class="btn-floating btn-large purple darken-3" href="javascript: submitEdit();">
      <i class="large material-icons">check</i>
    </a>
    <ul>
    </ul>
  </div>
  
<script>

function submitEdit(){
	
	var artid='<?php echo $artid ?>';
	var uid = '<?php echo $uid ?>';
	var title_CN_zh = $("#chinese-title").val();
	var title_US_en = $("#english-title").val();
	var content_CN_zh = UE.getEditor('editor_CN_zh').getContentTxt();
	var content_US_en = UE.getEditor('editor_US_en').getContentTxt();
	
	<?php if($power == 1 || $power == 0){ ?>
	var editors_data = $('.chips-initial').material_chip('data');
	var editors = "";
	for(t = 0; t < editors_data.length; t++){
		
		editors += editors_data[t]['tag'];
		if(t != editors_data.length -1){
			editors += ",";
		}
		
	}
	<?php }else{ ?>
	
	var editors = "<?php echo $results[0]['editor'] ?>";
	
	<?php } ?>
	
	admin.edit_article(artid, title_CN_zh, title_US_en, editors, content_CN_zh, content_US_en, uid);
	
}

</script>


<?php
	
	Body_Post();
	
}else if($f == 'new'){
	
//======开始准备一堆东西======
//======获取用户权限======
if(strpos(SA_USER()['agroup'], 'admin') === false || strpos(SA_USER()['agroup'], 's-editor') === false){
	
	get404();
	die();
	
}


//======获取所有是editor或者s-editor用户组的人=====
$sql = "select * from sa_user WHERE  find_in_set('editor',agroup) OR find_in_set('s-editor',agroup)";
$result2 = mysqli_query($GLOBALS['conn'], $sql);
	
$results_editor = array();
while ($row = mysqli_fetch_assoc($result2)){
	$results_editor[] = $row;
}


	
	
	
Head("文章新建页 | Star Atlas 管理中心","
<style>
.input-field input:focus {
border-bottom: 1px solid rgb(173, 88, 194)  !important;
box-shadow: 0 1px 0 0 rgb(173, 88, 194)  !important;
}
.input-field input:focus + label {
color: rgb(173, 88, 194)  !important;
}
.input-field .prefix.active {
color: rgb(173, 88, 194)  !important;
}


.input-field input:disabled{
	color: rgb(173, 88, 194)  !important;
}

.input-field input{
	font-weight: bold;
}


</style>
<style>body{background-color: rgb(171, 71, 188);}</style>
<style>

.chips:active, .chips:hover, .chips:focus, .chips.focus{

	border-bottom-color: rgb(35, 0, 38) !important;
	box-shadow:  0 1px 0 0 #fff !important;

}

.chip.selected{
	
	color: #fff !important;
	background-color: rgb(173, 88, 194) !important;
	
}


</style>
");

Body_Pre();
	
?>

<script type="text/javascript" src="<?php echo SAurl ?>function/<?php echo lang ?>/admin_class.php"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/ueditor.all.min.js"> </script>
<?php

//这里手动加载语言，避免在ie下有时因为加载语言失败导致编辑器加载失败 
//这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文

if(lang == "CN_zh"){

?>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/lang/zh-cn/zh-cn.js"></script>

<?php

}else if(lang == "US_en"){

 ?>
<script type="text/javascript" charset="utf-8" src="<?php echo SAurl ?>utf8-php/lang/en/en.js"></script>
 
 <?php

}

 ?>


<div class="container">
<h2 class="white-text flow-text right-align"><i class="material-icons">account_circle</i> <?php echo SA_USER()['username'] ?> 的管理台</h2>
<p class="white-text right-align"><?php echo agroup2String(SA_USER()['agroup']) ?></p>
</div>


<div class="container">
  <div class="row">
        <div class="col s12 m12">
          <div class="card white darken-1">
		  <div class="card-image">
          <img src="<?php echo SAurl ?>img/banner.png">
          <a class="btn-floating halfway-fab waves-effect waves-light purple"><i class="material-icons">add</i></a>
			</div>
            <div class="card-content purple-text darken-2">
			
			<div class="input-field">
          <input id="chinese-title" type="text" value="">
          <label for="chinense-title">文章标题 (简体中文)</label>
			<div class="input-field">
          <input id="english-title" type="text" value="">
          <label for="english-title">文章标题 (English)</label>
			</div>
			
			<div class="chips chips-initial chips-placeholder chips-autocomplete" id="editors"></div>
			<script>
				
				var editors = new Array(<?php

				for($e = 0; $e < count($results_editor); $e++){
					
?>"<?php echo $results_editor[$e]['username'] ?>"<?php	
					
					if($e != count($results_editor) - 1){
						
						echo ',';
						
					}
					
				}
				?>);
				var Vplaceholder = '添加文章编辑';
				var VsecondaryPlaceholder = '添加文章编辑';
				
				 $('.chips-placeholder').material_chip({
					placeholder: Vplaceholder,
					secondaryPlaceholder: VsecondaryPlaceholder,
					data:[{
					  tag: '<?php echo SA_USER()['username'] ?>',
					  image: '<?php echo SAurl ?>img/head.png', //optional
					},
					],
					
				  });
				  
				  
				  
									
				  
				    $('.chips').on('chip.add', function(e, chip){
					//alert(chip['tag']);
					
					if(jQuery.inArray(chip['tag'], editors) == -1){
						
						//删掉新增加的chip
						var chip_editors = $('.chips-initial').material_chip('data');
						chip_editors.pop();
						
						 $('.chips-placeholder').material_chip({
							placeholder: Vplaceholder,
							secondaryPlaceholder: VsecondaryPlaceholder,
							data: chip_editors,
						  });
						
						var $toastContent = $('<span>文章编辑“' + chip['tag'] + '”不存在。' + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
						Materialize.toast($toastContent, 4000);
						
					}else{
					
						//为新增chip加一个img——先删除最后一个，然后新构建一个element并加到数组
						var chip_editors = $('.chips-initial').material_chip('data');
						chip_editors.pop();
						
						 var chip_new_editor = {
							tag: chip['tag'],
							image: '<?php echo SAurl ?>img/head.png', //optional
							//id: 1, //optional
						  };
						  
						chip_editors.push(chip_new_editor);
						
						$('.chips-placeholder').material_chip({
							placeholder: Vplaceholder,
							secondaryPlaceholder: VsecondaryPlaceholder,
							data: chip_editors,
						  });
					
					}

					return;
				  });
				  
				   $('.chips').on('chip.delete', function(e, chip){
						// you have the deleted chip here
						if(chip['tag'] == "<?php echo SA_USER()['username'] ?>"){
							//不可以删掉自己啊啊啊！！
							
							var chip_editors = $('.chips-initial').material_chip('data');
							
							 var chip_new_editor = {
								tag: chip['tag'],
								image: '<?php echo SAurl ?>img/head.png', //optional
								//id: 1, //optional
							  };
							  
							chip_editors.push(chip_new_editor);
							
							$('.chips-placeholder').material_chip({
								placeholder: Vplaceholder,
								secondaryPlaceholder: VsecondaryPlaceholder,
								data: chip_editors,
						    });
							
							var $toastContent = $('<span>不可以删掉自己哦</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
						Materialize.toast($toastContent, 4000);
							
						}
						
						
					  });
				  
				</script>
            </div>
			</div>
        </div>
	</div>
	
	<div class="col s12 m12">
	<div class="card-tabs">
      <ul class="tabs tabs-fixed-width purple darken-2 tabs-transparent">
        <li class="tab"><a class="active" href="#CN_zh">简体中文</a></li>
        <li class="tab"><a class="" href="#English">English</a></li>
      </ul>
    </div>
	
	 <div class="card-content grey lighten-4">
      <div id="CN_zh">
			<script id="editor_CN_zh" type="text/plain" style="width:100%;height:300px;"></script>
			<script>var ue_CN_zh = UE.getEditor('editor_CN_zh');</script>
		</div>
      <div id="English">
			<script id="editor_US_en" type="text/plain" style="width:100%;height:300px;"></script>
			<script>var ue_US_en = UE.getEditor('editor_US_en');</script>
		</div>
	</div>
    </div>
	
	
	</div>
	
	<div class="col s12 m12">
	<div class="card white darken-1">
	<div class="card-content purple-text right-align">
		Tip: 若编辑组件未成功加载，请刷新重试。完成编辑后点击右下角<i class="material-icons">check</i>按钮提交。
	</div>
	</div>
	</div>
	
      </div>
	 

</div>

  <div class="fixed-action-btn" style="z-index: 99999;">
    <a class="btn-floating btn-large purple darken-3" href="javascript: submitEdit();">
      <i class="large material-icons">check</i>
    </a>
    <ul>
    </ul>
  </div>
  
<script>

function submitEdit(){
	
	var title_CN_zh = $("#chinese-title").val();
	var title_US_en = $("#english-title").val();
	var content_CN_zh = UE.getEditor('editor_CN_zh').getContentTxt();
	var content_US_en = UE.getEditor('editor_US_en').getContentTxt();
	
	var editors_data = $('.chips-initial').material_chip('data');
	var editors = "";
	for(t = 0; t < editors_data.length; t++){
		
		editors += editors_data[t]['tag'];
		if(t != editors_data.length -1){
			editors += ",";
		}
		
	}
	
	admin.new_article(title_CN_zh, title_US_en, editors, content_CN_zh, content_US_en);
	
}

</script>


<?php
	
	Body_Post();
	
}

?>
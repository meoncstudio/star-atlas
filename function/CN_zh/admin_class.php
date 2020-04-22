<?php

//========常量===========
require("../../config.php");

//========LANGUAGE===========

require("../../language.php");


?>

var admin={


	edit_article: function(artid, title_CN_zh, title_US_en, editors, content_CN_zh, content_US_en){
		post("<?php echo SAurl ?>request.php",{"func": "admin-edit-article","artid": artid, "title_CN_zh": title_CN_zh, "title_US_en": title_US_en, "editors": editors, "content_CN_zh": content_CN_zh, "content_US_en": content_US_en},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
				Materialize.toast($toastContent, 4000);
				if(res.code == -6){
					window.location.href='?t=user';//大概是用户检测没过关
				}
			}else{
				//location.reload();
				window.location.href='?t=admin';
			}
		});
	},
	
	post_article: function(artid){
		post("<?php echo SAurl ?>request.php",{"func": "admin-post-article","artid": artid},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
				Materialize.toast($toastContent, 4000);
			}else{
				//location.reload();
				window.location.href='?t=admin';
			}
		});
	},
	
	revoke_article: function(artid){
		post("<?php echo SAurl ?>request.php",{"func": "admin-revoke-article","artid": artid},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
				Materialize.toast($toastContent, 4000);
			}else{
				//location.reload();
				window.location.href='?t=admin';
			}
		});
	},
	
	delete_article: function(artid){
		post("<?php echo SAurl ?>request.php",{"func": "admin-delete-article","artid": artid},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
				Materialize.toast($toastContent, 4000);
			}else{
				//location.reload();
				window.location.href='?t=admin';
			}
		});
	},

	new_article: function(title_CN_zh, title_US_en, editors, content_CN_zh, content_US_en){
		post("<?php echo SAurl ?>request.php",{"func": "admin-new-article", title_CN_zh, title_US_en, editors, content_CN_zh, content_US_en},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">确定</button>'));
				Materialize.toast($toastContent, 4000);
			}else{
				//location.reload();
				window.location.href='?t=admin';
			}
		});
	},
	

}

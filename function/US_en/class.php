<?php


//========常量===========
require("../../config.php");

//========LANGUAGE===========

require("../../language.php");


?>

	
var user={


	login: function(un,pw){
		post("<?php echo SAurl ?>request.php",{"func": "login", "username": un,"password":pw},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">Confirm</button>'));
				Materialize.toast($toastContent, 4000);
			}else{
				//location.reload();
				window.location.href='?t=index';
			}
		});
	},
	
	reg: function(username, password, password2, email, code){
		
		post("<?php echo SAurl ?>request.php",{"func": "reg", "username": username,"password":password ,"password2":password2, "email": email, "code": code},function(res){
			if(res.code!=0){
				var $toastContent = $('<span>' + res.message + '</span>').add($('<button class="btn-flat toast-action purple-text" onclick="Materialize.Toast.removeAll();">Confirm</button>'));
				Materialize.toast($toastContent, 4000);
			}else{
				//location.reload();
				window.location.href='?t=user&f=welcome';
			}
		});
		
	}

}





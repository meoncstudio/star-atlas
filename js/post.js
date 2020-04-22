
function post(url,data,response) {
    var req = new XMLHttpRequest();
    var fd = new FormData();
    //回调
    req.onreadystatechange = function () {
    	console.log(req.status);
        if (req.readyState == 4) {
        	if(req.status == 200){
				//alert(req.responseText);
				response(JSON.parse(req.responseText));
				}else{
				throw new Error(req.responseText);
			}
        }
    };
	
  	//构建表单
	for(var key in data){
		fd.append(key, data[key])
	}
    
	req.open("post", url, true);

	req.send(fd);
	
}


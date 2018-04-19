function ajax(url, data={}, type="post", success=null, error=null){
	$.ajax({url: url, data=data,success: success, error: error});
}


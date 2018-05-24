"use strict";

function handleFlagPost(flag,post_id){
	
	var value=document.getElementById("FlagSpan").innerHTML;
	if(value=="Flag"){
		window.location.href="/flag/post/"+post_id;
	}
	else{
		flag=JSON.parse(flag);
		console.log(flag.reason);
		var r = confirm("You sure you want to delete flag?\n Reason:\n"+flag.reason)
		
		if (r==true){
			deleteFlag(flag.flagger_id,flag.post_id)
		}
	}
	
}

function handleFlagComment(flag,comment_id){
	
	var value=document.getElementById("FlagSpanCm").innerHTML;
	if(value=="Flag"){
		window.location.href="/flag/comment/"+comment_id;
	}
	else{
		flag=JSON.parse(flag);
		console.log(flag.reason);
		var r = confirm("You sure you want to delete flag?\n Reason:\n"+flag.reason)
		
		if (r==true){
			console.log(comment_id);
			deleteFlagCm(flag.flagger_id,comment_id)
		}
	}
	
}

function handleFlagUser(flag,flagged_id){
	
	var value=document.getElementById("FlagSpanUsr").innerHTML;
	if(value=="Flag"){
		window.location.href="/flag/user/"+flagged_id;
	}
	else{
		flag=JSON.parse(flag);
		console.log(flag.reason);
		var r = confirm("You sure you want to delete flag?\n Reason:\n"+flag.reason)
		
		if (r==true){
			deleteFlagUsr(flag.flagger_id,flag.flagged_id)
		}
	}
	
}

function writeFlagPost(flag){
	flag=JSON.parse(flag)
	console.log(flag)
	console.log(flag.flagger_id)
	console.log(flag.post_id)

}

function deleteFlag(flagger_id,post_id){
	$.ajax({
		type: "DELETE",
		url: `/api/flagPosts/delete/${flagger_id}/${post_id}`,
		 success: function (data) {
			 console.log(data);
			if(data.success){
				var value=document.getElementById("FlagSpan").innerHTML="Flag";
			}else{
				alert(data.error);
			}
		} 
	});
}


function archiveFlag(flagger_id,post_id){
	$.ajax({
		type: "POST",
		url: `/api/flagPosts/archive/${flagger_id}/${post_id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${flagger_id},${post_id}']`).remove();
			}else{
				alert(data.error);
			}
		}
	});
}

function archiveFlagUser(flagger_id,flagged_id){
	$.ajax({
		type: "POST",
		url: `/api/flagUsers/archive/${flagger_id}/${flagged_id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${flagger_id},${flagged_id}']`).remove();
			}else{
				alert(data.error);
			}
		}
	});
}

function deleteFlagUsr(flagger_id,flagged_id){
	console.log(flagger_id);
	console.log(flagged_id);
	$.ajax({
		type: "DELETE",
		url: `/api/flagUsers/delete/${flagger_id}/${flagged_id}`,
		 success: function (data) {
			 console.log(data);
			if(data.success){
				var value=document.getElementById("FlagSpanUsr").innerHTML="Flag";
			}else{
				alert(data.error);
			}
		} 
	});
}

function archiveFlagComment(flagger_id,comment_id){
	$.ajax({
		type: "POST",
		url: `/api/flagComments/archive/${flagger_id}/${comment_id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${flagger_id},${comment_id}']`).remove();
			}else{
				alert(data.error);
			}
		}
	});
}

function deleteFlagCm(flagger_id,comment_id){
	$.ajax({
		type: "DELETE",
		url: `/api/flagComments/delete/${flagger_id}/${comment_id}`,
		 success: function (data) {
			 console.log(data);
			if(data.success){
				var value=document.getElementById("FlagSpanCm").innerHTML="Flag";
			}else{
				alert(data.error);
			}
		} 
	});
}


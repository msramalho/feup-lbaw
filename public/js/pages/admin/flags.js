"use strict";
function deleteFlag(flagger_id,post_id){
	$.ajax({
		type: "DELETE",
		url: `/api/flagPosts/delete/${flagger_id}/${post_id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${flagger_id}']`).remove();
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
function hideErrorDiv() {
    $('div#addCmError').css('display', 'none');
}

function showErrorDiv() {
    $('div#addCmError').css('display', 'inherit');
}

function getCommentCount() {
    return parseInt($('#commentCount').attr('data-cc'));
}

function updateCommentCount(cc) {

    $('#commentCount').attr('data-cc', cc);
    let t;
    if (cc == 0) {
        t = 'No comments.';
    } else if (cc == 1) {
        t = '1 comment:';
    } else {
        t = cc + ' comments:';
    }
    $('#commentCount').text(t);
}

function insertComment(html) {
    let c = $('div.article-comments').children();
    $(c[c.length - 4]).after(html);
}

hideErrorDiv();
// on load

$('form#newComment').submit(function() {
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: $(this).serialize()
    }).done(function(data) {
        let rep = JSON.parse(data);
        if (rep[0] == "success") {
            hideErrorDiv();
            updateCommentCount(getCommentCount() + 1);
            insertComment(rep[1]);
            bindCommentButtons();
            $('form#newComment textarea').val('');

        } else {
            showErrorDiv();
        }
    }).fail(function(){
        showErrorDiv();
    });

    return false; // prevent form submission
});

function removeCommentDiv(cID){
    $("div[data-cid='c"+cID+"']").remove();
}

function bindCommentButtons(){
    $('.delete-comment').unbind();
    $('.edit-comment').unbind();
    $('.delete-comment').click(function() {
        let cID = parseInt($(this).parent().parent().attr('data-cid').substr(1));
    
        $.ajax({
            type: "DELETE",
            url: '/api/post/comment/'+cID,
        }).done(function(data) {
            let rep = JSON.parse(data);
            if (rep == "success") {
                removeCommentDiv(cID);
                updateCommentCount(getCommentCount() - 1);
            } else {
                
            }
        }).fail(function(){
            showDeleteErrorDiv(); // TODO
        });
    });

    $('.edit-comment').click(function() {
        let root = $(this).parent().parent();
        let editButton = $(this);
        let cID = parseInt(root.attr('data-cid').substr(1));

        let text = root.children('p').text();

        root.children('p').hide();
        root.append('<textarea style="margin-top:20px;" name="content" class="form-control" required>'+text+'</textarea><input type="submit" class="btn btn-primary float-right mt-2 submit-edited-comment" value="Submit"/>');
        root.append('<input type="submit" class="btn btn-secundary mr-2 float-right mt-2 cancel" value="Cancel"/>');
        root.addClass("edit");
        editButton.hide();

        root.find("input.cancel").click(function(){
            closeEditPane(root);
        });

        root.find("input.submit-edited-comment").click(function(){
            let nText = root.find('textarea').val();
            submitCommentEdit(root, cID, nText);
        });
        
    });
}

bindCommentButtons();


function closeEditPane(root){
    root.children('p').show();
    root.find('textarea').hide();
    root.find('input').hide();
    root.children('p').show();
    root.removeClass("edit");
    root.find('a.edit-comment').show();
}

$("#btn_upvote").click(function(e) {
    let btn = $(this);
    $.ajax({
        type: "POST",
        url: "/post/"+btn.attr("post_id")+"/vote",
    }).done(function(data) {
        data = JSON.parse(data);
        if(data.voted !== undefined){
            btn.toggleClass("voted");
            btn.attr("title", btn.attr("title-"+data["voted"]));
            let current_votes = parseInt($("#post-votes").html());
            current_votes += data.voted?1:-1;
            $("#post-votes").html(current_votes);
        } else {
            alert(data.error);
        }
    });
});

function updateComment(root, nText){
    root.children('p').text(nText);
}

function submitCommentEdit(root, cID, nText){
    $.ajax({
        type: "PUT",
        url: '../api/post/comment/'+cID,
         data: {content: nText}
    }).done(function(data) {
        let rep = JSON.parse(data);
        if (rep == "success") {
            closeEditPane(root);
            updateComment(root, nText);
        } else {
            swal({
                title: "Update failed. Try again later!",
                icon: "error",
                button: "Whoops!",
            });
        }
    }).fail(function(){
        swal({
            title: "Update failed. Try again later!",
            icon: "error",
            button: "Whoops!",
        });
    });
}
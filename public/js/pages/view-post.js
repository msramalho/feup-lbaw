function hideErrorDiv() {
    $('div#addCmError').css('display', 'none');
}

function showErrorDiv() {
    $('div#addCmError').css('display', 'inherit');
}

function getCommentCount() {
    return parseInt($('#commentCount').attr('cc'));
}

function updateCommentCount(cc) {

    $('#commentCount').attr('cc', cc);
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
            $('form#newComment textarea').val('');

        } else {
            showErrorDiv();
        }
    }).fail(function(){
        showErrorDiv();
    });

    return false; // prevent form submission
});


$('.delete-comment').click(function() {
    let cID = parseInt($(this).parent().parent().attr('id').substr(1));

    $.ajax({
        type: "DELETE",
        url: '/api/post/comment/'+cID,
    }).done(function(data) {
        let rep = JSON.parse(data);
        if (rep[0] == "success") {

        } else {
            
        }
    }).fail(function(){
        
    }).always(function(data){console.log(data)});

});

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
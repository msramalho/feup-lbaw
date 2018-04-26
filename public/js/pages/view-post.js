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

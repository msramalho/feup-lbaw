"use strict";
$(document).ready(function() {
    $(function () {
        $("input[name$='options']").change(function() {
            var test = $(this).val();
            $('.jqueryOptions').hide();
            $('.jqueryOptions').removeClass("d-none");
            $(".jqueryOptions." + test).show();
        });
    });

    $(".list-group-item").click( function() {
        fetchUser($(this).text());
        $('#showAllUsersModal').modal('hide');
    });

    $(function () {
        $("p.short").each(function(i, obj) {
            var tmp = document.createElement("div");
            tmp.innerHTML = obj.innerText;
            obj.innerHTML = tmp.innerText
        });
    });
});

function followUser(id){
    $.ajax({
        type: 'POST',
        url: `/user/${id}/follow`,

        success: function (data) {
            console.log(data);
            if(data.success){
                if ($("#follow").html() === "Follow"){
                    $("#follow").html("Unfollow");
                    swal({
                        title: "User Followed!",
                        icon: "success",
                        button: "Yey!",
                    });
                }
                else {
                    $("#follow").html("Follow");
                    swal({
                        title: "User Unfollowed!",
                        icon: "success",
                        button: ":(",
                    });
                }
            }else{
                swal({
                    title: "Failed to save data!",
                    text: data.error,
                    icon: "error",
                    button: "Whoops!",
                });
            }
        }
    });
}
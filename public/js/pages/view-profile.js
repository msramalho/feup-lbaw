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
                alert("Profile Successfully Updated!");
            }else{
                alert("Failed to save data!\n" + data.error);
            }
        }
    });
}
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

    $(function () {
        $("p#short").each(function(i, obj) {
            var tmp = document.createElement("div");
            tmp.innerHTML = obj.innerText;
            obj.innerHTML = tmp.innerText
        });
    });
});

"use strict";
$(document).ready(function() {
    $(function () {
        $("p#short").each(function(i, obj) {
            var tmp = document.createElement("div");
            tmp.innerHTML = obj.innerText;
            obj.innerHTML = tmp.innerText
        });
    });
});

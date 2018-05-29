"use strict";

let default_faculty = "<option selected>Faculty</option>";
$("#university_from, #university_to").change(function(e){
	let select = $(this);
	let target = $("#" + select.attr("targets"));
	if (isNaN(Number.parseInt(select.val()))) { target.html(default_faculty); return};
	$.ajax({
		type: "GET",
		url: "/api/university/"+select.val()+"/faculties",
	}).done(function(data) {
		if(data.error){ alert(data.error); return 0}
		data = JSON.parse(data);
		let target_html = "";
		data.forEach(faculty => {
			let selected = faculty.id == select.val()?"selected":"";
			target_html += `<option value='${faculty.id}' ${selected}>${faculty.name}</option>`;
		});
		target.html(target_html==""?default_faculty:target_html);
	});
});
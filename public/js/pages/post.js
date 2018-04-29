"use strict";
//see https://www.froala.com/wysiwyg-editor/docs/options#toolbarButtons
let toolbarButtons = ['bold', 'italic', 'strikeThrough', 'underline', 'quote', 'fontSize', '|', 'formatOL',
	'formatUL', 'insertHR', 'outdent', 'indent', 'insertTable', 'insertImage', 'spellChecker', 'html', 'emoticons',
	'|', 'help', 'undo', 'redo'
];
$('#postContent').froalaEditor({
	colorsText: "REMOVE",
	toolbarButtons: toolbarButtons,
	toolbarButtonsMD: toolbarButtons,
	toolbarButtonsSM: toolbarButtons,
	toolbarButtonsXS: toolbarButtons,
	placeholderText: "Write your post! You can use markdown or edit as html 😎",
	heightMin: 250
});

let default_faculty = "<option selected>From Faculty</option>";
$("#university_from, #university_to").change(function(e){
	let select = $(this);
	let target = $("#" + select.attr("targets"));
	if (isNaN(Number.parseInt(select.val()))) { target.html(default_faculty); return};
	$.ajax({
		type: "GET",
		url: "api/university/"+select.val()+"/faculties",
	}).done(function(data) {
		data = JSON.parse(data);
		let target_html = "";
		data.forEach(faculty => {
			let selected = faculty.id == select.val()?"selected":"";
			target_html += `<option value='${faculty.id}' ${selected}>${faculty.name}</option>`;
		});
		target.html(target_html==""?default_faculty:target_html);
	});
});
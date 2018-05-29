"use strict";
$(function() {
	startFroala($('#facDescription'));

	$("#newFacForm").submit(function(e){
		e.preventDefault();
		let form = $(this);
		$.ajax({
			type: "POST",
			url: "/api/faculty",
			data: form.serializeArray(),
			success: function (data) {
				if(data.success){
					$('#facModal').modal('hide');
					new_tr(data.faculty);
					$('#newFacForm')[0].reset();
				}else{
					alert(data.error);
				}
			}
		});
	});

	function new_tr(data){
		$("#tbody_faculties").append(Mustache.render(tr_template, data));
	}

});

let tr_template = `
<tr data-id="{{id}}">
	<th scope="row">{{id}}</th>
	<td>{{name}}</td>
	<td>{{city}}</td>
	<td>
		<a class="m-2" href="faculty/{{id}}" title="View faculty's pulic page"><i class="fas fa-eye"></i></a>
		<a class="m-2 ajax-link" onclick="editFac({{id}})" title="Edit faculty details"><i class="far fa-edit"></i></a>
		<a class="m-2 ajax-link"
		onclick="if(confirm('delete?')){ deleteFac('{{id}}'); }" title="Delete faculty registry"><i class="far fa-trash-alt"></i></a>
	</td>
</tr>`;

function editFac(id){
	$.ajax({
		type: "GET",
		url: `/faculty/${id}/edit`,
		success: function (data) {
			$('#edit_modal_container').html(data);
			startFroala($('#editFacDescription'));
			$("#facModalEdit").modal("show");
			$("#editFacForm").submit(function(e) {
				e.preventDefault();
				updateFac($(this).serializeArray(), id);
			});
		}
	});
}

function updateFac(form_data, id){
	$.ajax({
		type: "POST",
		url: `/api/faculty/${id}/edit`,
		data: form_data,
		success: function (data) {
			if(data.success){
				$('#facModalEdit').modal('hide');
				$(`tr[data-id='${id}']`).replaceWith(Mustache.render(tr_template, data.faculty));
			}else{
				alert(data.error);
			}
		}
	});
}

function deleteFac(id){
	$.ajax({
		type: "DELETE",
		url: `/api/faculty/${id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${id}']`).remove();
			}else{
				alert(data.error);
			}
		}
	});
}


//see https://www.froala.com/wysiwyg-editor/docs/options#toolbarButtons
let toolbarButtons = ['bold', 'italic', 'strikeThrough', 'underline', 'quote', 'fontSize', '|', 'formatOL',
	'formatUL', 'insertHR', 'outdent', 'indent', 'insertTable', 'insertImage', 'spellChecker', 'html', 'emoticons',
	'|', 'help', 'undo', 'redo'
];
	
function startFroala(element){
	element.froalaEditor({
		colorsText: "REMOVE",
		toolbarButtons: toolbarButtons,
		toolbarButtonsMD: toolbarButtons,
		toolbarButtonsSM: toolbarButtons,
		toolbarButtonsXS: toolbarButtons,
		placeholderText: "Provide a description for this faculty",
		heightMin: 250
	});
}
"use strict";
$(function() {
	//see https://www.froala.com/wysiwyg-editor/docs/options#toolbarButtons
	let toolbarButtons = ['bold', 'italic', 'strikeThrough', 'underline', 'quote', 'fontSize', '|', 'formatOL',
		'formatUL', 'insertHR', 'outdent', 'indent', 'insertTable', 'insertImage', 'spellChecker', 'html', 'emoticons',
		'|', 'help', 'undo', 'redo'
	];
	$('#uniDescription').froalaEditor({
		colorsText: "REMOVE",
		toolbarButtons: toolbarButtons,
		toolbarButtonsMD: toolbarButtons,
		toolbarButtonsSM: toolbarButtons,
		toolbarButtonsXS: toolbarButtons,
		placeholderText: "Provide a description for this univeristy",
		heightMin: 250
	});

	$("#newUniForm").submit(function(e){
		e.preventDefault();
		let form = $(this);
		$.ajax({
			type: "POST",
			url: "/university",
			data: form.serializeArray(),
			success: function (data) {
				if(data.success){
					$('#uniModal').modal('hide');
					new_tr(data.university);
				}else{
					alert(data.error);
				}
			}
		});
	});

	function new_tr(data){
		$("#tbody_universities").append(Mustache.render(tr_template, data));
	}

});

let tr_template = `
<tr data-id="{{id}}">
	<th scope="row">{{id}}</th>
	<td>{{name}}</td>
	<td>{{country}}</td>
	<td><a title="Manage this university's faculties" href="admin/faculties/{{id)}}">{{faculties}}</a></td>
	<td>
		<a class="m-2" href="university/{{id}}" title="View university's pulic page"><i class="fas fa-eye"></i></a>
		<a class="m-2" href="#" onclick="editUni({{id}})" title="Edit university details"><i class="far fa-edit"></i></a>
		<a class="m-2" href="#" onclick="if(confirm('delete?')){ deleteUni('{{$university->id}}'); }" title="Delete university registry"><i class="far fa-trash-alt"></i></a>
	</td>
</tr>`;

function editUni(id){
	$.ajax({
		type: "GET",
		url: `/university/${id}/edit`,
		success: function (data) {
			$('#edit_modal_container').html(data);
			$("#uniModalEdit").modal("show");
			$("#editUniForm").submit(function(e) {
				e.preventDefault();
				updateUni($(this).serializeArray(), id);
			});
		}
	});
}

function updateUni(form_data, id){
	$.ajax({
		type: "POST",
		url: `/university/${id}/edit`,
		data: form_data,
		success: function (data) {
			console.log(data);
			if(data.success){
				$('#uniModalEdit').modal('hide');
				$(`tr[data-id='${id}']`).replaceWith(Mustache.render(tr_template, data.university));
			}else{
				alert(data.error);
			}
		}
	});
}

function deleteUni(id){
	$.ajax({
		type: "DELETE",
		url: `/university/${id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${id}']`).remove();
			}else{
				alert(data.error);
			}
		}
	});
}
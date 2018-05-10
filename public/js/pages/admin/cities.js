"use strict";
$(function() {
	$("#newCityForm").submit(function(e){
		e.preventDefault();
		let form = $(this);
		$.ajax({
			type: "POST",
			url: "/api/city",
			data: form.serializeArray(),
			success: function (data) {
				if(data.success){
					$('#cityModal').modal('hide');
					new_tr(data.city);
				}else{
					alert(data.error);
				}
			}
		});
	});

	function new_tr(data){
		$("#tbody_cities").append(Mustache.render(tr_template, data));
	}

});

let tr_template = `
<tr data-id="{{id}}">
	<th scope="row">{{id}}</th>
	<td>{{name}}</td>
	<td>{{country}}</td>
	<td>
		<a class="m-2 ajax-link" onclick="editCity({{id}})" title="Edit city details"><i class="far fa-edit"></i></a>
		<a class="m-2 ajax-link" onclick="if(confirm('delete?')){ deleteCity('{{id}}'); }" title="Delete city"><i class="far fa-trash-alt"></i></a>
	</td>
</tr>`;

function editCity(id){
	$.ajax({
		type: "GET",
		url: `/city/${id}/edit`,
		success: function (data) {
			$('#edit_modal_container').html(data);
			$("#cityModalEdit").modal("show");
			$("#editCityForm").submit(function(e) {
				e.preventDefault();
				updateCity($(this).serializeArray(), id);
			});
		}
	});
}

function updateCity(form_data, id){
	$.ajax({
		type: "POST",
		url: `/api/city/${id}/edit`,
		data: form_data,
		success: function (data) {
			if(data.success){
				$('#cityModalEdit').modal('hide');
				$(`tr[data-id='${id}']`).replaceWith(Mustache.render(tr_template, data.city));
			}else{
				alert(data.error);
			}
		}
	});
}

function deleteCity(id){
	$.ajax({
		type: "DELETE",
		url: `/city/${id}`,
		success: function (data) {
			if(data.success){
				$(`tr[data-id='${id}']`).remove();
			}else{
				alert(data.error);
			}
		}
	});
}

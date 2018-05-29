"use strict";
$(function () {
	//see https://www.froala.com/wysiwyg-editor/docs/options#toolbarButtons
	let toolbarButtons = ['bold', 'italic', 'strikeThrough', 'underline', 'quote', 'fontSize', '|', 'formatOL',
		'formatUL', 'insertHR', 'outdent', 'indent', 'insertTable', 'insertImage', 'spellChecker', 'html', 'emoticons',
		'|', 'help', 'undo', 'redo'
	];
	$('textarea#postContent').froalaEditor({
		colorsText: "REMOVE",
		toolbarButtons: toolbarButtons,
		toolbarButtonsMD: toolbarButtons,
		toolbarButtonsSM: toolbarButtons,
		toolbarButtonsXS: toolbarButtons,
		placeholderText: "Write something about you! You can use markdown or edit as html 😎",
		heightMin: 250
	});
});

$("#saveChanges").click(function(e){
    var myurl = "/user/edit";

    e.preventDefault();
    var form_info = $("#form-info input");
    var description = $(".form-group textarea#postContent");

    var my_data = {
        'name' : form_info.get(0).value,
        'username' : form_info.get(1).value,
        'birthdate' : form_info.get(2).value,
        'email' : form_info.get(3).value,
        'description' : description.get(0).value
    }
    console.log(my_data);
    var type = 'POST';

    $.ajax({
        type: type,
        url: myurl,
        data: my_data,
        dataType : 'json',

        success: function (data) {
            if(data.success){
                swal({
                    title: "Profile Successfully Updated!",
                    icon: "success",
                    button: "Noice!",
                });
            }else{
                swal({
                    title: "Failed to save data!",
                    text: data.error,
                    icon: "error",
                    button: "Whoops!",
                });
            }
        },

        error: function (data) {
            swal({
                title: "Failed to save data!",
                text: data.error,
                icon: "error",
                button: "Whoops!",
            });
        }
    });
});
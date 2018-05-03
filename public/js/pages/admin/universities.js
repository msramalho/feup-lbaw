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
		console.log(e);
	});
});
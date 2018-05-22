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
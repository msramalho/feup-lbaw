function copyToClipboard(text){
	var textArea = document.createElement("textarea");
	textArea.value = text;
	document.body.appendChild(textArea);
	textArea.focus();
	textArea.select();
	
	/* Copy the text inside the text field */
	document.execCommand("Copy");
	
	alert("text coppied successfully");

	document.body.removeChild(textArea);
}

(function(proxied) {
	window.alert = function(text) {
		return swal(text, {
			timer: 5000
		});
	};
})(window.alert);
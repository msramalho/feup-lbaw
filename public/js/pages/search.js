"use strict";

$(function() {
	$('ul.pagination').hide();
	$('.infinite-scroll').jscroll({
		autoTrigger: true,
		loadingHtml: '<img class="center-block" src="/images/loading.gif" alt="Loading..." />',
		padding: 0,
		nextSelector: '.pagination li.active + li a',
		contentSelector: 'div.infinite-scroll',
		callback: function() {
			console.log("done");
			$('ul.pagination').remove();
		}
	});

});

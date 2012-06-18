$(function(){

	$('#right').masonry({ 
	    itemSelector : '.post',
	    columnWidth : 220
	});
	$('a[rel*=facybox]').facybox();
});
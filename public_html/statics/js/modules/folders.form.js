// JavaScript Document

$(function() {
	
	var CONTEXT = typeof($dialog) == 'undefined' ? $('body'):$dialog;
	
	$('select.tags',CONTEXT).itemsField({
		labelAdd : 'Ajouter ce tag',
		source : '/tags.json'
	});
	
});
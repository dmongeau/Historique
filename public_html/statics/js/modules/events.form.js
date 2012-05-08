// JavaScript Document

$(function() {
	
	$('select.tags').itemsField({
		labelAdd : 'Ajouter ce tag',
		source : '/tags.json'
	});
	
	$('select.folder').itemsField({
		labelAdd : 'Créer un nouveau dossier',
		source : '/dossiers.json',
		create : function(add) {
			alert('add');
		}
	});
	
});
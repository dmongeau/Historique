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
			$('<div></div>').formDialog({
				url : '/dossiers/ajouter.html',
				javascript : '/statics/js/modules/folders.form.js',
				title : 'Créer un nouveau dossier',
				dialogOptions : {
					width : 500
				},
				success : function(e,ui) {
					console.log('success',e,ui);
				}
			});
		}
	});
	
});
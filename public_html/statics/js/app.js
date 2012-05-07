// JavaScript Document

$.ajaxSetup({cache: false});
$.datepicker.regional['fr'] = {
	closeText: 'Fermer',
	prevText: '&#x3c;Préc',
	nextText: 'Suiv&#x3e;',
	currentText: 'Courant',
	monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
	'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
	monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
	'Jul','Aoû','Sep','Oct','Nov','Déc'],
	dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
	dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
	dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''};
$.datepicker.setDefaults($.datepicker.regional['fr']);

$(function() {
		
		
		
	$('input.hint, textarea.hint').hint();
	
	
	
	$('input.date').datepicker({
		dateFormat : 'yy-mm-dd',
		prevText : '&lt;'	,
		nextText : '&gt;'	,
		weekHeader : 'W',
		buttonImage: "/statics/img/icons/date.png",
		showOn: "both",
		changeYear: true,
		changeMonth: true,
		showOtherMonths: true,
		constrainInput: true
	});
	
	
	
});

/*
 *
 * Facebook Javascript SDK
 *
 */
window.fbAsyncInit = function() {
	FB.init({appId: FB_APPID, status: true, cookie: true, xfbml: true});
};
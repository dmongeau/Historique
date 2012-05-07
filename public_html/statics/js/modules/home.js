google.load('visualization', '1', {packages: ['corechart']});


var NUMBER_OF_DAYS_BEFORE = 30;
var DAY = 3600*24;

function drawVisualization() {
	var rows = [];
	rows.push(['Date', "Nombre d'événements"]);
	var now = new Date();
	for(var i = 0; i < (NUMBER_OF_DAYS_BEFORE+1); i++) {
		var daysBefore = NUMBER_OF_DAYS_BEFORE-i;
		var date = new Date();
		date.setTime(now.getTime()-(daysBefore*DAY*1000));
		var key = $.datepicker.formatDate('yy-mm-dd',date);
		var label = $.datepicker.formatDate('D, d M',date);
		rows.push([label, typeof(EVENTS[key]) != 'undefined' ? EVENTS[key]:0]);
	}
	var data = google.visualization.arrayToDataTable(rows);
	
	var opts = {
		chartArea: {
			top:0,
			width:"95%",
			height:'90%'
		},
		legend: {
			position: 'none'
		},
		width: 960,
		height: 200,
		vAxis: {
			textPosition : 'none',
			maxValue: Math.ceil(EVENTS_MAX_VALUE*1.1),
			gridlines: {color: '#ccc', count: 5}
		},
		hAxis: {
			showTextEvery : 5,
			gridlines: {color: '#ccc', count: 30}
		}
	};
	
	var chart = new google.visualization.LineChart(document.getElementById('timeline'));
	chart.draw(data,opts);
	
}

google.setOnLoadCallback(drawVisualization);

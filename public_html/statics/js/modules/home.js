google.load('visualization', '1', {packages: ['corechart']});


var NUMBER_OF_DAYS_BEFORE = 30;
var DAY = 3600*24;

function drawVisualization() {
	var rows = [];
	var cols = ['Date'];
	for(var i = 0; i < EVENTS_COLS.length; i++) {
		cols.push(EVENTS_COLS[i]);
	}
	rows.push(cols);
	var now = new Date();
	for(var i = 0; i < (NUMBER_OF_DAYS_BEFORE+1); i++) {
		var daysBefore = NUMBER_OF_DAYS_BEFORE-i;
		var date = new Date();
		date.setTime(now.getTime()-(daysBefore*DAY*1000));
		var key = $.datepicker.formatDate('yy-mm-dd',date);
		var label = $.datepicker.formatDate('D, d M',date);
		/*var col = [label];
		if(typeof(EVENTS[key]) != 'undefined') {
			for(var key in EVENTS[key]) {
				col.push(0);
			}
		} else {
			for(var key in EVENTS[key]) {
				col.push(0);
			}
		}*/
		var row = [label];
		if(typeof(EVENTS[key]) == 'undefined') {
			for(var k in EVENTS_COLS) {
				row.push(0);
			}
		} else {
			for(var k in EVENTS_COLS) {
				row.push(EVENTS[key][EVENTS_COLS[k]]);
			}
		}
		rows.push(row);
	}
	console.log(EVENTS_COLS);
	console.log(cols);
	console.log(rows);
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
	console.log(chart);
	chart.draw(data,opts);
	
}

google.setOnLoadCallback(drawVisualization);

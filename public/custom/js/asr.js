var DATA_COUNT = 12;
var jan = $("#jan").val();
var feb = $("#feb").val();
var mar = $("#mar").val();
var apr = $("#apr").val();
var may = $("#may").val();
var jun = $("#jun").val();
var jul = $("#jul").val();
var aug = $("#aug").val();
var sep = $("#sep").val();
var oct = $("#oct").val();
var nov = $("#nov").val();
var dec = $("#dec").val();

var graph_1 = JSON.parse($("#chart_data_0").val());
var graph_2 = JSON.parse($("#chart_data_1").val());
var graph_3 = JSON.parse($("#chart_data_2").val());
var graph_4 = JSON.parse($("#chart_data_3").val());

var utils = Samples.utils;

utils.srand(110);

function getLineColor(ctx) {
	return '#00a65a';//utils.color(ctx.datasetIndex);
}

function getLineBorderColor(ctx) {
	return '#000000';//utils.color(ctx.datasetIndex);
}

function getLineColorForRound(ctx) {
	return '#dd4b39';//utils.color(ctx.datasetIndex);
}

function alternatePointStyles(ctx) {
	var index = ctx.dataIndex;
	//return index % 2 === 0 ? 'circle' : 'rect';
	return 'circle';
}

function makeHalfAsOpaque(ctx) {
	return utils.transparentize(getLineColor(ctx));
}

function adjustRadiusBasedOnData(ctx) {
	var v = ctx.dataset.data[ctx.dataIndex];
	return v < 10 ? 5
		: v < 25 ? 7
		: v < 50 ? 9
		: v < 75 ? 11
		: 5;
}

function generateData() {
	return utils.numbers({
		count: DATA_COUNT,
		min: 0,
		max: 100
	});
}

var data = {
	//labels: utils.months({count: DATA_COUNT}),
	labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
	datasets: [{
		data: [graph_1[0],graph_1[1],graph_1[2],graph_1[3],graph_1[4],graph_1[5],graph_1[6],graph_1[7],graph_1[8],graph_1[9],graph_1[10],graph_1[11]]
	}]
};

var options = {
	legend: false,
	//tooltips: true,
	tooltips: {
		callbacks: {
			labelColor: function(tooltipItem, chart) {
				return {
					borderColor: 'rgb(255, 0, 0)',
					backgroundColor: 'rgb(255, 0, 0)'
				};
			},
			labelTextColor: function(tooltipItem, chart) {
				return '#FFFFFF';
			}
		}
	},
	elements: {
		line: {
			fill: false,
			backgroundColor: getLineColor,
			borderColor: getLineColor,
		},
		point: {
			backgroundColor: getLineColorForRound,
			hoverBackgroundColor: makeHalfAsOpaque,
			radius: adjustRadiusBasedOnData,
			pointStyle: alternatePointStyles,
			hoverRadius: 10,
		}
	}
};

var chart = new Chart('chart-0', {
	type: 'line',
	data: data,
	options: options
});


/*********************************************************/
var dataWeight = {
	labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
	datasets: [{
		data: [graph_2[0],graph_2[1],graph_2[2],graph_2[3],graph_2[4],graph_2[5],graph_2[6],graph_2[7],graph_2[8],graph_2[9],graph_2[10],graph_2[11]]
	}]
};

var chart1 = new Chart('chart-1', {
	type: 'line',
	data: dataWeight,
	options: options
});

/*********************************************************/
var dataHeight = {
	labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
	datasets: [{
		data: [graph_3[0],graph_3[1],graph_3[2],graph_3[3],graph_3[4],graph_3[5],graph_3[6],graph_3[7],graph_3[8],graph_3[9],graph_3[10],graph_3[11]]
	}]
};

var chart1 = new Chart('chart-2', {
	type: 'line',
	data: dataHeight,
	options: options
});

/*********************************************************/
var dataMilk = {
	labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
	datasets: [{
		data: [graph_4[0],graph_4[1],graph_4[2],graph_4[3],graph_4[4],graph_4[5],graph_4[6],graph_4[7],graph_4[8],graph_4[9],graph_4[10],graph_4[11]]
	}]
};

var chart1 = new Chart('chart-3', {
	type: 'line',
	data: dataMilk,
	options: options
});
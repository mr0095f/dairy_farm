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

if($("#myChart").length > 0){
	var ctx = document.getElementById("myChart").getContext('2d');
	var graphArr1 = JSON.parse($("#monthly_milk_sale").val());
	var myChart = new Chart(ctx, {
	  type: 'line',
	  data: {
		  labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
		  datasets: [{
			  label: '# of Votes',
			  data: [ graphArr1[1],graphArr1[2],graphArr1[3],graphArr1[4],graphArr1[5],graphArr1[6],graphArr1[7],graphArr1[8],graphArr1[9],graphArr1[10],graphArr1[11],graphArr1[12] ],
			  backgroundColor: [
					  'rgba(11, 102, 35)'
				  ],
				  borderColor: [
					  'rgba(11, 102, 35)'
				  ],
				  pointBackgroundColor: [
					 '#000000'
				  ],
				  borderWidth: 1
		  }]
	  },
	  options: {
		  tooltips: {
			callbacks: {
			  label: function(tooltipItem) {
				  return dairyFarm.currency(Number(tooltipItem.yLabel));
			  }
			}
		  },
		  responsive: true,
		  scales: {
			  yAxes: [{
				  ticks: {
					  beginAtZero:true
				  }
			  }]
		  },
		  legend: {
			  position: 'top',
			  display: false
		  },
		  title: {
			  display: false,
			  text: 'Chart.js Bar Chart'
		  }
	  }
	});
}

if($("#myChart2").length > 0){
	var ctx = document.getElementById("myChart2").getContext('2d');
	var graphArr2 = JSON.parse($("#monthly_expense").val());
	var myChart = new Chart(ctx, {
	  type: 'line',
	  data: {
		  labels: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec],
		  datasets: [{
			  label: '# of Votes',
			  data: [ graphArr2[1],graphArr2[2],graphArr2[3],graphArr2[4],graphArr2[5],graphArr2[6],graphArr2[7],graphArr2[8],graphArr2[9],graphArr2[10],graphArr2[11],graphArr2[12] ],
			  backgroundColor: [
					  'rgba(11, 102, 35)'
				  ],
				  borderColor: [
					  'rgba(11, 102, 35)'
				  ],
				  pointBackgroundColor: [
					 '#000000'
				  ],
				  borderWidth: 1
		  }]
	  },
	  options: {
		  tooltips: {
			callbacks: {
			  label: function(tooltipItem) {
				  return dairyFarm.currency(Number(tooltipItem.yLabel));
			  }
			}
		  },
		  responsive: true,
		  scales: {
			  yAxes: [{
				  ticks: {
					  beginAtZero:true
				  }
			  }]
		  },
		  legend: {
			  position: 'top',
			  display: false
		  },
		  title: {
			  display: false,
			  text: ''
		  }
	  }
	});
}
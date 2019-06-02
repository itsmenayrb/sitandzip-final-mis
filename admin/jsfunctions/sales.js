$(document).ready(function() {

    $('#inventory-table-outofstock').DataTable({
      'scrollX': true
    });

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var start = start.format('YYYY-MM-DD HH:mm:ss');
        var end = end.format('YYYY-MM-DD HH:mm:ss');

        // console.log(start);
        // console.log(end);

		totalSalesAmount(start, end);        
 		detailedSales(start, end);
 		displayChartedSales(start, end);
    totalExpensesAmount(start, end);
    netProfitAmount(start, end);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    function totalSalesAmount(start, end) {
    	$.ajax({
       		method: 'POST',
       		url: './controller/SalesController.php',
       		data: {
       			from: start,
       			to: end,
       			getSales: 1
       		},
       		dataType: 'json',
       		success: function(response) {
       			$('#totalSales').text("P " + response);
       		} 

       	});
    }

    function totalExpensesAmount(start, end) {
      $.ajax({
          method: 'POST',
          url: './controller/InventoryController.php',
          data: {
            from: start,
            to: end,
            getExpenses: 1
          },
          dataType: 'json',
          success: function(response) {
            $('#totalExpenses').text("P " + response);
          } 

        });
    }

    function netProfitAmount(start, end) {
      $.ajax({
          method: 'POST',
          url: './controller/SalesController.php',
          data: {
            from: start,
            to: end,
            getProfit: 1
          },
          dataType: 'json',
          success: function(response) {
            $('#netProfit').text("P " + response);
          } 

        });
    }

    function detailedSales(start, end) {
    	$.ajax({
       		method: 'POST',
       		url: './controller/SalesController.php',
       		data: {
       			from: start,
       			to: end,
       			getDetailedSales: 1
       		},
       		dataType: 'html',
       		success: function(response) {
       			$('#sales-table tbody').html(response);
            $('#sales-table').DataTable({
              "scrollX": true,
              "destroy": true,
              'retrieve': true,
              dom: 'Bfrtip',
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'print'
              ]
            });
       		} 

       	});	
    }

	function displayChartedSales(start, end) {

		$.ajax({
			method: 'POST',
			url: './controller/SalesController.php',
			data: {
				from: start,
				to: end,
				getSalesGraph: 1
			},
			dataType: 'json',
			success: function(response) {
				var ctx = document.getElementById('myChart').getContext('2d');
				var myChart = new Chart(ctx, {
				    type: 'bar',

				    data: {
				        datasets: [{
				        	label: 'Amount in bar',
				            data: response.amount,
				            backgroundColor: 'rgba(251, 198, 88, 0.5)',
				            borderColor: '#fbc658'
				        }, {
				        	label: 'Amount in line',
				            data: response.amount,
				            backgroundColor: 'rgba(81, 188, 218, 0.2)',
				            borderColor: '#51bcda',

				            // Changes this dataset to become a line
				            type: 'line'
				        }],
				        labels: response.sales_date
				    },
				    options: {
				        legend: {
                  display: false
                },

                tooltips: {
                  enabled: false
                },

                scales: {
                  yAxes: [{

                    ticks: {
                      fontColor: "#9f9f9f",
                      beginAtZero: false,
                      maxTicksLimit: 5,
                      //padding: 20
                    },
                    gridLines: {
                      drawBorder: false,
                      zeroLineColor: "#ccc",
                      color: 'rgba(255,255,255,0.05)'
                    }

                  }],

                  xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                      drawBorder: false,
                      color: 'rgba(255,255,255,0.1)',
                      zeroLineColor: "transparent",
                      display: false,
                    },
                    ticks: {
                      padding: 20,
                      fontColor: "#9f9f9f"
                    }
                  }]
                },
				    }
				});
			}
		});
	}


});
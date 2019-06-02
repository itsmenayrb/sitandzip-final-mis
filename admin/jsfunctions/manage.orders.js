$(document).ready(function() {

	$('.processOrderBtn').on('click', function() {

		var transaction_id = $(this).data('id');
		var transacted_by = $(this).data('name');
		//console.log(transacted_by);
		//alert(transaction_id);

		Swal.fire({
            title: 'Process transaction no: ' + transaction_id + '?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
          }).then((result) => {
          	if(result.value) {
            	Swal.fire({
		          title: 'Processing...',
		          timer: 1000,
		          onBeforeOpen: () => {
		            Swal.showLoading()
		          }
		        });
		        setTimeout(function() {
	            	$.ajax({
	                  method: 'POST',
	                  url: './controller/OrdersController.php',
	                  data: {
	                    transaction_id: transaction_id,
	                    transact_by: transacted_by,
	                    processOrder: 1
	                  },
	                  dataType: 'text',
	                  success: function(response) {
	                  	Swal.fire({
	                        title: response,
	                        type: 'success',
	                        confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if(result.value) {
	                  			window.location = './manage.orders.php';
	                  		}
	                  	});
	                  }
	              	});
	            }, 1000);
		    }

        });
	});


});
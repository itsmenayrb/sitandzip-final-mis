
$(document).ready(function() {

	// $(window).on('load', function() {


	// });
	var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var start = start.format('YYYY-MM-DD HH:mm:ss');
        var end = end.format('YYYY-MM-DD HH:mm:ss');

        totalExpensesAmount(start, end);
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
	

	$('.datepicker').datepicker();

	function displayInventoryItem() {

		$.ajax({
			method: 'GET',
			url: './controller/InventoryController.php?list=inventory',
			dataType: 'html',
			success: function(response) {
				$('#inventory-table tbody').html(response);
				
			}

		});

	}

	$('#inventory-table').DataTable({
		'scrollX': true
	});

	$('#inventory-table-outofstock').DataTable({
		'scrollX': true
	});

	$('#detailed-inventory-table').DataTable({
		'scrollX': true,
		dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ]
	});


	$('#inventoryBtn').on('click', function() {

		var employee_id = $('#hiddenGetEmployeeId').val();
		var item = $('#itemname').val();
		var description = $('#item_description').val();
		var qty = $('#item_quantity').val();
		var price = $('#itemprice').val();

		var date_purchased = $('#date_purchased').val();


		// console.log(date_purchased);
		if (moment(date_purchased, 'MM/DD/YYYY', true).isValid()) {
			
			if (qty < 1) {
				Swal.fire({
		            title: 'Invalid quantity',
		            type: 'error',
		        });

			} else {

				if (!isNumeric(price)) {
					Swal.fire({
			            title: 'Invalid price amount',
			            type: 'error',
			        });	
				} else {

					if (item == '' || description == '' || qty == '' || price == '') {
						$('#error').text('All fields are required.');
					} else {

						$.ajax({
							method: 'POST',
							url: './controller/InventoryController.php',
							data: {
								employee_id: employee_id,
								item: item,
								description: description,
								qty: qty,
								price: price,
								date_purchased: date_purchased,
								save_item: 1
							},
							dataType: 'json',
							success: function(response) {

								if (response.error) {
									$('#error').text(response.error);
								} else if (response.success) {
									Swal.fire({
				                        title: response.success,
				                        type: 'success',
				                        confirmButtonColor: '#3085d6',
			                            confirmButtonText: 'OK'
			                          }).then((result) => {
			                            if(result.value) {
				                  			window.location = './inventory.php';
				                  		}
				                  	});
								}

							}

						});

					}

				}

			}

		} else {

			Swal.fire({
	            title: 'Invalid date',
	            type: 'error',
	        });
		
		}
		




		return false;


	});


	$('.itemUpdateBtn').on('click', function() {

		var item_id = $(this).data('id');
		$('.modal #hiddenItemId').val(item_id);

		$.ajax({
			method: 'post',
			url: './controller/InventoryController.php',
			data: {
				item_id: item_id,
				show_item: 1
			},
			dataType: 'html',
			success: function(response) {
				$('#item-to-update-container').html(response);
			}


		});


	});

	$('.saveUpdateItemBtn').on('click', function(e) {

		e.preventDefault();

		var item_id = $('#hiddenItemId').val();
		var employee_id = $('#hiddenGetEmployeeId').val();
		var new_itemname = $('#current_itemname').val();
		var new_itemprice = $('#current_itemprice').val();
		var new_itemquantity = $('#current_item_quantity').val();
		var new_itemdescription = $('#current_item_description').val();

		var new_datepurchased = $('#current_date_purchased').val();

		if (moment(new_datepurchased, 'MM/DD/YYYY', true).isValid()) {
			
			if (new_itemquantity < 0) {
				Swal.fire({
		            title: 'Invalid quantity',
		            type: 'error',
		        });

			} else {

				if (!isNumeric(new_itemprice)) {
					Swal.fire({
			            title: 'Invalid price amount',
			            type: 'error',
			        });	
				} else {

					if (new_itemname == '' || new_itemdescription == '' || new_itemquantity == '' || new_itemprice == '') {
						$('#error-update').text('All fields are required.');
					} else {

						$.ajax({
							method: 'POST',
							url: './controller/InventoryController.php',
							data: {
								item_id, item_id,
								employee_id: employee_id,
								item: new_itemname,
								description: new_itemdescription,
								qty: new_itemquantity,
								price: new_itemprice,
								date_purchased: new_datepurchased,
								update_item: 1
							},
							dataType: 'json',
							success: function(response) {

								if (response.success) {
									Swal.fire({
				                        title: response.success,
				                        type: 'success',
				                        confirmButtonColor: '#3085d6',
			                            confirmButtonText: 'OK'
			                          }).then((result) => {
			                            if(result.value) {
				                  			window.location = './inventory.php';
				                  		}
				                  	});
								} else if (response.error) {
									$('#error-update').text(response.error);
								}
	

							}

						});

					}

				}

			}

		} else {

			Swal.fire({
	            title: 'Invalid date',
	            type: 'error',
	        });
		
		}

		return false;

	});


	$('.itemArchiveBtn').on('click', function(e) {

		e.preventDefault();

		var item_id = $(this).data('id');	

		Swal.fire({
            title: 'Do you want to void this item?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
          }).then((result) => {
            if(result.value) {
                $.ajax({
                  method: 'POST',
                  url: './controller/InventoryController.php',
                  data: {
                    item_id: item_id,
                    archive_item: 1
                  },
                  dataType: 'json',
                  success: function(response) {
                  	if(response.success === 'ok') {
	                	Swal.fire({
	                        title: 'Item voided successfully!',
	                        type: 'success',
	                        confirmButtonColor: '#3085d6',
	                        confirmButtonText: 'OK'
	                    }).then((result) => {
	                        if(result.value) {
	                  			window.location = './inventory.php';
	                  		}
	                  	});
                  	}
                  }
                });
            }
        });
	});

	$('#displayItemSelect').on('change', function(e) {
		e.preventDefault();
		var item_id = $(this).val();
		$('#hiddenGetItemId').val(item_id);

		$.ajax({
			method: 'POST',
			url: './controller/InventoryController.php',
			data: {
				item_id: item_id,
				getDetailsOfSelectedItem: 1
			},
			dataType: 'text',
			success: function(response) {

		  		$('#getItemQuantityModal').modal()
		  		$('#getItemQuantityModal .modal-title').text("Remaining stocks: " + response);

			}
		});

	});

	$('#getItemModal').on('hidden.bs.modal', function() {
		window.location = './inventory.php';
	});

	$('#getItemQuantityBtn').on('click', function(e){
		e.preventDefault();


		var item_quantity = $('#getItemQuantityInput').val();
		var item_id = $('#hiddenGetItemId').val();

		if (item_quantity != "") {
			if (item_quantity < 1) {
				Swal.fire({
		            title: 'Quantity must be at least 1',
		            type: 'error',
		        });
			} else {
				if (!isNumeric(item_quantity)) {
					Swal.fire({
			            title: 'Invalid quantity',
			            type: 'error',
			        });
				} else {
					$.ajax({
	                  method: 'POST',
	                  url: './controller/InventoryController.php',
	                  data: {
	                    item_id: item_id,
	                    item_quantity: item_quantity,
	                    getItemFromDb: 1
	                  },
	                  dataType: 'json',
	                  success: function(response) {
	                  		if (response.error) {
	                  			Swal.fire({
						            title: response.error,
						            type: 'error',
						        });
	                  		} else if (response.success) {
	                  			Swal.fire({
						            title: response.success,
						            type: 'success',
						        });
						        $('#getItemQuantityModal').modal('hide');
	                  		}
	                  }
	                });
				}
			}

		} else {
			Swal.fire({
	            title: 'Input quantity',
	            type: 'error',
	        });
		}
		
		return false;
	});


	function validatePrice(number) {
    	var re = /^[0-9.,]*$/;
    	return re.test(number);
    }

    function isNumeric(n) {
	  return !isNaN(n);
	}


});
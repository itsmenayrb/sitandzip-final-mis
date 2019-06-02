$(document).ready(function() {

	$('#categoriesArchivedTable').DataTable({
		'destroy': true,
		'retrieve': true
	});

	$('#productArchivedTable').DataTable({
		'destroy': true,
		'retrieve': true
	});

	$('#itemArchivedTable').DataTable({
		'destroy': true,
		'retrieve': true
	});

	$('#userArchivedTable').DataTable({
		'destroy': true,
		'retrieve': true
	});


	$('.restoreThisCategory').on('click', function() {

		var category_id = $(this).data('id');
		var category_name = $(this).data('name');
		// alert(category_id);
		Swal.fire({
            title: 'Do you want to restore '+ category_name +'?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Restore it!',
          }).then((result) => {
            if(result.value) {
            	Swal.fire({
		          title: 'Restoring...',
		          timer: 1000,
		          onBeforeOpen: () => {
		            Swal.showLoading()
		          }
		        });
		        setTimeout(function() {
	            	$.ajax({
	                  method: 'POST',
	                  url: './controller/ArchivesController.php',
	                  data: {
	                    category_id: category_id,
	                    restoreCategory: 1
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
	                  			window.location = './archives.php';
	                  		}
	                  	});
	                  }
	              	});
	            }, 1000);
            }

        });

	});

	$('.restoreThisProduct').on('click', function() {

		var product_id = $(this).data('id');
		var product_name = $(this).data('name');
		// alert(category_id);
		Swal.fire({
            title: 'Do you want to restore '+ product_name +'?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Restore it!',
          }).then((result) => {
            if(result.value) {
            	Swal.fire({
		          title: 'Restoring...',
		          timer: 1000,
		          onBeforeOpen: () => {
		            Swal.showLoading()
		          }
		        });
		        setTimeout(function() {
	            	$.ajax({
	                  method: 'POST',
	                  url: './controller/ArchivesController.php',
	                  data: {
	                    product_id: product_id,
	                    restoreProduct: 1
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
	                  			window.location = './archives.php';
	                  		}
	                  	});
	                  }
	              	});
	            }, 1000);
            }

        });

	});


	$('.restoreThisItem').on('click', function() {

		var item_id = $(this).data('id');
		var item_name = $(this).data('name');
		// alert(category_id);
		Swal.fire({
            title: 'Do you want to restore '+ item_name +'?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Restore it!',
          }).then((result) => {
            if(result.value) {
            	Swal.fire({
		          title: 'Restoring...',
		          timer: 1000,
		          onBeforeOpen: () => {
		            Swal.showLoading()
		          }
		        });
		        setTimeout(function() {
	            	$.ajax({
	                  method: 'POST',
	                  url: './controller/ArchivesController.php',
	                  data: {
	                    item_id: item_id,
	                    restoreItem: 1
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
	                  			window.location = './archives.php';
	                  		}
	                  	});
	                  }
	              	});
	            }, 1000);
            }

        });

	});

	$('.restoreThisAccount').on('click', function() {

		var employee_id = $(this).data('id');
		var employee_username = $(this).data('name');
		// alert(category_id);
		Swal.fire({
            title: 'Do you want to restore '+ employee_username +'?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Restore it!',
          }).then((result) => {
            if(result.value) {
            	Swal.fire({
		          title: 'Restoring...',
		          timer: 1000,
		          onBeforeOpen: () => {
		            Swal.showLoading()
		          }
		        });
		        setTimeout(function() {
	            	$.ajax({
	                  method: 'POST',
	                  url: './controller/ArchivesController.php',
	                  data: {
	                    employee_id: employee_id,
	                    restoreAccount: 1
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
	                  			window.location = './archives.php';
	                  		}
	                  	});
	                  }
	              	});
	            }, 1000);
            }

        });

	});

});
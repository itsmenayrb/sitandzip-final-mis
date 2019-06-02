/**
 * Javascript file for managing products
 * This file should contain functions, events, validation
 * When interacting with products.
 */

$(document).ready(function() {

	/**
	 * Wait for the dom to be ready
	 * 
	 */
	
		/**
		 * Function for getting data from the database
		 * that will display in the table.
		 */
	
		function getProductList() {
		    $.ajax({
		      method: 'GET',
		      url: './controller/ProductsController.php?list=product',
		      dataType: 'html',
		      success: function(response){
		        $('#table-product tbody').html(response);
            $('#table-product').DataTable({
              "destroy": true
            });
		      }
		    });
	  	}



	  	/**
	  	 * Function for display data into edit section of product
	  	 * at select tag.
	  	 */
	  	
	  	// function optionProductList() {
	   //      $.ajax({
	   //        method: 'GET',
	   //        url: './controller/ProductsController.php?list=option',
	   //        dataType: 'html',
	   //        success: function(response){
	   //          $('#productname_select').html(response);
	   //        }
	   //      });
    //   	}

      	/**
      	 * Load function upon after window load
      	 */
      	
      	$(window).on('load', function() {
	        getProductList();
	        //optionProductList();
	       });

	    /**
	     * Dynamically change the data based on the selected option
	     * under edit section
	     */
	    
	    // $('#productname_select').on('change', function() {
	    //     var selectProd = $('#productname_select').val();
	    //     if (selectProd != "") {
	    //       $('#newprodname').css('display', 'block');
     //        $('#newprodprice').css('display', 'block');
     //        $('#newprodpricelabel').css('display', 'block');
	    //       $('#editProductBtn').css('display', "block");
	    //       $('#newprodnamelabel').css('display', "block");
	    //       $('#advancedSettings').css('display', "block");
     //        $('#categoryname_selected').css('display', 'block');
     //        $('#categoryname_selected_label').css('display', 'block');

	    //       $.ajax({
	    //         method: 'GET',
	    //         url: './controller/ProductsController.php?product=' + selectProd,
	    //         dataType: 'html',
	    //         success: function(response){
     //            $('#productcontainer').html(response);
	    //         }
	    //       });
	    //     }        
	    //  });

	    /**
	     * Adding of product
	     */
	
	  $('#addProductForm').on('submit', function(e) {
	    e.preventDefault();

	    var categoryname = $('#categoryname_select').val();
      var productname = $('#productname').val();
      var productprice = $('#productprice').val();
	    var form = $(this).serialize();

	    if (productname == "" || productprice == "" || categoryname == "") {
	      $('#errorproduct-edit').text('All fields are required.');
	    }
	    else {
	      Swal.fire({
	        title: 'Add '+ productname +'?',
	        type: 'question',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes! Add it!',
	      }).then((result) => {
	        if(result.value) {
	          var set = setInterval(function() {
	            $('#spinner').addClass('fa fa-spinner fa-spin');
	            $('#addProductBtn').attr('disabled', 'disabled');
	          },500);
	          setTimeout(function() {
	            $.ajax({
	              method: 'POST',
	              url: './controller/ProductsController.php',
	              data: {
                  categoryname: categoryname,
	                productname: productname,
                  productprice: productprice,
	                add: 1
	              },
	              dataType: 'json',
	              success: function(response) {
	                var err = response.length;

	                if (err > 0) {
	                  for (var i = 0; i < err; i++) {
	                    if (response[i] == 'Failed') {
	                      $('#error').text('All fields are required.');
	                      $('#addProductBtn').removeAttr('disabled');
	                      $('#spinner').removeClass('fa fa-spinner fa-spin');
	                      clearInterval(set);
	                    }

                      else if (response[i] == 'Invalid') {
                        $('#error').text('Invalid price amount.');
                        $('#addProductBtn').removeAttr('disabled');
                        $('#spinner').removeClass('fa fa-spinner fa-spin');
                        clearInterval(set);
                      }

	                    else if(response[i] == 'Exist') {
	                      $('#error').text('The product name you are trying to add is already exist. Please try a different name.');
	                      $('#addProductBtn').removeAttr('disabled');
	                      $('#spinner').removeClass('fa fa-spinner fa-spin');
	                      clearInterval(set);
	                    } 

	                    else if(response[i] == 'Success') {
	                      Swal.fire({
	                        title: 'Great!',
	                        type: 'success'
	                      });
	                      $('#error').text("");
	                      $('#addProductForm')[0].reset();
	                      $('#addProductBtn').removeAttr('disabled');
	                      $('#spinner').removeClass('fa fa-spinner fa-spin');
	                      clearInterval(set);
	                      getProductList();
	                      optionProductList();
	                    }
	                  }
	                }
	              }
	            });
	          }, 2000);
	        }
	      });
	    }
  	}); // End of adding product.


	/**
	 * Editing of existing category
	 */
	
	$('#editProductBtn').on('click', function(e) {
        e.preventDefault();

        var currentcatid = $('#categoryName').val();
        var newprodname = $('#productName').val();
        var newprodprice = $('#productPrice').val();
        var currentprodid = $('#hiddenProductId').val();
        var status = $('#hiddenProductStatus').val();

        if (newprodname == "" || newprodprice == "" || currentcatid == "") {
          $('#error-edit').text('All fields are required.');
        }
        else {
          Swal.fire({
            title: 'Do you want to edit this product?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Edit it!',
          }).then((result) => {
            if(result.value) {
              var set = setInterval(function() {
                $('#editproductspinner').addClass('fa fa-spinner fa-spin');
                $('#editProductBtn').attr('disabled', 'disabled');
              },500);
              setTimeout(function() {
                $.ajax({
                  method: 'POST',
                  url: './controller/ProductsController.php',
                  data: {
                    newprodname: newprodname,
                    newprodprice: newprodprice,
                    currentcatid: currentcatid,
                    currentprodid: currentprodid,
                    edit: 1
                  },
                  dataType: 'json',
                  success: function(response) {
                    var err = response.length;

                    if (err > 0) {
                      for (var i = 0; i < err; i++) {
                        if (response[i] == 'Failed') {
                          $('#error-edit').text('All fields are required.');
                          $('#editProductForm')[0].reset();
                          $('#advancedSettings').css('display', "none");
                          $('#editProductBtn').attr('disabled', 'disabled');
                          $('#editproductspinner').removeClass('fa fa-spinner fa-spin');
                          clearInterval(set);
                        }

                        else if(response[i] == 'Exist') {
                          $('#error-edit').text('The product name you are trying to add is already exist. Please try a different name.');
                          $('#editProductForm')[0].reset();
                          $('#advancedSettings').css('display', "none");
                          $('#editProductBtn').attr('disabled', 'disabled');
                          $('#editproductspinner').removeClass('fa fa-spinner fa-spin');
                          clearInterval(set);
                        } 

                        else if(response[i] == 'Success') {
                          Swal.fire({
                            title: 'Great!',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if(result.value) {
                              $('#error-edit').text("");
                              $('#editProductForm')[0].reset();
                              $('#advancedSettings').css('display', "none");
                              $('#editProductBtn').attr('disabled', 'disabled');
                              $('#editproductspinner').removeClass('fa fa-spinner fa-spin');
                              clearInterval(set);
                              getProductList();
                              window.location = './manage.products.php?productid=' + currentprodid + '&status=' + status;
                            }
                          });
                        }
                      }
                    }
                  }
                });
              }, 2000);
           }
         });
        }
      }); //End of editing of category.

	/**
	 * For archiving of category
	 */

	 $('#archiveProductBtn').on('click', function(e) {
        e.preventDefault();

        var currentprodid = $('#hiddenProductId').val();
        var newprodname = $('#productName').val();
        var status = $('#hiddenProductStatus').val();

          Swal.fire({
            title: 'Do you want to archive '+ newprodname +'? This will remove from the POS.',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Archive it!',
          }).then((result) => {
            if(result.value) {
              var set = setInterval(function() {
                $('#archiveproductspinner').addClass('fa fa-spinner fa-spin');
                $('#archiveProductBtn').attr('disabled', 'disabled');
              },500);
              setTimeout(function() {
                $.ajax({
                  method: 'POST',
                  url: './controller/ProductsController.php',
                  data: {
                    currentprodid: currentprodid,
                    archive: 1
                  },
                  dataType: 'json',
                  success: function(response) {
                    // var err = response.length;
                    // if (err > 0) {
                    //   for (var i = 0; i < err; i++) {
                        if(response == 'Success') {
                          Swal.fire({
                            title: 'Great!',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if(result.value) {
                              $('#errorproduct-edit').text("");
                              $('#editProductForm')[0].reset();
                              $('#advancedSettings').css('display', "none");
                              $('#editProductBtn').attr('disabled', 'disabled');
                              $('#editproductspinner').removeClass('fa fa-spinner fa-spin');
                              clearInterval(set);
                              getProductList();
                              //optionProductList();
                              window.location = './manage.products.php?productid=' + currentprodid + '&status=Archived';
                            }
                          });
                        }
                    //   }
                    // }
                  }
                });
              }, 2000);
            }
          });
      }); //End of archiving of category.

	/**
	 * End of document ready.
	 */
});	
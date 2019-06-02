/**
 * Javascript file for managing categories
 * This file should contain functions, events, validation
 * When interacting with categories.
 */

$(document).ready(function() {

	/**
	 * Wait for the dom to be ready
	 * 
	 */
  
  $('#edit-holder-btn').on('click', function() {

    $('#newcatname').removeAttr('disabled');
    $('#editCategoryBtn').removeAttr('disabled');
    $('#advancedSettings').css('display', 'block');
    $('#categoryName').removeAttr('disabled');
    $('#productName').removeAttr('disabled');
    $('#productPrice').removeAttr('disabled');
    $('#editProductBtn').removeAttr('disabled');
    
    
  });
  
	
      	/**
      	 * Load function upon after window load
      	 */
      	
      	$(window).on('load', function() {
	        getCategoryList();
	        optionCategoryList();
	     });
		/**
		 * Function for getting data from the database
		 * that will display in the table.
		 */
	
		function getCategoryList() {
		    $.ajax({
		      method: 'GET',
		      url: './controller/CategoriesController.php?list=category',
		      dataType: 'html',
		      success: function(response){
		        $('#table-category tbody').html(response);
            $('#table-category').DataTable({
              "destroy": true
            });
		      }
		    });
	  	}

	  	/**
	  	 * Function for display data into edit section of category
	  	 * at select tag.
	  	 */
	  	
	  	function optionCategoryList() {
	        $.ajax({
	          method: 'GET',
	          url: './controller/CategoriesController.php?list=option',
	          dataType: 'html',
	          success: function(response){
	            $('#categoryname_select').html(response);
	          }
	        });
      	}


	    /**
	     * Dynamically change the data based on the selected option
	     * under edit section
	     */
	    
	    $('#categoryname_select').on('change', function() {
	        var selectCat = $('#categoryname_select').val();
	        if (selectCat != "") {
	          $('#newcatname').css('display', 'block');
	          $('#editCategoryBtn').css('display', "block");
	          $('#newcatnamelabel').css('display', "block");
	          $('#advancedSettings').css('display', "block");

	          $.ajax({
	            method: 'GET',
	            url: './controller/CategoriesController.php?category=' + selectCat,
	            dataType: 'json',
	            success: function(response){
	              $('#newcatname').val(response);
	            }
	          });
	        }        
	     });

	    /**
	     * Adding of category
	     */
	
	  $('#addCategoryForm').on('submit', function(e) {
	    e.preventDefault();

	    var categoryname = $('#categoryname').val();
	    var form = $(this).serialize();

	    if (categoryname == "") {
	      $('#error').text('All fields are required.');
	    }
	    else {
	      Swal.fire({
	        title: 'Add '+ categoryname +' as category?',
	        type: 'question',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes! Add it!',
	      }).then((result) => {
	        if(result.value) {
	          var set = setInterval(function() {
	            $('#spinner').addClass('fa fa-spinner fa-spin');
	            $('#addCategoryBtn').attr('disabled', 'disabled');
	          },500);
	          setTimeout(function() {
	            $.ajax({
	              method: 'POST',
	              url: './controller/CategoriesController.php',
	              data: {
	                categoryname: categoryname,
	                add: 1
	              },
	              dataType: 'json',
	              success: function(response) {
	                var err = response.length;

	                if (err > 0) {
	                  for (var i = 0; i < err; i++) {
	                    if (response[i] == 'Failed') {
	                      $('#error').text('All fields are required.');
	                      $('#addCategoryBtn').removeAttr('disabled');
	                      $('#spinner').removeClass('fa fa-spinner fa-spin');
	                      clearInterval(set);
	                    }

	                    else if(response[i] == 'Exist') {
	                      $('#error').text('The category name you are trying to add is already exist. Please try a different name.');
	                      $('#addCategoryBtn').removeAttr('disabled');
	                      $('#spinner').removeClass('fa fa-spinner fa-spin');
	                      clearInterval(set);
	                    } 

	                    else if(response[i] == 'Success') {
	                      Swal.fire({
	                        title: 'Great!',
	                        type: 'success'
	                      });
	                      $('#error').text("");
	                      $('#addCategoryForm')[0].reset();
	                      $('#addCategoryBtn').removeAttr('disabled');
	                      $('#spinner').removeClass('fa fa-spinner fa-spin');
	                      clearInterval(set);
	                      getCategoryList();
	                      optionCategoryList();
	                    }
	                  }
	                }
	              }
	            });
	          }, 2000);
	        }
	      });
	    }
  	}); // End of adding category.


	/**
	 * Editing of existing category
	 */
	
	$('#editCategoryBtn').on('click', function(e) {
        e.preventDefault();

        var newcategoryname = $('#newcatname').val();
        var currentcatid = $('#hiddenCategoryId').val();
        var status = $('#hiddenCategoryStatus').val();

        if (newcategoryname == "") {
          $('#error-edit').text('All fields are required.');
        }
        else {
          Swal.fire({
            title: 'Do you want to change it to '+ newcategoryname +'?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Change it!',
          }).then((result) => {
            if(result.value) {
              var set = setInterval(function() {
                $('#editspinner').addClass('fa fa-spinner fa-spin');
                $('#editCategoryBtn').attr('disabled', 'disabled');
              },500);
              setTimeout(function() {
                $.ajax({
                  method: 'POST',
                  url: './controller/CategoriesController.php',
                  data: {
                    newcategoryname: newcategoryname,
                    currentcatid: currentcatid,
                    edit: 1
                  },
                  dataType: 'json',
                  success: function(response) {
                    var err = response.length;

                    if (err > 0) {
                      for (var i = 0; i < err; i++) {
                        if (response[i] == 'Failed') {
                          $('#error-edit').text('All fields are required.');
                          $('#editCategoryForm')[0].reset();
                          $('#advancedSettings').css('display', "none");
                          $('#editCategoryBtn').attr('disabled', 'disabled');
                          $('#editspinner').removeClass('fa fa-spinner fa-spin');
                          clearInterval(set);
                        }

                        else if(response[i] == 'Exist') {
                          $('#error-edit').text('The category name you are trying to add is already exist. Please try a different name.');
                          $('#editCategoryForm')[0].reset();
                          $('#advancedSettings').css('display', "none");
                          $('#editCategoryBtn').attr('disabled', 'disabled');
                          $('#editspinner').removeClass('fa fa-spinner fa-spin');
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
                              $('#editCategoryForm')[0].reset();
                              $('#advancedSettings').css('display', "none");
                              $('#editCategoryBtn').attr('disabled', 'disabled');
                              $('#editspinner').removeClass('fa fa-spinner fa-spin');
                              clearInterval(set);
                              window.location = './manage.categories.php?categoryid=' + currentcatid + '&status=' + status;
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

	 $('#archiveCategoryBtn').on('click', function(e) {
        e.preventDefault();

        var currentcatid = $('#hiddenCategoryId').val();
        var newcategoryname = $('#newcatname').val();
        var status = $('#hiddenCategoryStatus').val();

          Swal.fire({
            title: 'Do you want to archive '+ newcategoryname +'? This will remove all the product under this category in the POS.',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes! Archive it!',
          }).then((result) => {
            if(result.value) {
              var set = setInterval(function() {
                $('#archivespinner').addClass('fa fa-spinner fa-spin');
                $('#archiveCategoryBtn').attr('disabled', 'disabled');
              },500);
              setTimeout(function() {
                $.ajax({
                  method: 'POST',
                  url: './controller/CategoriesController.php',
                  data: {
                    currentcatid: currentcatid,
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
                              $('#error-edit').text("");
                              $('#editCategoryForm')[0].reset();
                              $('#advancedSettings').css('display', "none");
                              $('#editCategoryBtn').attr('disabled', 'disabled');
                              $('#editspinner').removeClass('fa fa-spinner fa-spin');
                              clearInterval(set);
                              window.location = './manage.categories.php?categoryid=' + currentcatid + '&status=Archived';
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
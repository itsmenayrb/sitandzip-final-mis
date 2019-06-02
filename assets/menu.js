$(document).ready(function() {

	/**
	 * Wait for the dom to be ready
	 * 
	 */
	

	  	/**
	  	 * Function for display data into edit section of category
	  	 * at select tag.
	  	 */
	  	
	  	function optionCategoryList() {
        $.ajax({
          method: 'GET',
          url: './controller/MenuController.php?list=menu',
          dataType: 'html',
          success: function(response){
            $('#categoryname_select').html(response);
          }
        });
    	}

      	/**
      	 * Load function upon after window load
      	 */
      	
      	$(window).load(function() {
	        optionCategoryList();
        });

	    /**
	     * Dynamically change the data based on the selected option
	     * under edit section
	     */
	    
	    $('#categoryname_select').on('change', function() {
	        var selectCat = $('#categoryname_select').val();

          $.ajax({
            method: 'POST',
            url: './controller/MenuController.php',
            data: {
              category: selectCat
            },
            dataType: 'html',
            success: function(response){
              $('#menu-container').html(response);
            }
          });
          
          //console.log(selectCat);        
	     });

	/**
	 * End of document ready.
	 */
});	
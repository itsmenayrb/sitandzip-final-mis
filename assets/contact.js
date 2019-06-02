$(document).ready(function() {

	$('#contactus-sendBtn').on('click', function(e) {

		e.preventDefault();

		var fullname = $('#contactus-name').val();
		var email = $('#contactus-email').val();
		var subject = $('#contactus-subject').val();
		var message = $('#contactus-message').val();

		if (fullname == '' || email == '' || subject == '' || message == '') {

			Swal.fire({
	            title: 'All fields are required.',
	            type: 'error',
	        });

		} else {

			if (validateName(fullname) == false) {

				Swal.fire({
	            	title: 'Invalid full name.',
		            type: 'error',
		        });

			} else {

				if (validateEmail(email) == false) {

					Swal.fire({
		            	title: 'Invalid email.',
			            type: 'error',
			        });

				} else {

					$.ajax({
				      	method: 'POST',
				      	url: './controller/MessageController.php',
				      	data: {
				      		fullname: fullname,
				      		email: email,
				      		subject: subject,
				      		message: message,
				      		send_message: 1
				      	},
				      	dataType: 'json',
				      	success: function(response){
				        	if(response.fullname) {
				        		Swal.fire({
					            	title: 'Invalid fullname.',
						            type: 'error',
						        });
				        	} else if (response.email) {
				        		Swal.fire({
					            	title: 'Invalid email.',
						            type: 'error',
						        });
				        	} else if (response.success) {
				        		Swal.fire({
			                        title: response.success,
			                        type: 'success',
			                        confirmButtonColor: '#3085d6',
		                            confirmButtonText: 'OK'
		                          }).then((result) => {
		                            if(result.value) {
			                  			$('.mu-contact-form')[0].reset();
			                  		}
			                  	});
				        	}
				      	}
				    });

				}

			}

		}

		return false;

	});

	function validateEmail(email) {
      var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
      return re.test(email);
    }

    function validateName(name) {
    	var re = /^[A-Za-z\s]*$/;
    	return re.test(name);
    }

});
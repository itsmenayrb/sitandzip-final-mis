$(document).ready(function() {

	$('#updateProfileBtn').on('click', function(e) {
		e.preventDefault();
		var employee_id = $('#hiddenEmployeeId').val();
		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var contact_number = $('#contact_number').val();

		if (firstname == '' || lastname == '' || contact_number == '') {
			Swal.fire({
	            title: 'All fields are required',
	            type: 'error'
	        });	
		} else {
			if (validateName(firstname) == false || validateName(lastname) == false){
				Swal.fire({
	            	title: 'Invalid name',
		            type: 'error'
		        });
			} else {
				if(validateContactNumber(contact_number) == false) {
					Swal.fire({
		            	title: 'Invalid contact number',
			            type: 'error'
			        });
				} else {
					$.ajax({
						method: 'POST',
						url: './controller/ProfileController.php',
						data: {
							employee_id: employee_id,
							firstname: firstname,
							lastname: lastname,
							contact_number: contact_number,
							update_profile: 1
						},
						dataType: 'json',
						success: function(response) {
							if(response.error) {
								Swal.fire({
					            	title: response.error,
						            type: 'error'
						        });		
							} else if (response.success) {
								Swal.fire({
						            title: response.success,
						            type: 'success',
						            confirmButtonColor: '#3085d6',
						            confirmButtonText: 'OK'
						        }).then((result) => {
						            if(result.value) {
						            	window.location = './profile.php';
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

	function validateName(name) {
    	var re = /^[A-Za-z\s]*$/;
    	return re.test(name);
    }

    function validateContactNumber(number) {
    	var re = /^[0-9]*$/;
    	return re.test(number);
    }

    function validateContactNumber(number) {
    	var re = /^[0-9]*$/;
    	return re.test(number);
    } 

});
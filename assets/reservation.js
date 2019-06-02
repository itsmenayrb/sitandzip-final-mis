$(document).ready(function() {

	$('#reservation_time').datetimepicker({
        format: 'LT',
        // disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 12 })], [moment({ h: 22 }), moment({ h: 24 })]]
        disabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 22, 23, 24],
		enabledHours: [11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22]
    });


	$('#reservationBtn').on('click', function(e) {

		e.preventDefault();

		var customer_id = $('#hiddenCustomerId').val();
		var fullname = $('#reservation_fullname').val();
		var email = $('#reservation_email').val();
		var contact_number = $('#reservation_contactnumber').val();
		var number_of_people = $('#reservation_numberofpeople').val();
		var reservation_date = $('#reservation_date').val();
		var reservation_time = $('#reservation_time').val();
		var reservation_message = $('#reservation_message').val();

		// console.log(fullname);
		// console.log(email);
		// console.log(contact_number);
		// console.log(number_of_people);
		// console.log(reservation_date);
		// console.log(reservation_time);
		// console.log(reservation_message);
		
		if (moment(reservation_date, 'MM/DD/YYYY', true).isValid()) {

			if (moment(reservation_time, 'LT', true).isValid()) {

				if (validateName(fullname) == true) {

					if (validateEmail(email) == true) {

						if (validateContactNumber(contact_number) == true) {

							if (fullname == '' || email == '' || contact_number == '' || number_of_people == '' || reservation_date == '' || reservation_time == '' || reservation_message == '') {

								Swal.fire({
						            title: 'All fields are required.',
						            type: 'error',
						        });

							} else {

								$.ajax({

									method: 'POST',
									url: './controller/ReservationController.php',
									data: {
										customer_id: customer_id,
										fullname: fullname,
										email: email,
										contact_number: contact_number,
										number_of_people: number_of_people,
										reservation_date: reservation_date,
										reservation_time: reservation_time,
										reservation_message: reservation_message,
										reserved: 1			
									},
									dataType: 'json',
									success: function(response) {

										if(response.error) {
											Swal.fire({
									            title: response.error,
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
						                  			$('.mu-reservation-form')[0].reset();
						                  		}
						                  	});
										}
										
									}

								});

							}

						} else {

							Swal.fire({
					            title: 'Invalid number.',
					            type: 'error',
					        });

						}

					} else {

						Swal.fire({
				            title: 'Invalid email.',
				            type: 'error',
				        });

					}

				} else {

					Swal.fire({
			            title: 'Invalid name.',
			            type: 'error',
			        });
				}

			} else {

				Swal.fire({
		            title: 'Invalid time',
		            type: 'error',
		        });

			}

		} else {

			Swal.fire({
	            title: 'Invalid date',
	            type: 'error',
	        });

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

    function validateContactNumber(number) {
    	var re = /^[0-9]*$/;
    	return re.test(number);
    }

});
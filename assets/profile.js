$(document).ready(function() {

	$('#profile-reservation-table').DataTable();



	$('#saveProfileBtn').on('click', function(e) {

		e.preventDefault();

		var customer_id = $('#hiddenCustomerId').val();
		var fullname = $('#fullname').val();
		var contact_number = $('#contact_number').val();

		// console.log(fullname);
		// console.log(contact_number);

		if (fullname == '' || contact_number == '') {

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

				if (validateContactNumber(contact_number) == false) {

					Swal.fire({
		            	title: 'Invalid contact number.',
			            type: 'error',
			        });

				} else {

					if (contact_number.length < 10) {

						Swal.fire({
			            	title: 'Contact number must be at least 10 characters for landline and 11 characters for mobile.',
				            type: 'error',
				        });

					} else {

						$.ajax({

							method: 'POST',
							url: './controller/ProfileController.php',
							data: {
								customer_id: customer_id,
								fullname: fullname,
								contact_number: contact_number,
								save_profile: 1			
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
				                  			window.location = './profile.php';
				                  		}
				                  	});
								}
								
							}
						});
					}

				}

			}

		}

		return false;

	});


	$('#saveNewPassword').on('click', function(e) {
		e.preventDefault();

		var customer_id = $('#hiddenCustomerId1').val();
		var current_password = $('#current_password').val();
		var new_password = $('#new_password').val();
		var retype_new_password = $('#retype_new_password').val();

		if (current_password == '' || new_password == '' || retype_new_password == '') {
			Swal.fire({
	            title: 'All fields are required.',
	            type: 'error',
	        });
		} else {
			if (new_password != retype_new_password) {
				Swal.fire({
		            title: 'Password did not match.',
		            type: 'error',
		        });
		        $('#new_password').val('');
		        $('#retype_new_password').val('');
			} else {
				if (new_password.length < 8){
					Swal.fire({
			            title: 'Password must be at least 8 characters.',
			            type: 'error',
			        });
				} else {
					$.ajax({
						method: 'POST',
						url: './controller/ProfileController.php',
						data: {
							customer_id: customer_id,
							current_password: current_password,
							new_password: new_password,
							retype_new_password: retype_new_password,
							password_reset: 1			
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
			                  			window.location = './logout.php?logout=true';
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

	$('.updateGetReservationId').on('click', function() {
		var reservation_id = $(this).data('id');
		// console.log(reservation_id);
		$('.modal #hiddenReservationId').val(reservation_id);

		$.ajax({
			method: 'post',
			url: './controller/ProfileController.php',
			data: {
				reservation_id: reservation_id,
				display_reservation_details: 1
			},
			dataType: 'html',
			success: function(response) {
				$('#reservationContainer').html(response);
			}


		});	

	});

	$('#saveReservationUpdate').on('click', function(e) {
		e.preventDefault();
		var reservation_id = $('#hiddenReservationId').val();
		var fullname = $('#reservation_fullname').val();
		var email = $('#reservation_email').val();
		var contact_number = $('#reservation_contactnumber').val();
		var number_of_people = $('#reservation_numberofpeople').val();
		var reservation_date = $('#reservation_date').val();
		var reservation_time = $('#reservation_time').val();
		var reservation_message = $('#reservation_message').val();

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
									url: './controller/ProfileController.php',
									data: {
										reservation_id: reservation_id,
										fullname: fullname,
										email: email,
										contact_number: contact_number,
										number_of_people: number_of_people,
										reservation_date: reservation_date,
										reservation_time: reservation_time,
										reservation_message: reservation_message,
										update_reservation: 1			
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
						                  			window.location = './profile.php';
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

	$('.cancelReservationBtn').on('click', function() {
		var reservation_id = $(this).data('id');
		var reservation_date = $(this).data('reservation');
		// console.log(reservation_id);
		// console.log(reservation_date);
		
		Swal.fire({
            title: 'Cancel reservation for '+ reservation_date +'?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
          }).then((result) => {
            if(result.value) {
				$.ajax({
					method: 'post',
					url: './controller/ProfileController.php',
					data: {
						reservation_id: reservation_id,
						cancel_reservation: 1
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
		                  			window.location = './profile.php';
		                  		}
		                  	});
						}
					}

				});
			}
		});	

	});

	$('#testimonialsBtn').on('click', function(e) {
		e.preventDefault();

		var testimonials = $('#customer_testimonials').val();
		var customer_id = $('#hiddenCustomerId2').val();

		if (testimonials == '') {
			Swal.fire({
	            title: 'Feedback cannot be empty.',
	            type: 'error',
	        });
		} else {
			$.ajax({
				method: 'post',
				url: './controller/ProfileController.php',
				data: {
					customer_id: customer_id,
					testimonials: testimonials,
					send_testimonials: 1
				},
				dataType: 'json',
				success: function(response) {
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

			});
		}

		return false;

	});

	var maxLength = 250;
	$('#customer_testimonials').on('keyup', function() {
		var length = $(this).val().length;
		length = maxLength-length;
		$('#textarea-counter').text(length);
	});

	function validateName(name) {
    	var re = /^[A-Za-z\s]*$/;
    	return re.test(name);
    }

    function validateContactNumber(number) {
    	var re = /^[0-9]*$/;
    	return re.test(number);
    }

    function validateEmail(email) {
      var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
      return re.test(email);
    }

});
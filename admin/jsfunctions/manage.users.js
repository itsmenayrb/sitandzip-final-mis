$(document).ready(function() {

	$(window).on('load', function() {

		displayUsers();
		// checkPosition();
	});

	$('#edituser-holder-btn').on('click', function() {

	    $('#advancedSettings').css('display', 'block');
	    $('#newfirstname').removeAttr('disabled');
	    $('#newlastname').removeAttr('disabled');
	    $('#newcontactnumber').removeAttr('disabled');
	    $('#editUserBtn').removeAttr('disabled');
	    $('#newposition').removeAttr('disabled');
	    $('#newotherPosition').removeAttr('disabled');
	    
	    
	  });

	function displayUsers() {

		$.ajax({
	      	method: 'GET',
	      	url: './controller/UsersController.php?list=users',
	      	dataType: 'html',
	      	success: function(response){
	        	$('#table-users tbody').html(response);
        		$('#table-users').DataTable({
          			"destroy": true
        		});
	      	}
	    });

	}

	$('#position').on('change', function() {

		var position = $(this).val();

		if (position == 'Other') {
			$('#otherPosition').css('display', 'block');
			$('#other-position-label').css('display', 'block');

		} else {
			$('#otherPosition').css('display', 'none');
			$('#other-position-label').css('display', 'none');
		}


	});


	$('#registerBtn').on('click', function(e) {

		e.preventDefault();

		var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var position = $('#position').val();

        if (position == 'Other') {
        	position = $('#otherPosition').val();
        }

        // console.log(username);
        // console.log(email);
        // console.log(password);
        // console.log(position);

        if (username == '' || password == '' || email == '' || position == '') {
          $('#error').text('All fields are required.');
          return false;
        } else if (validateEmail(email) == false) {
          $('#error').text('Invalid email address.');
          return false;
        } else if (password.length < 8) {
          $('#error').text('Password must be at least 8 alphanumeric characters.');
          return false;
        } else if (username.length < 5) {
        	$('#error').text('Username must be at least 5 alphanumeric characters.');
          	return false;
        } else {
          $.ajax({
            method: 'POST',
            url: 'controller/UsersController.php',
            data: {
                username: username,
                email: email,
                password: password,
                position: position,
                register: 1
            },
            dataType: 'json',
            success: function(response) {
              
              $(response.error).each(function() {
              	$('#error').text(response.error);
              	var mybr = document.createElement('br');
				$('#error').appendChild(mybr);
              });

              if (response.success) {
              	Swal.fire({
                    title: response.success,
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if(result.value) {
                      window.location = './manage.users.php';
                    }
                });
              }
            }
          });
        }

	});


	$('#newposition').on('change', function() {

		var position = $(this).val();

		//console.log(position);
		if (position == 'Other') {
			$('#newposition-div').css('display', 'block');

		} else {
			$('#newposition-div').css('display', 'none');
		}

	});

	$('#editUserBtn').on('click', function(e) {

		e.preventDefault();

        var contact_number = $('#newcontactnumber').val();
        var firstname = $('#newfirstname').val();
        var lastname = $('#newlastname').val();
        var employee_id = $('#hiddenUserId').val();

        var position = $('#newposition').val();
        if (position == 'Other') {
        	position = $('#newotherPosition').val();
        }

        if (contact_number == '' || position == '' || firstname == '' || lastname == '') {
          $('#error').text('All fields are required.');
          return false;
        } else if (validateName(firstname) == false) {
        	$('#error').text('Invalid first name.');
          	return false;
        } else if (validateName(lastname) == false) {
        	$('#error').text('Invalid last name.');
          	return false;
        } else if (validateContactNumber(contact_number) == false) {
        	$('#error').text('Invalid contact number.');
          	return false;
        } else {
          $.ajax({
            method: 'POST',
            url: 'controller/UsersController.php',
            data: {
            	employee_id: employee_id,
                position: position,
                contact_number: contact_number,
                firstname: firstname,
                lastname: lastname,
                update_user: 1
            },
            dataType: 'json',
            success: function(response) {
              
              $(response.error).each(function() {
              	$('#error').text(response.error);
              	var mybr = document.createElement('br');
				$('#error').appendChild(mybr);
              });

              if (response.success) {
              	Swal.fire({
                    title: response.success,
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if(result.value) {
                      window.location = './manage.users.php';
                    }
                });
              }
            }
          });
        }

	});

	$('#archiveUserBtn').on('click', function(e) {
        e.preventDefault();

        var employee_id = $('#hiddenUserId').val();
        var username = $('#newusername').val();

          Swal.fire({
            title: 'Do you want to deactivate '+ username +"'s account? By doing this, the account can no longer access the system. Do you wish to continue?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Deactivate!',
          }).then((result) => {
            if(result.value) {
                $.ajax({
                  method: 'POST',
                  url: './controller/UsersController.php',
                  data: {
                    employee_id: employee_id,
                    deactivate: 1
                  },
                  dataType: 'json',
                  success: function(response) {
                      Swal.fire({
                        title: response,
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                      }).then((result) => {
                        if(result.value) {
                          window.location = './manage.users.php?employeeid=' + employee_id + '&status=Deactivated';
                        }
                      });
                        
                  }
                });
            }
          });
      });

	$('#resetPasswordBtn').on('click', function(e) {
		e.preventDefault();

		var employee_id = $('#hiddenUserId').val();
		var password = $('#newpassword').val();
		var cpassword = $('#retypenewpassword').val();

		//console.log(employee_id);
		if (password != cpassword) {

			Swal.fire({
                title: 'Password did not match!',
                type: 'error'
            });

		} else if (password.length < 8) {

			Swal.fire({
                title: 'Password must be at least 8 characters.',
                type: 'error'
            });

		} else {

			$.ajax({
              method: 'POST',
              url: './controller/UsersController.php',
              data: {
                employee_id: employee_id,
                password: password,
                cpassword: cpassword,
                reset_password: 1
              },
              dataType: 'json',
              success: function(response) {
                  Swal.fire({
                    title: response,
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                  }).then((result) => {
                    if(result.value) {
                      window.location = './manage.users.php?employeeid=' + employee_id + '&status=Active';
                    }
                  });
                    
              }
            });

		}

		return false;

	})


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
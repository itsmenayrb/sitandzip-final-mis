<?php

	require_once '../classes/Config.php';
	require_once '../classes/CustomerProfile.php';

	$config = new Config();

	if (isset($_POST['save_profile'])) {

		$customer_id = $config->checkInput($_POST['customer_id']);
		$fullname = $config->checkInput($_POST['fullname']);
		$contact_number = $config->checkInput($_POST['contact_number']);

		if ($fullname == '' || $contact_number == '') {

			echo json_encode(array('error' => 'All fields are required.'));

		} else {

			if (!preg_match("/^[a-zA-Z ]*$/" , $fullname)) {

				echo json_encode(array('error' => 'Invalid full name.'));

			} else {

				if(!preg_match("/^[0-9]*$/", $contact_number)) {

					echo json_encode(array('error' => 'Invalid contact number.'));

				} else {

					$save_profile = new CustomerProfile();
					if ($save_profile->saveProfile($customer_id, $fullname, $contact_number)) {
						echo json_encode(array('success' => 'Profile updated successfully!'));
					}

				}

			}

		}

	}

	if (isset($_POST['password_reset'])) {
		$customer_id = $config->checkInput($_POST['customer_id']);
		$current_password = $config->checkInput($_POST['current_password']);
		$new_password = $config->checkInput($_POST['new_password']);
		$retype_new_password = $config->checkInput($_POST['retype_new_password']);

		if (strlen($new_password) < 8) {
			echo json_encode(array('error' => 'Password must be at least 8 characters.'));
		} else {
			if ($new_password != $retype_new_password) {
				echo json_encode(array('error' => 'Password did not match.'));	
			} else {
				$password_reset = new CustomerProfile();
				if ($password_reset->passwordReset($customer_id, $current_password, $new_password)) {
					echo json_encode(array('success' => 'Reset password successfully! Please log in again.'));
				}
			}
		}
	}

	if (isset($_POST['display_reservation_details'])) {
		$reservation_id = $config->checkInput($_POST['reservation_id']);
		$show_reservation_to_update = new CustomerProfile();
		$show_reservation_to_update->showReservationToUpdate($reservation_id);
	}

	if (isset($_POST['update_reservation'])) {
		$reservation_id = $config->checkInput($_POST['reservation_id']);
		$fullname = $config->checkInput($_POST['fullname']);
		$email = $config->checkInput($_POST['email']);
		$contact_number = $config->checkInput($_POST['contact_number']);
		$number_of_people = $config->checkInput($_POST['number_of_people']);
		$reservation_date = $config->checkInput($_POST['reservation_date']);
		$reservation_time = $config->checkInput($_POST['reservation_time']);
		$reservation_message = $config->checkInput($_POST['reservation_message']);

		$checkdate = explode('/', $reservation_date);

		if (count($checkdate) == 3) {
			if (checkdate($checkdate[0], $checkdate[1], $checkdate[2])) {
				// if (preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $reservation_time)) {
					if(preg_match("/^[0-9]*$/", $contact_number)) {
						if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
							if (preg_match("/^[a-zA-Z ]*$/" , $fullname)) {
								if ($fullname == '' || $email == '' || $contact_number == '' || $number_of_people == '' || $reservation_date == '' || $reservation_time == '' || $reservation_message == '') {
									echo json_encode(array('error' => 'All fields are required.'));
								} else {
									$update_reservation = new CustomerProfile();
									if ($update_reservation->updateReservation($reservation_id, $fullname, $email, $contact_number, $number_of_people, $reservation_date, $reservation_time, $reservation_message)) {
										echo json_encode(array('success' => 'Your reservation has been updated.'));
									}
								}
					  		} else {
					  			echo json_encode(array('error' => 'Invalid email.'));
					  		}
						} else {
							echo json_encode(array('error' => 'Invalid email.'));
						}
					} else {
						echo json_encode(array('error' => 'Invalid contact number.'));
					}
				// } else {
				// 	echo json_encode(array('error' => 'Invalid time.'));
				// }			
			} else {
				echo json_encode(array('error' => 'Invalid date.'));
			}
		} else {
			echo json_encode(array('error' => 'Invalid date.'));
		}
	}

	if (isset($_POST['cancel_reservation'])) {
		$reservation_id = $config->checkInput($_POST['reservation_id']);

		$cancel_reservation = new CustomerProfile();
		if ($cancel_reservation->cancelReservation($reservation_id)) {
			echo json_encode(array('success' => 'Reservation cancelled!'));
		}
	}

	if(isset($_POST['send_testimonials'])) {
		$customer_id = $config->checkInput($_POST['customer_id']);
		$testimonials = $config->checkInput($_POST['testimonials']);

		if ($testimonials == "") {
			echo json_encode(array('error' => 'Feedback cannot be empty.'));
		} else {
			$send_testimonials = new CustomerProfile();
			if($send_testimonials->sendTestimonials($customer_id, $testimonials)){
				echo json_encode(array('success' => 'Message sent! Thank you for your feedback.'));
			}
		}
	}
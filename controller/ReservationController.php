<?php

	require_once '../classes/Config.php';
	require_once '../classes/Reservation.php';

	$config = new Config();

	if (isset($_POST['reserved'])) {

		$customer_id = $config->checkInput($_POST['customer_id']);
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

									$send_reservation = new Reservation();
									if ($send_reservation->saveReservation($customer_id, $fullname, $email, $contact_number, $number_of_people, $reservation_date, $reservation_time, $reservation_message)) {

										echo json_encode(array('success' => 'Reservation request has been sent.'));

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
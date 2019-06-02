<?php

	require_once '../../classes/Config.php';
	require_once '../classes/EmployeeProfile.php';

	$config = new Config();

	if (isset($_POST['update_profile'])) {
		$employee_id = $config->checkInput($_POST['employee_id']);
		$firstname = $config->checkInput($_POST['firstname']);
		$lastname = $config->checkInput($_POST['lastname']);
		$contact_number = $config->checkInput($_POST['contact_number']);

		if ($firstname == "" || $lastname == "" || $contact_number == "") {
			echo json_encode(array('error' => 'All fields are required.'));
		} else {
			if (!preg_match("/^[a-zA-Z ]*$/" , $firstname) || !preg_match("/^[a-zA-Z ]*$/" , $lastname)) {
				echo json_encode(array('error' => 'Invalid name.'));
			} else {
				if(!preg_match("/^[0-9]*$/", $contact_number)) {
					echo json_encode(array('error' => 'Invalid contact number.'));
				} else {
					$save_profile = new EmployeeProfile();
					if ($save_profile->saveProfile($employee_id, $firstname, $lastname, $contact_number)) {
						echo json_encode(array('success' => 'Profile updated successfully!'));
					}
				}
			}
		}
	}
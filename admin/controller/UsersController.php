<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageUsers.php';

	$config = new Config();

	if (isset($_GET['list']))
	{

		$list = $config->checkInput($_GET['list']);

		switch ($list) {
			case 'users':
				$displayUsersList = new ManageUsers();
				$displayUsersList->displayUsersList();
				break;
			
			default:
				exit('Error');
				break;
		}

	}

	$error = [];

	if (isset($_POST['register'])) {

		$username = $config->checkInput($_POST['username']);
		$position = $config->checkInput($_POST['position']);
		$email = $config->checkInput($_POST['email']);
		$password = $config->checkInput($_POST['password']);
		// $other = $config->checkInput($_POST['other_position']);

		

		if (!preg_match("/^[a-zA-Z0-9]{5,}$/" , $username)){

		    $error[] = "Username must not contain spaces or special characters and at least 5 characters.";

		}

		if ($position == "") {

		    $error[] = "Please select a position.";

		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		          
		    $error[] = "Invalid email address.";

		}

		if (count($error) == 0) {

			$register = new ManageUsers();
			if ($register->registerEmployee($username, $email, $position, $password)) {
				echo json_encode(array('success' => 'User account created successfully!'));
			}

		} else {

			echo json_encode(array("error" => $error));
			
		}


	}

	if (isset($_POST['update_user'])) {

		$position = $config->checkInput($_POST['position']);
		$contact_number = $config->checkInput($_POST['contact_number']);
		$firstname = $config->checkInput($_POST['firstname']);
		$lastname = $config->checkInput($_POST['lastname']);
		$employee_id = $config->checkInput($_POST['employee_id']);


		if (!preg_match("/^[a-zA-Z ]*$/" , $firstname) || !preg_match("/^[a-zA-Z ]*$/" , $lastname)) {
    		$error[] = "Your name must not contain numbers or special characters.";
  		}

  		if(!preg_match("/^[0-9]*$/", $contact_number)){
			$error[] = "You have entered invalid contact number. Please check your inputs!";
		}

		if ($position == "") {

		    $error[] = "Please select a position.";

		}

		if (count($error) == 0) {

			$update_user = new ManageUsers();
			if ($update_user->updateUser($firstname, $lastname, $position, $contact_number, $employee_id)) {
				echo json_encode(array('success' => 'User updated successfully!'));
			}

		} else {

			echo json_encode(array("error" => $error));
			
		}		

	}


	if(isset($_POST['deactivate'])) {

		$success = [];

		$employee_id = $config->checkInput($_POST['employee_id']);
		$deactivate = new ManageUsers();
		if ($deactivate->deactivateUser($employee_id)) {
			$success = 'Account successfully deactivated';
		}

		echo json_encode($success);

	}

	if(isset($_POST['reset_password'])) {

		$success = [];
		$error = [];

		$employee_id = $config->checkInput($_POST['employee_id']);
		$password = $config->checkInput($_POST['password']);
		$cpassword = $config->checkInput($_POST['cpassword']);

		if ($password != $cpassword) {

			$error[] = 'Password did not match.';

		} else if (strlen($password) < 8) {

			$error[] = 'Password must be at least 8 characters.';

		} 


		if (count($error) != 0) {

			echo json_encode($error);

		} else {

			$reset_password = new ManageUsers();
			if ($reset_password->resetPassword($employee_id, $password)) {
				$success = 'Reset password successfully';
			}

			echo json_encode($success);

		}

	}
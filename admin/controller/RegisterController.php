<?php

	require_once '../../classes/Config.php';
	require_once '../classes/RegisterEmployee.php';
	$config = new Config();

	$error = [];
	
	if (isset($_POST['register'])) {

		$username = $config->checkInput($_POST['username']);
		$email = $config->checkInput($_POST['email']);
		$password = $config->checkInput($_POST['password']);
		$position = $config->checkInput($_POST['position']);


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

			$register = new RegisterEmployee($username, $email, $password, $position);
			$register->validateEmployeeCredentials();

		} else {

			echo json_encode($error);
			
		}


	}


?>
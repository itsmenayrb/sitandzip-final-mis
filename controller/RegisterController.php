<?php

	require_once '../classes/Config.php';
	require_once '../classes/Register.php';
	$config = new Config();

	$error = [];
	
	if (isset($_POST['register'])) {

		$username = $config->checkInput($_POST['username']);
		$email = $config->checkInput($_POST['email']);
		$password = $config->checkInput($_POST['password']);
		$cpassword = $config->checkInput($_POST['cpassword']);


		if (!preg_match("/^[a-zA-Z0-9]{5,}$/" , $username)){

		    $error[] = "Username must not contain spaces or special characters and at least 5 characters.";

		}

		if ($password != $cpassword) {

		    $error[] = "Password did not match.";

		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		          
		    $error[] = "Invalid email address.";

		}

		if (count($error) == 0) {

			$register = new Register($username, $email, $password);
			$register->validateCredentials();

		} else {

			echo json_encode($error);
			
		}


	}


?>
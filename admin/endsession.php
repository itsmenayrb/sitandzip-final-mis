<?php
	
	session_start();
	require_once '../classes/Config.php';

	$user_logout = new Config();

	$logout = $user_logout->checkInput($_GET['logout']);

	switch ($logout) {
		case 'true':
			unset($_SESSION['employee_username']);
		    unset($_SESSION['employee_email']);
		    unset($_SESSION['employee_position']);
			session_destroy();
			$user_logout->redirect('./index.php');
			break;
		
		default:
			# code...
			break;
	}

?>
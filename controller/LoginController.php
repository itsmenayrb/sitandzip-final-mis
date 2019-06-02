<?php

	session_start();
	require_once '../classes/Config.php';
	require_once '../classes/Login.php';

	$config = new Config();
	
	if (isset($_POST['login'])) {

		$username = $config->checkInput($_POST['username']);
		$email = $config->checkInput($_POST['email']);
		$password = $config->checkInput($_POST['password']);

		$login = new Login($username, $email, $password);
		$login->login();

	}

?>
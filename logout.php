<?php
	
	require_once './classes/Session.php';
	require_once './classes/Config.php';

	$user_logout = new Config();
	
	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('./index.php');
	}

	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('./index.php');
	}


?>
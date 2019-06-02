<?php

	require_once '../classes/Config.php';
	require_once '../classes/Message.php';

	$config = new Config();

	if (isset($_POST['send_message'])) {

		$fullname = $config->checkInput($_POST['fullname']);
		$email = $config->checkInput($_POST['email']);
		$subject = $config->checkInput($_POST['subject']);
		$message = $config->checkInput($_POST['message']);

		if (!preg_match("/^[a-zA-Z ]*$/", $fullname)){

		    echo json_encode(array('fullname' => 'Invalid fullname'));

		} else {

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		          
				echo json_encode(array('email' => 'Invalid email'));			    

			} else {

				$send_message = new Message();
				if ($send_message->sendMessage($fullname, $email, $subject, $message)) {
					echo json_encode(array('success' => 'Message has been sent.'));
				}

			}

		}

	}
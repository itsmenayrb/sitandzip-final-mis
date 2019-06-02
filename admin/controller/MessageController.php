<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageMessages.php';

	$config = new Config();

	if (isset($_POST['show_message'])) {

		$message_id = $config->checkInput($_POST['message_id']);
		$show_message = new ManageMessages();
		$show_message->showMessage($message_id);

	}

	if (isset($_POST['archive_message'])) {
		$message_id = $config->checkInput($_POST['message_id']);
		$archive_message = new ManageMessages();
		if ($archive_message->archiveMessage($message_id)){
			echo json_encode(array('success'=>'Messages has been deleted!'));
		}
	}
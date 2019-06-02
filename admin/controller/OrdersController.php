<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageOrders.php';

	$config = new Config();


	if (isset($_POST['processOrder']))
	{

		$transaction_id = $config->checkInput($_POST['transaction_id']);
		$transacted_by = $config->checkInput($_POST['transact_by']);

		$processThisOrder = new ManageOrders();
		if ($processThisOrder->processThisOrder($transaction_id, $transacted_by)) {
			echo 'Completed!';
		}

	}
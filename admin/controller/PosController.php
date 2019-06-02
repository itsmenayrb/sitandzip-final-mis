<?php

	require_once '../../classes/Config.php';
	require_once '../classes/Pos.php';

	$config = new Config();

	if (isset($_GET['display']))
	{
		$products = $config->checkInput($_GET['display']);

		switch ($products) {
			case 'products':
				$display = new POS();
				$display->displayActiveProducts();
				break;
			
			default:
				exit("Nothing to show");
				break;
		}
	}


	if (isset($_POST['order']))
	{
		$id = $config->checkInput($_POST['id']);
		$price = $config->checkInput($_POST['price']);
		$product_name = $config->checkInput($_POST['productName']);
		$transaction_id = $config->checkInput($_POST['transaction_id']);

		$create = new POS();
		$create->addThisOrder($id, $price, $product_name, $transaction_id);

	}

	if (isset($_POST['save']))
	{

		//$arrays = $_POST['arrays'];
		$transact_by = $config->checkInput($_POST['transact_by']);
		$transaction_id = $config->checkInput($_POST['transaction_id']);
		$product_name = $_POST['product_name'];
		$quantity = $_POST['quantity'];
		//$price = $_POST['price'];
		$totalAmount = $config->checkInput($_POST['totalAmount']);
		$payment = $config->checkInput($_POST['payment']);
		$change = $config->checkInput($_POST['change']);

		$saveSummary = new POS();

		for ($i = 0; $i < count($quantity); $i++){
			if($saveSummary->saveOrder($transaction_id, $product_name[$i], $quantity[$i])){
				
			}
		}

		$saveSummary->insertToSales($transaction_id, $totalAmount, $payment, $change, $transact_by);
		$newTransactionId = $config->generateTransactId();
		echo json_encode($newTransactionId);
		// for($i = 0; $i < count($quantity); $i++){
		// 	echo $quantity[$i];
		// }

	}


?>
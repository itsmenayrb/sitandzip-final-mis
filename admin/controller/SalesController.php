<?php

	require_once '../../classes/Config.php';
	require_once '../classes/Sales.php';

	$config = new Config();

	if(isset($_POST['getSales']))
	{

		$startDate = date('Y-m-d H:i:s', strtotime($_POST['from']));
		$endDate = date('Y-m-d H:i:s', strtotime($_POST['to']));

		$displaySales = new SALES();
		$displaySales->displaySales($startDate, $endDate);

	}

	if(isset($_POST['getDetailedSales']))
	{

		$startDate = date('Y-m-d H:i:s', strtotime($_POST['from']));
		$endDate = date('Y-m-d H:i:s', strtotime($_POST['to']));

		// echo $startDate;
		// echo $endDate;

		$displayDetailedSales = new SALES();
		$displayDetailedSales->displayDetailedSales($startDate, $endDate);

	}	


	if(isset($_POST['getSalesGraph']))
	{

		$startDate = date('Y-m-d H:i:s', strtotime($_POST['from']));
		$endDate = date('Y-m-d H:i:s', strtotime($_POST['to']));

		$displaySalesGraph = new SALES();
		$displaySalesGraph->displaySalesGraph($startDate, $endDate);

	}

	if (isset($_GET['sales'])) {

		$today = $config->checkInput($_GET['sales']);

		switch ($today) {
			case 'today':
				$displayTodaySales = new SALES();
				$displayTodaySales->displayTodaySales();
				break;
			
			default:
				exit("Error on the server");
				break;
		}

	}

	if (isset($_POST['getProfit'])) {

		$startDate = date('Y-m-d H:i:s', strtotime($_POST['from']));
		$endDate = date('Y-m-d H:i:s', strtotime($_POST['to']));

		$displayNetProfit = new SALES();
		$displayNetProfit->displayNetProfit($startDate, $endDate);

	}
?>
<?php

	require_once '../classes/Config.php';
	require_once '../classes/Menu.php';

	$config = new Config();

	if (isset($_GET['list'])) {

		$list = $config->checkInput($_GET['list']);	
		$getlist = new Menu();

		switch ($list) {
			case 'menu':
				$getlist->getMenu();
				break;
			
			default:
				exit('No records to show.');
				break;
		}

	}

	if (isset($_POST['category'])) {

		$category = $config->checkInput($_POST['category']);
		$getProductFromCategory = new Menu();
		$getProductFromCategory->getProductMenu($category);

		// echo 'Hello';

	}
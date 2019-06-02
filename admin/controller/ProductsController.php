<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageProducts.php';

	$config = new Config();

	$error = [];

	if (isset($_POST['add'])) {

		$categoryname = $config->checkInput($_POST['categoryname']);
		$productname = $config->checkInput($_POST['productname']);
		$productprice = $config->checkInput($_POST['productprice']);

		if($productname == "" || $productprice == "" || $categoryname == "") {
			$error[] = 'Failed';
		}

		if(!preg_match('/^[1-9][0-9]{0,10}$/', $productprice)) {
			$error[] = 'Invalid';
		}

		if(count($error) == 0) {

			$manage = new ManageProducts();
			$manage->validateProducts($categoryname, $productname, $productprice);

		}

		else {
			echo json_encode($error);
		}
	}

	if (isset($_POST['edit'])) {

		$prodprice = $config->checkInput($_POST['newprodprice']);
		$prodname = $config->checkInput($_POST['newprodname']);
		$category_id = $config->checkInput($_POST['currentcatid']);
		$product_id = $config->checkInput($_POST['currentprodid']);

		if($category_id == "" || $product_id == "" || $prodname == "" || $prodprice == "") {
			$error[] = 'Failed';
		}

		if(count($error) == 0) {

			$manage = new ManageProducts();
			$manage->validateProducts($category_id, $prodname, $prodprice, $product_id);

		}

		else {
			echo json_encode($error);
		}
	}

	if (isset($_GET['list'])) {

		$list = $config->checkInput($_GET['list']);	
		$getlist = new ManageProducts();

		switch ($list) {
			case 'product':
				$getlist->getProductList();
				break;

			case 'option':
				$getlist->getOptionList();
				break;
			
			default:
				exit('No records to show.');
				break;
		}

	}

	if (isset($_GET['product'])) {

		$list = $config->checkInput($_GET['product']);	
		$currentValue = new ManageProducts();
		$currentValue->oldProductValue($list);

	}

	if (isset($_POST['archive'])) {

		$success = [];

		$product_id = $config->checkInput($_POST['currentprodid']);
		$archive = new ManageProducts();
		if ($archive->archiveProduct($product_id)) {
			$success = 'Success';
		}

		echo json_encode($success);
	}	


?>
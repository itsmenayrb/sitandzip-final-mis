<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageArchives.php';

	$config = new Config();

	if(isset($_POST['restoreCategory']))
	{

		$category_id = $config->checkInput($_POST['category_id']);
		$restoreCategory = new ManageArchives();
		if($restoreCategory->restoreCategory($category_id)){
			echo 'Success!';
		}


	}

	if(isset($_POST['restoreProduct']))
	{

		$product_id = $config->checkInput($_POST['product_id']);
		$restoreProduct = new ManageArchives();
		if($restoreProduct->restoreProduct($product_id)){
			echo 'Success!';
		}


	}

	if(isset($_POST['restoreItem']))
	{

		$item_id = $config->checkInput($_POST['item_id']);
		$restoreItem = new ManageArchives();
		if($restoreItem->restoreItem($item_id)){
			echo 'Success!';
		}


	}

	if(isset($_POST['restoreAccount']))
	{

		$employee_id = $config->checkInput($_POST['employee_id']);
		$restoreAccount = new ManageArchives();
		if($restoreAccount->restoreAccount($employee_id)){
			echo 'Success!';
		}


	}


?>
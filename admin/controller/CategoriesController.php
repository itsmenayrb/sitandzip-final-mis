<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageCategories.php';

	$config = new Config();

	$error = [];

	if (isset($_POST['add'])) {

		$categoryname = $config->checkInput($_POST['categoryname']);

		if($categoryname == "") {
			$error[] = 'Failed';
		}

		if(count($error) == 0) {

			$manage = new ManageCategories();
			$manage->validateCategory($categoryname);

		}

		else {
			echo json_encode($error);
		}
	}

	if (isset($_POST['edit'])) {

		$categoryname = $config->checkInput($_POST['newcategoryname']);
		$category_id = $config->checkInput($_POST['currentcatid']);

		if($categoryname == "") {
			$error[] = 'Failed';
		}

		if(count($error) == 0) {

			$manage = new ManageCategories();
			$manage->validateCategory($categoryname, $category_id);

		}

		else {
			echo json_encode($error);
		}
	}

	if (isset($_GET['list'])) {

		$list = $config->checkInput($_GET['list']);	
		$getlist = new ManageCategories();

		switch ($list) {
			case 'category':
				$getlist->getCategoryList();
				break;

			case 'option':
				$getlist->getOptionList();
				break;
			
			default:
				exit('No records to show.');
				break;
		}

	}

	if (isset($_GET['category'])) {

		$list = $config->checkInput($_GET['category']);	
		$currentValue = new ManageCategories();
		$currentValue->oldCategoryValue($list);

	}

	if (isset($_POST['archive'])) {

		$success = [];

		$category_id = $config->checkInput($_POST['currentcatid']);
		$archive = new ManageCategories();
		if ($archive->archiveCategory($category_id)) {
			$success = 'Success';
		}

		echo json_encode($success);
	}	


?>
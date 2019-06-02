<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageInventory.php';

	$config = new Config();

	if(isset($_POST['getExpenses']))
	{

		$startDate = date('Y-m-d H:i:s', strtotime($_POST['from']));
		$endDate = date('Y-m-d H:i:s', strtotime($_POST['to']));

		$displayExpenses = new ManageInventory();
		$displayExpenses->displayExpenses($startDate, $endDate);

	}

	if (isset($_POST['save_item'])) {

		$employee_id = $config->checkInput($_POST['employee_id']);
		$itemname = $config->checkInput($_POST['item']);
		$description = $config->checkInput($_POST['description']);
		$qty = $config->checkInput($_POST['qty']);
		$price = $config->checkInput($_POST['price']);

		$date_purchased = $_POST['date_purchased'];

		$checkdate = explode('/', $date_purchased);

		if (count($checkdate) == 3) {

			if (checkdate($checkdate[0], $checkdate[1], $checkdate[2])) {

				if ($itemname == '' || $description == '' || $qty == '' || $price == '' || $employee_id == '' || $date_purchased == '') {

					echo json_encode(array('error' => 'All fields are required.'));

				} else {

					$save_item = new ManageInventory();
					if($save_item->saveItem($employee_id, $itemname, $description, $qty, $date_purchased)){
						if($save_item->saveExpenses($employee_id, $price, $qty, $date_purchased)) {
							echo json_encode(array('success' => 'Item added successfully!'));
						}
					}

				}

			} else {

				echo json_encode(array('error' => 'Invalid Date.'));

			}

		} else {

			echo json_encode(array('error' => 'Invalid Date.'));

		}


	}

	if (isset($_POST['show_item'])) {

		$item_id = $config->checkInput($_POST['item_id']);
		$show_item_to_update = new ManageInventory();
		$show_item_to_update->showItemToUpdate($item_id);

	}

	if (isset($_POST['update_item'])) {

		$item_id = $config->checkInput($_POST['item_id']);
		$employee_id = $config->checkInput($_POST['employee_id']);
		$itemname = $config->checkInput($_POST['item']);
		$description = $config->checkInput($_POST['description']);
		$qty = $config->checkInput($_POST['qty']);
		$price = $config->checkInput($_POST['price']);

		$date_purchased = $config->checkInput($_POST['date_purchased']);

		$checkdate = explode('/', $date_purchased);

		if (count($checkdate) == 3) {

			if (checkdate($checkdate[0], $checkdate[1], $checkdate[2])) {

				if ($itemname == '' || $description == '' || $qty == '' || $price == '' || $employee_id == '' || $date_purchased == '') {

					echo json_encode(array('error' => 'All fields are required.'));

				} else {

					$update_item = new ManageInventory();
					if($update_item->updateItem($item_id, $employee_id, $itemname, $description, $qty)){
						if($update_item->updateExpenses($item_id, $employee_id, $qty, $price, $date_purchased)){
							echo json_encode(array('success' => 'Item updated successfully!'));
						}
					}

				}

			} else {

				echo json_encode(array('error' => 'Invalid Date.'));

			}

		} else {

			echo json_encode(array('error' => 'Invalid Date.'));

		}


	}


	if (isset($_POST['archive_item'])) {

		$item_id = $config->checkInput($_POST['item_id']);

		$archive_item = new ManageInventory();
		if ($archive_item->archiveItem($item_id)) {
			if ($archive_item->archiveExpenses($item_id)) {
				echo json_encode(array('success' => 'ok'));
			}
		}
		

	}
	
	if (isset($_POST['getDetailsOfSelectedItem'])) {
		$item_id = $config->checkInput($_POST['item_id']);
		$getDetailsOfSelectedItem = new ManageInventory();
		$getDetailsOfSelectedItem->getDetailsOfSelectedItem($item_id);
	}

	if(isset($_POST['getItemFromDb'])) {
		$item_id = $config->checkInput($_POST['item_id']);
		$item_quantity = $config->checkInput($_POST['item_quantity']);

		if ($item_quantity == "") {
			echo json_encode(array('error' => 'Input quantity.'));
		} else {
			$getItemFromDb = new ManageInventory();
			if ($getItemFromDb->getItemFromDb($item_id, $item_quantity)) {
				echo json_encode(array("success" => "You get an item!"));
			}
		}
	}
<?php

	require_once '../../classes/Config.php';
	require_once '../classes/ManageReservation.php';

	$config = new Config();

	if (isset($_POST['approve_reservation'])) {
		$employee_id = $config->checkInput($_POST['employee_id']);
		$reservation_id = $config->checkInput($_POST['reservation_id']);

		$approve_reservation = new ManageReservation();
		if($approve_reservation->approveReservation($employee_id, $reservation_id)){
			echo json_encode(array('success' => 'Reservation has been approved!'));
		}
	}

	if (isset($_POST['reject_reservation'])) {
		$employee_id = $config->checkInput($_POST['employee_id']);
		$reservation_id = $config->checkInput($_POST['reservation_id']);

		$reject_reservation = new ManageReservation();
		if($reject_reservation->rejectReservation($employee_id, $reservation_id)){
			echo json_encode(array('success' => 'Reservation has been rejected!'));
		}
	}
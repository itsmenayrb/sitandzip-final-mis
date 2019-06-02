<?php

require_once '../../classes/Config.php';

class ManageReservation extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function approveReservation($employee_id, $reservation_id) {

		try {

			$status = 'Approved';
			$stmt = $this->conn->runQuery("UPDATE reservations_tbl SET 
										employee_id=:empid,
										reservation_status=:status
											WHERE reservation_id=:reservation_id 
									");

			$stmt->bindparam(":reservation_id", $reservation_id);
			$stmt->bindparam(":empid", $employee_id);
		    $stmt->bindparam(":status", $status);
		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }

	}

	public function rejectReservation($employee_id, $reservation_id) {

		try {

			$status = 'Rejected';
			$stmt = $this->conn->runQuery("UPDATE reservations_tbl SET 
										employee_id=:empid,
										reservation_status=:status
											WHERE reservation_id=:reservation_id 
									");

			$stmt->bindparam(":reservation_id", $reservation_id);
			$stmt->bindparam(":empid", $employee_id);
		    $stmt->bindparam(":status", $status);
		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }

	}

}
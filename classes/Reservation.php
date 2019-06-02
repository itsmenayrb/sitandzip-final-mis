<?php
require_once 'Config.php';

class Reservation extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function saveReservation($customer_id, $fullname, $email, $contact_number, $number_of_people, $reservation_date, $reservation_time, $reservation_message) {

		try {

			$status = "Pending";

			$reservation_date = DateTime::createFromFormat('m/d/Y', $reservation_date);
			$reservation_date = $reservation_date->format('Y-m-d');

			// $reservation_time = DateTime::createFromFormat('h:i a', $reservation_time);
			// $reservation_time = $reservation_time->format('h:i a');

			$stmt1 = $this->conn->runQuery("SELECT * FROM reservations_tbl
												WHERE customer_id=:customer_id
													AND reservation_date=:reservation_date
													AND reservation_status=:status LIMIT 1");
			$stmt1->execute(array(':customer_id'=>$customer_id, ':reservation_date' => $reservation_date, ':status' => $status));
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

			if ($stmt1->rowCount() == 1) {

				echo json_encode(array('error' => 'You already have a reservation for that day that is still pending. Update your appointment instead.'));

			} else {


				$stmt = $this->conn->runQuery("INSERT INTO reservations_tbl (
											customer_id,
											reservation_fullname,
											reservation_email,
											reservation_contactnumber,
											reservation_numberofpeople,
											reservation_date,
											reservation_time,
											reservation_message,
											reservation_status
											) VALUES (
												:customer_id,
												:fullname,
												:email,
												:contact_number,
												:number_of_people,
												:reservation_date,
												:reservation_time,
												:reservation_message,
												:reservation_status
											)
										");

				$stmt->bindparam(":customer_id", $customer_id);
			    $stmt->bindparam(":fullname", $fullname);
			    $stmt->bindparam(":email", $email);
			    $stmt->bindparam(":contact_number", $contact_number);
			    $stmt->bindparam(":number_of_people", $number_of_people);
			    $stmt->bindparam(":reservation_date", $reservation_date);
			    $stmt->bindparam(":reservation_time", $reservation_time);
			    $stmt->bindparam(":reservation_message", $reservation_message);
			    $stmt->bindparam(":reservation_status", $status);

			    $stmt->execute();

			    return $stmt;
			}

        } catch (PDOException $e) {

              echo $e->getMessage();

        }


	}

}
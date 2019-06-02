<?php

require_once '../../classes/Config.php';

class EmployeeProfile extends Config {

	protected $conn;

	public function __construct() {

		$this->conn = new Config();

	}

	public function saveProfile($employee_id, $firstname, $lastname, $contact_number) {
		try {

			$stmt = $this->conn->runQuery("UPDATE employeesaccount_tbl
											SET employee_firstname=:firstname, employee_contactnumber=:contact_number, employee_lastname=:lastname
												WHERE employee_id=:employee_id");

			$stmt->bindparam(":employee_id", $employee_id);
		    $stmt->bindparam(":firstname", $firstname);
		    $stmt->bindparam(":lastname", $lastname);
		    $stmt->bindparam(":contact_number", $contact_number);

		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }
	}

}
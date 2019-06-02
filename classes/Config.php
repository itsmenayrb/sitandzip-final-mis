<?php
require_once 'Database.php';

class Config {

	/**
	 * Connector for databases
	 */
	protected $conn;

	/**
	 * Initialize Database
	 */

	public function __construct() {

		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;

	}

	/**
	 * Function for querying
	 *
	 * @param string $sql
	 * @return $stmt
	 */
	public function runQuery($sql) {

		$stmt = $this->conn->prepare($sql);
    	return $stmt;

	}

	/**
	 * Function for Sanitizing data
	 *
	 * @param string $data
	 * @return $data
	 */
	public function checkInput($data) {

		$data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

	}

	/**
	 * Function for redirecting
	 *
	 * @param string $url
	 * @return void
	 */
	public function redirect($url) {

		header("Location: $url");

	}

	/**
	 * Function for redirecting with
	 * 5 seconds interval
	 * @param string $url
	 * @return void
	 */
	public function slow_redirect($url){

		header("refresh:5;url=$url");

	}

	/**
	 * Function if user is logged in
	 *
	 * @return boolean
	 */
	public function is_loggedin() {

    	if(isset($_SESSION['costumer_username']) || isset($_SESSION['employee_username']) || isset($_SESSION['employee_email']) || isset($_SESSION['employee_position'])) {
      		return true;
    	}

  	}

  	/**
	 * function for logout
	 *
	 * @return boolean
	 */
	public function doLogout() {

	    unset($_SESSION['costumer_username']);
	    unset($_SESSION['employee_username']);
	    unset($_SESSION['employee_email']);
	    unset($_SESSION['employee_position']);
		session_destroy();
	    return true;

	}

	public function generateTransactId() {

  		$date   = new DateTime(); //this returns the current date time
		$result = $date->format('Y-m-d-H-i-s');
		$krr    = explode('-', $result);
		$result = implode("", $krr);
        return $result;

  	}

}
?>
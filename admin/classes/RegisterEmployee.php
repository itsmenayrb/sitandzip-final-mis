<?php

require_once '../../classes/Config.php';

class RegisterEmployee extends Config {

	private $username = null;
	private $email = null;
	private $password = null;
	private $position = null;
	protected $conn;

	public function __construct($username, $email, $password, $position) {

		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
		$this->position = $position;

		$this->conn = new Config();

	}

	public function validateEmployeeCredentials() {

		$error = [];

		try {

              $stmt = $this->conn->runQuery("SELECT employee_username, employee_email
              									FROM employeesaccount_tbl
              										WHERE employee_username=:username
              											OR employee_email=:email
              												LIMIT 1");

              $stmt->execute(array(':username'=>$this->username, ':email'=>$this->email));
              $row=$stmt->fetch(PDO::FETCH_ASSOC);

              if($row['employee_username'] == $this->username) {

                  $error[] = "Username is already taken!";

              } 

              if ($row['employee_email'] == $this->email) {

                  $error[] = "Email is already taken!";

              } 

              if(count($error) == 0) {

              	$this->register();
              	$success = 'Success';
              	echo json_encode($success);

              } else {

       			echo json_encode($error);

              }
       

          } catch (PDOException $e) {
              
              echo $e->getMessage();

          }

	}

	public function register() {

        try {

			$status = "Active";
			$dateCreated = date('Y-m-d G:i:s');
			$employee_role = 1;
			$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
			$stmt = $this->conn->runQuery("INSERT INTO employeesaccount_tbl (
										employee_username,
										employee_email,
										employee_password,
										employee_position,
										employee_status,
										employee_role,
										employee_datecreated
										) VALUES (
											:username,
											:email,
											:password,
											:position,
											:status,
											:employee_role,
											:dateCreated
										)
									");

			$stmt->bindparam(":username", $this->username);
		    $stmt->bindparam(":email", $this->email);
		    $stmt->bindparam(":position", $this->position);
		    $stmt->bindparam(":password", $hashed_password);
		    $stmt->bindparam(":status", $status);
		    $stmt->bindparam(":employee_role", $employee_role);
		    $stmt->bindparam(":dateCreated", $dateCreated);

		    $stmt->execute();

		    return $stmt;

        } catch (Exception $e) {

              echo $e->getMessage();

        }
              
              
	}

}

?>
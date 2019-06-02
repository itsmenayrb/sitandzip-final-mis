<?php

require_once 'Config.php';

class Register extends Config {

	private $username = null;
	private $email = null;
	private $password = null;
	protected $conn;

	public function __construct($username, $email, $password) {

		$this->username = $username;
		$this->email = $email;
		$this->password = $password;

		$this->conn = new Config();

	}

	public function validateCredentials() {
		
		$error = [];

		try {

              $stmt = $this->conn->runQuery("SELECT customer_username, customer_email
              									FROM customersaccount_tbl
              										WHERE customer_username=:username
              											OR customer_email=:email");

              $stmt->execute(array(':username'=>$this->username, ':email'=>$this->email));
              $row=$stmt->fetch(PDO::FETCH_ASSOC);

              if($row['customer_username'] == $this->username) {

                  $error[] = "Username is already taken!";

              } 

              if ($row['customer_email'] == $this->email) {

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
			$user_role = 0;
			$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
			$stmt = $this->conn->runQuery("INSERT INTO customersaccount_tbl (
										customer_username,
										customer_email,
										customer_password,
										customer_status,
										customer_role,
										customer_datecreated
										) VALUES (
											:username,
											:email,
											:password,
											:status,
											:user_role,
											:dateCreated
										)
									");

			$stmt->bindparam(":username", $this->username);
		    $stmt->bindparam(":email", $this->email);
		    $stmt->bindparam(":password", $hashed_password);
		    $stmt->bindparam(":status", $status);
		    $stmt->bindparam(":user_role", $user_role);
		    $stmt->bindparam(":dateCreated", $dateCreated);

		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }
              
              
	}

}

?>
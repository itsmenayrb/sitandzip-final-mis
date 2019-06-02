<?php
require_once 'Config.php';

class Login extends Config {

	private $username = null;
	private $email = null;
	private $password = null;

	public function __construct($username, $email, $password) {

		$this->username = $username;
		$this->email = $email;
		$this->password = $password;

		$this->conn = new Config();

	}

	public function login() {

		$error = [];

		try {

			$stmt = $this->conn->runQuery("SELECT customer_id, customer_username, customer_email, customer_password
											FROM customersaccount_tbl
												WHERE customer_username=:username
													OR customer_email=:email
														LIMIT 1");

			$stmt->execute(array(':username'=>$this->username, ':email'=>$this->email));
      		$row=$stmt->fetch(PDO::FETCH_ASSOC);

      		if($stmt->rowCount() == 1)
		    {
		        if(password_verify($this->password, $row['customer_password']))
		        {
		          	$_SESSION['customer_username'] = $row['customer_username'];
		          	$_SESSION['customer_email'] = $row['customer_email'];
		          	$_SESSION['customer_id'] = $row['customer_id'];
		          	$success = 'Success';
		          	echo json_encode($success);
		        }
		        else
		        {
		        	$error[] = 'Invalid credentials';
		        }

		    }
		    else
		    {
		    	$error[] = 'Invalid credentials';
		    }

		    if (count($error) != 0){
		    	echo json_encode($error);
		    }

		} catch (PDOException $e) {

			echo $e->getMessage();

		}
	}

}

?>
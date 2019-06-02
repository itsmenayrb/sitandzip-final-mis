<?php

require_once '../../classes/Config.php';

class LoginEmployee extends Config {

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

	public function login() {

		$error = [];

		try {

			$status = 'Active';
			$stmt = $this->conn->runQuery("SELECT *
											FROM employeesaccount_tbl
												WHERE employee_username=:username
													OR employee_email=:email
														AND employee_status=:status
														LIMIT 1");

			$stmt->execute(array(':username'=>$this->username, ':email'=>$this->email, ':status'=>$status));
      		$row=$stmt->fetch(PDO::FETCH_ASSOC);

      		if($stmt->rowCount() == 1)
		    {

		    	if ($row['employee_status'] == 'Active') {

			        if(password_verify($this->password, $row['employee_password']))
			        {
			          	$_SESSION['employee_username'] = $row['employee_username'];
			          	$_SESSION['employee_id'] = $row['employee_id'];
			          	$_SESSION['employee_position'] = $row['employee_position'];
			          	
			          	$success = 'Success';
			          	echo json_encode($success);
			        }
			        else
			        {
			        	$error[] = 'Invalid credentials';
			        }

		    	} else {

		    		$error[] = 'The account that you are trying to logged in is already deactivated. If you think that this is a mistake or wish to re-activate the account, please contact the administrator.';
		    		
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
<?php

require_once '../../classes/Config.php';

class ManageUsers extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function displayUsersList() {

		try {

			$stmt = $this->conn->runQuery("SELECT * FROM employeesaccount_tbl");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$id = $row['employee_id'];
				$username = $row['employee_username'];
				$position = $row['employee_position'];
				$status = $row['employee_status'];

				?>
					<tr>
						<td><?php echo $id; ?></td>
						<td>
							<a href="./manage.users.php?employeeid=<?php echo $id; ?>&status=<?php echo $status; ?>" class="btn-link">
								<?php echo $username; ?>
							</a>
						</td>
						<td><?php echo $position; ?></td>
						<td><?php echo $status; ?></td>
					</tr>
				<?php


			}
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


	}

	public function registerEmployee($username, $email, $position, $password) {

		$error = [];

		try {

			$stmt1 = $this->conn->runQuery("SELECT employee_username, employee_email
              									FROM employeesaccount_tbl
              										WHERE employee_username=:username
              											OR employee_email=:email
              												LIMIT 1");

              $stmt1->execute(array(':username'=>$username, ':email'=>$email));
              $row1=$stmt1->fetch(PDO::FETCH_ASSOC);

              if($row1['employee_username'] == $username) {

                  $error[] = "Username is already taken!";

              } 

              if ($row1['employee_email'] == $email) {

                  $error[] = "Email is already taken!";

              }

              if (count($error) == 0) {

				$status = "Active";
				$dateCreated = date('Y-m-d G:i:s');
				$employee_role = 1;
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
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

				$stmt->bindparam(":username", $username);
			    $stmt->bindparam(":email", $email);
			    $stmt->bindparam(":position", $position);
			    $stmt->bindparam(":password", $hashed_password);
			    $stmt->bindparam(":status", $status);
			    $stmt->bindparam(":employee_role", $employee_role);
			    $stmt->bindparam(":dateCreated", $dateCreated);

			    $stmt->execute();

			    return $stmt;

              } else {

              	echo json_encode(array("error" => $error));

              }


        } catch (Exception $e) {

              echo $e->getMessage();

        }


	}

	public function updateUser($firstname, $lastname, $position, $contact_number, $employee_id) {

		try {

			$stmt = $this->conn->runQuery("UPDATE employeesaccount_tbl
											SET employee_firstname=:firstname, employee_lastname=:lastname, employee_position=:position, employee_contactnumber=:contact_number
												WHERE employee_id=:empid");

			$stmt->bindparam(":firstname", $firstname);
			$stmt->bindparam(":lastname", $lastname);
			$stmt->bindparam(":position", $position);
			$stmt->bindparam(":contact_number", $contact_number);
			$stmt->bindparam(":empid", $employee_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


	}

	public function deactivateUser($employee_id) {

		try {

			$status = 'Deactivated';
			$dateDeactivated = date('Y-m-d G:i:s');

			$stmt = $this->conn->runQuery("UPDATE employeesaccount_tbl
											SET employee_status=:status, employee_datedeactivated=:datedeactivated
												WHERE employee_id=:empid");

			$stmt->bindparam(":datedeactivated", $dateDeactivated);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":empid", $employee_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


	}

	public function resetPassword($employee_id, $password) {

		try {

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $this->conn->runQuery("UPDATE employeesaccount_tbl
											SET employee_password=:password
												WHERE employee_id=:empid");

			$stmt->bindparam(":password", $hashed_password);
			$stmt->bindparam(":empid", $employee_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

}
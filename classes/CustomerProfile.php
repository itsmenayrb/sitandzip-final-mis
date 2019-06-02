<?php
require_once 'Config.php';

class CustomerProfile extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function saveProfile($customer_id, $fullname, $contact_number) {


		try {

			$stmt = $this->conn->runQuery("UPDATE customersaccount_tbl
											SET customer_fullname=:fullname, customer_contactnumber=:contact_number
												WHERE customer_id=:customer_id");

			$stmt->bindparam(":customer_id", $customer_id);
		    $stmt->bindparam(":fullname", $fullname);
		    $stmt->bindparam(":contact_number", $contact_number);

		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }

	}

	public function passwordReset($customer_id, $current_password, $new_password) {

		try {

			$stmt1 = $this->conn->runQuery("SELECT customer_password FROM customersaccount_tbl
											WHERE customer_id=:customer_id LIMIT 1");
			$stmt1->execute(array(':customer_id' => $customer_id));
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

			if($stmt1->rowCount() == 1){
				if(password_verify($current_password, $row1['customer_password'])){

					$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

					$stmt = $this->conn->runQuery("UPDATE customersaccount_tbl
													SET customer_password=:password
														WHERE customer_id=:customer_id");

					$stmt->bindparam(":customer_id", $customer_id);
				    $stmt->bindparam(":password", $hashed_password);

				    $stmt->execute();

				    return $stmt;

				} else {
					echo json_encode(array('error' => 'Incorrect password.'));
				}
			} else {
				echo json_encode(array('error' => 'Incorrect password.'));
			}

        } catch (PDOException $e) {

              echo $e->getMessage();

        }

	}

	public function showReservationToUpdate($reservation_id) {
		try {

          $stmt = $this->conn->runQuery("SELECT * FROM reservations_tbl
          									WHERE reservation_id=:reservation_id LIMIT 1");

          $stmt->execute(array(':reservation_id' => $reservation_id));

          if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
            
            $reservation_id = $row['reservation_id'];
            $reservation_date = $row['reservation_date'];
            $reservation_time = $row['reservation_time'];
            $number_of_people = $row['reservation_numberofpeople'];
            $reservation_fullname = $row['reservation_fullname'];
            $reservation_email = $row['reservation_email'];
            $reservation_contactnumber = $row['reservation_contactnumber'];
            $reservation_message = $row['reservation_message'];

            $reservation_date = DateTime::createFromFormat('Y-m-d', $reservation_date);
			$reservation_date = $reservation_date->format('m/d/Y');

            ?>
            <div class="row">
                <div class="col-md-6">
	                <div class="form-group">
	                	<label class="form-control-label" for="reservation_fullname">Full name</label>
	                  <input type="text" class="form-control" id="reservation_fullname" placeholder="Full Name" value="<?= $reservation_fullname; ?>">
	                </div>
	            </div>
	            <div class="col-md-6">
	                <div class="form-group">
	                <label class="form-control-label" for="reservation_email">Email</label>                        
	                  <input type="email" class="form-control" id="reservation_email" placeholder="Email" value="<?= $reservation_email ?>">
	                </div>
	            </div>
	            <div class="col-md-6">
	                <div class="form-group">
	                	<label class="form-control-label" for="reservation_contactnumber">Contact number</label>
	                  <input type="text" class="form-control" id="reservation_contactnumber" placeholder="Contact Number" minlength="10" maxlength="11" value="<?= $reservation_contactnumber; ?>">
	                </div>
	            </div>
	            <div class="col-md-6">
                  <div class="form-group">
                  	<label class="form-control-label" for="reservation_numberofpeople">Number of people</label>
                    <input type="text" class="form-control" id="reservation_numberofpeople" placeholder="Number of people" minlength="10" maxlength="11" value="<?= $number_of_people; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  	<label class="form-control-label" for="reservation_date">Date</label>
                    <input type="text" class="form-control" id="reservation_date" placeholder="Date" value="<?= $reservation_date; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  	<label class="form-control-label" for="reservation_time">Time</label>
                    <input type="text" class="form-control datetimepicker-input" id="reservation_time" placeholder="Time" data-toggle="datetimepicker" data-target="#reservation_time" value="<?= $reservation_time; ?>">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                  	<label class="form-control-label" for="reservation_message">Message</label>
                    <textarea class="form-control" cols="30" rows="5" placeholder="Your Message" id="reservation_message"><?= $reservation_message; ?></textarea>
                  </div>
                </div>
            </div>
            <script type="text/javascript">
            	jQuery('#reservation_date').datepicker({
			      startDate: '+1d'
			    });
            	$('#reservation_time').datetimepicker({
			        format: 'LT',
			        disabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 22, 23, 24],
					enabledHours: [11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22]
			    });
            </script>
            
            <?php
          }
          
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
	}	

	public function updateReservation($reservation_id, $fullname, $email, $contact_number, $number_of_people, $reservation_date, $reservation_time, $reservation_message) {

		try {


			$reservation_date = DateTime::createFromFormat('m/d/Y', $reservation_date);
			$reservation_date = $reservation_date->format('Y-m-d');

			$stmt = $this->conn->runQuery("UPDATE reservations_tbl SET
										reservation_fullname=:fullname,
										reservation_email=:email,
										reservation_contactnumber=:contact_number,
										reservation_numberofpeople=:number_of_people,
										reservation_date=:reservation_date,
										reservation_time=:reservation_time,
										reservation_message=:message
											WHERE reservation_id=:reservation_id
									");

			$stmt->bindparam(":reservation_id", $reservation_id);
		    $stmt->bindparam(":fullname", $fullname);
		    $stmt->bindparam(":email", $email);
		    $stmt->bindparam(":contact_number", $contact_number);
		    $stmt->bindparam(":number_of_people", $number_of_people);
		    $stmt->bindparam(":reservation_date", $reservation_date);
		    $stmt->bindparam(":reservation_time", $reservation_time);
		    $stmt->bindparam(":message", $reservation_message);

		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }
    }

    public function cancelReservation($reservation_id) {

		try {

			$status = 'Cancelled';

			$stmt = $this->conn->runQuery("UPDATE reservations_tbl
											SET reservation_status=:status
											WHERE reservation_id=:reservation_id");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":reservation_id", $reservation_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function sendTestimonials($customer_id, $testimonials) {

		try {

			$stmt = $this->conn->runQuery("INSERT INTO testimonials_tbl (customer_id, testimonials_message) VALUES (:customer_id, :testimonials)");

			$stmt->bindparam(":customer_id", $customer_id);
			$stmt->bindparam(":testimonials", $testimonials);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}	

}
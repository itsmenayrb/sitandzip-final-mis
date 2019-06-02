<?php
require_once 'Config.php';

class Message extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function sendMessage($fullname, $email, $subject, $message) {

		 try {

		 	$status = 'Unread';
		 	$message_date = date('Y-m-d H:i:s');

			$stmt = $this->conn->runQuery("INSERT INTO messages_tbl (
										message_fullname,
										message_email,
										message_subject,
										message_body,
										message_date,
										message_status
										) VALUES (
											:fullname,
											:email,
											:subject,
											:body,
											:message_date,
											:status
										)
									");

			$stmt->bindparam(":fullname", $fullname);
		    $stmt->bindparam(":email", $email);
		    $stmt->bindparam(":subject", $subject);
		    $stmt->bindparam(":body", $message);
		    $stmt->bindparam(":message_date", $message_date);
		    $stmt->bindparam(":status", $status);

		    $stmt->execute();

		    return $stmt;

        } catch (Exception $e) {

              echo $e->getMessage();

        }

	}

}
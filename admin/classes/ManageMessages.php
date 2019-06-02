<?php

require_once '../../classes/Config.php';

class ManageMessages extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function showMessage($message_id) {

		try {

          $stmt = $this->conn->runQuery("SELECT * FROM messages_tbl
          									WHERE message_id=:message_id LIMIT 1");

          $stmt->execute(array(':message_id' => $message_id));

          if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
            
            $subject = $row['message_subject'];
            $email = $row['message_email'];
            $message = $row['message_body'];

            ?>
            <div class="form-group">
            	<label class="form-control-label" for="message_email">From</label>
            	<input type="text" id="message_email" class="form-control" value="<?= $email; ;?>" disabled/>
            </div>
            <div class="form-group">
            	<label class="form-control-label" for="message_subject">Subject</label>
            	<input type="text" id="message_subject" class="form-control" value="Re: <?= $subject; ;?>" disabled/>
            </div>
			<div class="form-group">
                <label class="form-control-label" for="message_body">Message</label>
                <textarea id="message_body" class="form-control" cols="30" rows="50" disabled><?= $message; ;?></textarea>
            </div>
	
			<div class="form-group">
                <label class="form-control-label" for="message_reply">Reply</label>
                <textarea id="message_reply" class="form-control" cols="30" rows="30"></textarea>
            </div>

            <?php
          }
          
        } catch (PDOException $e) {
          echo $e->getMessage();
        }

	}

	public function archiveMessage($message_id) {

		try {

			$status = 'Archived';
			$stmt = $this->conn->runQuery("UPDATE messages_tbl
											SET message_status=:status
												WHERE message_id=:message_id");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":message_id", $message_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


	}

}
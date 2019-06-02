<?php

require_once '../../classes/Config.php';

class ManageOrders extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function processThisOrder($transaction_id, $transacted_by) {

		try {

			$status = 'Completed';

			$stmt = $this->conn->runQuery("UPDATE orders_tbl
												SET order_status=:status, order_preparedby=:prepared_by
													WHERE order_transactionid=:transactionid");

			$stmt->bindparam(":status", $status);
		    $stmt->bindparam(":transactionid", $transaction_id);
		    $stmt->bindparam(":prepared_by", $transacted_by);

		    $stmt->execute();

		    return $stmt;

        } catch (Exception $e) {

              echo $e->getMessage();

        }


	}

}
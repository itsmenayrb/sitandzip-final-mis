<?php

require_once '../../classes/Config.php';

class SALES extends Config {

	private $sales = 0;
	private $sales_thisweek = 0;
	private	$dateToday;
	private $profit = 0;
	private $expenses = 0;

	public function __construct() {

		$this->conn = new Config();

	}

	public function displaySales($startDate, $endDate) {

		try {

			$stmt = $this->conn->runQuery("SELECT sales_totalamount
											FROM sales_tbl
												WHERE sales_date
													BETWEEN :startdate AND :enddate");
			$stmt->execute(array(":startdate" => $startDate, ":enddate" => $endDate));

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$sales = $row['sales_totalamount'];
				$this->sales+=$sales;

			}

			$this->sales = number_format($this->sales, 2);
			echo json_encode($this->sales);
			
		} catch (PDOException $e) {
			
			echo $e->getMessage();

		}

	}


	public function displayDetailedSales($startDate, $endDate) {

		try {

			$this->dateToday = date('Y-m-d');
			$stmt = $this->conn->runQuery("SELECT * FROM sales_tbl
											WHERE sales_date
												BETWEEN :startdate AND :enddate
													ORDER BY sales_date");
            $stmt->execute(array(":startdate" => $startDate, ":enddate" => $endDate));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
            	$transaction_id = $row['order_transactionid'];
				$total_amount = $row['sales_totalamount'];
				$cust_payment = $row['sales_payment'];
				$cust_change = $row['sales_change'];
				$sales_date = $row['sales_date'];
				$transacted_by = $row['sales_transactby'];

				?>
					<tr>
                        <td><a href="javascript:void(0)" class="btn btn-link" data-id="<?php echo $transaction_id; ?>" onclick="displayThisTransaction(this);"><?php echo $transaction_id; ?></a></td>
                        <td><?php echo $total_amount; ?></td>
                        <td><?php echo $cust_payment; ?></td>
                        <td><?php echo $cust_change; ?></td>
                        <td><?php echo $transacted_by; ?></td>
                        <td><?php echo $sales_date; ?></td>
                    </tr>

				<?php
            }
			
		} catch (PDOException $e) {

			echo $e->getMessage();

		}

	}

	public function displaySalesGraph($startDate, $endDate) {

		try {

			$sales_dateGraph = [];
			$sales_amountGraph = [];

			$stmt = $this->conn->runQuery("SELECT * FROM sales_tbl
											WHERE sales_date
												BETWEEN :startdate AND :enddate");
            $stmt->execute(array(":startdate" => $startDate, ":enddate" => $endDate));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
            	extract($row);
				$sales_amountGraph[] = (int)$sales_totalamount;
				$sales_dateGraph[] = $sales_date;
            }

            echo json_encode(array('amount' => $sales_amountGraph, 'sales_date' => $sales_dateGraph));
			
		} catch (PDOException $e) {

			echo $e->getMessage();

		}

	}


	public function displayTodaySales() {

		try {

			$dateToday = date('Y-m-d');
			$stmt = $this->conn->runQuery("SELECT sales_totalamount
											FROM sales_tbl
												WHERE sales_date >= :datetoday AND sales_date <= :datetoday");
			$stmt->execute(array(":datetoday" => $dateToday));

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$sales = $row['sales_totalamount'];
				$this->sales+=$sales;

			}

			$this->sales = number_format($this->sales, 2);
			echo json_encode($this->sales);
			
		} catch (PDOException $e) {
			
			echo $e->getMessage();

		}

	}

	public function displayNetProfit($startDate, $endDate) {

		try {

			$stmt = $this->conn->runQuery("SELECT sales_totalamount
											FROM sales_tbl
												WHERE sales_date
													BETWEEN :startdate AND :enddate");
			$stmt->execute(array(":startdate" => $startDate, ":enddate" => $endDate));

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$sales = $row['sales_totalamount'];
				$this->sales+=$sales;

			}

			$status = 'Verified';
			$stmt1 = $this->conn->runQuery("SELECT item_total
											FROM expenses_tbl
												WHERE expenses_status=:status
												AND item_datepurchased
													BETWEEN :startdate AND :enddate");
			$stmt1->execute(array(":startdate" => $startDate, ":enddate" => $endDate, ":status" => $status));

			while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

				$expenses = $row1['item_total'];
				$this->expenses+=$expenses;

			}

			$this->profit = $this->sales - $this->expenses;
			$this->profit = number_format($this->profit, 2);
			echo json_encode($this->profit);
			
		} catch (PDOException $e) {
			
			echo $e->getMessage();

		}

	}	

}

?>
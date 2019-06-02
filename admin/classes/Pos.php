<?php

require_once '../../classes/Config.php';

class POS extends Config {

	private $price = null;
	private $productname = null;
	private $quantity = 1;
	private $subtotal = 0;


	public function __construct() {

		$this->conn = new Config();

	}

	public function displayActiveProducts() {

        try {

			$status = "Active";
			$stmt = $this->conn->runQuery("SELECT * FROM products_tbl WHERE product_status=:status
											ORDER BY productcategory_id");

		    $stmt->execute(array(":status"=>$status));
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		    {
		    	$product_id = $row['product_id'];
		    	$product_name = $row['product_name'];
		    	$product_price = $row['product_price'];

	    		?>
					<button type="button" class="mu-readmore-btn pos-btn" id='thisPrice' onclick="orderThis(<?php echo $product_id;?>, <?php echo $product_price;?>, '<?php echo $product_name; ?>');">
	                  	<?php $product_name = wordwrap($product_name, 15, "<br/>\n"); echo $product_name; ?>
	                </button>
	    		<?php
		    }

        } catch (PDOException $e) {

              echo $e->getMessage();

        }

	}

	public function saveOrder($transaction_id, $productname, $quantity) {

		
		try {

			$status = 'Pending';
			$stmt = $this->conn->runQuery("INSERT INTO orders_tbl (
											order_transactionid,
											order_productname,
											order_quantity,
											order_status
											) VALUES (
											:transactionid,
											:prodname,
											:quantity,
											:status
											)
										");

			$stmt->bindparam(":transactionid", $transaction_id);
			$stmt->bindparam(":prodname", $productname);
			$stmt->bindparam(":quantity", $quantity);
			$stmt->bindparam(":status", $status);			

			$stmt->execute();
			return $stmt;

			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function insertToSales($transaction_id, $totalAmount, $payment, $change, $transact_by) {

		$date = date('Y-m-d H:i:s');
		$stmt2 = $this->conn->runQuery("INSERT INTO sales_tbl (
										order_transactionid,
										sales_totalamount,
										sales_payment,
										sales_change,
										sales_transactby,
										sales_date
										) VALUES (
										:transactionid,
										:totalamount,
										:payment,
										:change,
										:transactby,
										:salesdate
										)
									");

		$stmt2->bindparam(":transactionid", $transaction_id);
		$stmt2->bindparam(":totalamount", $totalAmount);
		$stmt2->bindparam(":payment", $payment);
		$stmt2->bindparam(":change", $change);
		$stmt2->bindparam(":transactby", $transact_by);
		$stmt2->bindparam(":salesdate", $date);

		$stmt2->execute();
		return $stmt2;

	}

}

?>
<?php
require_once 'Config.php';

class Menu extends Config {

	public function __construct() {

		$this->conn = new Config();

	}

	public function getMenu() {

		try {

			$status = "Active";
			$stmt = $this->conn->runQuery("SELECT * FROM productcategories_tbl
											WHERE productcategory_status=:status
												ORDER BY productcategory_name");
			$stmt->execute(array(":status"=>$status));

				?>
				<option value="" disabled selected>Select a category.</option>
	        	<?php

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$productname = $row['productcategory_name'];
				$productcategory_id = $row['productcategory_id'];

				?>
					<option value="<?php echo $productcategory_id; ?>">
						<?php echo $productname; ?>
					</option>
				<?php


			}
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getProductMenu($category) {

		try {

			$status = 'Active';
			$stmt = $this->conn->runQuery("SELECT product_name, product_price
											FROM products_tbl
												WHERE productcategory_id = :category
													AND product_status = :status");

			$stmt->execute(array(":category" => $category, ":status" => $status));

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$productname = $row['product_name'];
				$productprice = $row['product_price'];

				?>
					<div class="panel panel-warning" style="width: 25rem; display: inline-flex; height: 8rem; margin-right: 10px;">
					  	<div class="panel-heading">
					    	<h5 class="panel-title"><?php echo $productname; ?> <br> <?php echo $productprice; ?></h5>
						</div>
					    <div class="panel-body"><?php echo $productprice; ?></div>
					  </div>
					</div>
				<?php
			}

			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

}
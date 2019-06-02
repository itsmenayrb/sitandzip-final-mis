<?php

require_once '../../classes/Config.php';

class ManageArchives extends Config {

	protected $conn;

	public function __construct() {

		$this->conn = new Config();

	}

	public function restoreCategory($category_id) {

		try {

			$status = 'Active';
			$stmt = $this->conn->runQuery("UPDATE productcategories_tbl
												INNER JOIN products_tbl
													ON productcategories_tbl.productcategory_id = products_tbl.productcategory_id
														SET productcategories_tbl.productcategory_status=:status, products_tbl.product_status=:status
															WHERE productcategories_tbl.productcategory_id=:catid");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":catid", $category_id);

			$stmt->execute();

			return $stmt;
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


	}

	public function restoreProduct($product_id) {

		try {

			$status = 'Active';
			$stmt = $this->conn->runQuery("UPDATE products_tbl
											SET product_status=:status
												WHERE product_id=:prodid");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":prodid", $product_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function restoreItem($item_id) {

		try {

			$status = 'On stock';
			$stmt = $this->conn->runQuery("UPDATE inventory_tbl
											SET item_status=:status
												WHERE item_id=:item_id");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":item_id", $item_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function restoreAccount($employee_id) {

		try {

			$status = 'Active';
			$stmt = $this->conn->runQuery("UPDATE employeesaccount_tbl
											SET employee_status=:status
												WHERE employee_id=:employee_id");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":employee_id", $employee_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

}
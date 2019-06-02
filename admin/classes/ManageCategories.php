<?php

require_once '../../classes/Config.php';

class ManageCategories extends Config {

	private $categoryname = null;
	private $category_id = null;
	protected $conn;

	public function __construct() {

		$this->conn = new Config();

	}

	public function validateCategory($categoryname, $category_id = "") {

		$this->categoryname = $categoryname;
		$this->category_id = $category_id;

		$error = [];
		$success = [];

		try {

              $stmt = $this->conn->runQuery("SELECT productcategory_name
              									FROM productcategories_tbl
              										WHERE productcategory_name=:catname
              											LIMIT 1");

              $stmt->execute(array(':catname'=>$this->categoryname));
              $row=$stmt->fetch(PDO::FETCH_ASSOC);

              if($row['productcategory_name'] == $this->categoryname) {

                  $error[] = "Exist";

              }

              if ($this->category_id == "") {

	              if(count($error) == 0) {

	              	$this->addCategory();
	              	$success[] = 'Success';
	              	echo json_encode($success);

	              } else {

	       			echo json_encode($error);

	              }

	          }

	          if ($this->category_id != "") {

	              if(count($error) == 0) {

	              	$this->editCategory($this->categoryname, $this->category_id);
	              	$success[] = 'Success';
	              	echo json_encode($success);

	              } else {

	       			echo json_encode($error);

	              }

	          }       

          } catch (PDOException $e) {
              
              echo $e->getMessage();

          }

	}

	public function addCategory() {

        try {

			$status = "Active";
			$stmt = $this->conn->runQuery("INSERT INTO productcategories_tbl (
										productcategory_name,
										productcategory_status
										) VALUES (
											:catname,
											:status
										)
									");

			$stmt->bindparam(":catname", $this->categoryname);
		    $stmt->bindparam(":status", $status);

		    $stmt->execute();

		    return $stmt;

        } catch (Exception $e) {

              echo $e->getMessage();

        }
              
              
	}

	public function editCategory($categoryname, $category_id) {

        try {

			$stmt = $this->conn->runQuery("UPDATE productcategories_tbl
												SET productcategory_name=:catname
													WHERE productcategory_id=:catid");

			$stmt->bindparam(":catname", $categoryname);
		    $stmt->bindparam(":catid", $category_id);

		    $stmt->execute();

		    return $stmt;

        } catch (Exception $e) {

              echo $e->getMessage();

        }
              
              
	}

	public function getCategoryList() {

		try {

			$stmt = $this->conn->runQuery("SELECT * FROM productcategories_tbl");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$product_id = $row['productcategory_id'];
				$productname = $row['productcategory_name'];
				$product_status = $row['productcategory_status'];

				?>
					<tr>
						<td><?php echo $product_id; ?></td>
						<td>
							<a href="./manage.categories.php?categoryid=<?php echo $product_id; ?>&status=<?php echo $product_status; ?>" class="btn-link">
								<?php echo $productname; ?>
							</a>
						</td>
						<td><?php echo $product_status; ?></td>
					</tr>
				<?php
			}
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getOptionList() {

		try {

			$status = "Active";
			$stmt = $this->conn->runQuery("SELECT * FROM productcategories_tbl
											WHERE productcategory_status=:status");
			$stmt->execute(array(":status"=>$status));

				?>
				<option value="" disabled selected>Select a category name.</option>
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

	private $currentValue = null;

	public function oldCategoryValue($list) {

		$this->currentValue = $list;

		try {

			$stmt = $this->conn->runQuery("SELECT * FROM productcategories_tbl
											WHERE productcategory_id=:catid
												LIMIT 1");
			$stmt->execute(array(":catid"=>$this->currentValue));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if($row['productcategory_id'] == $this->currentValue) {

				$oldVal = $row['productcategory_name'];
				echo json_encode($oldVal);

			}			
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function archiveCategory($category_id) {

		try {

			$status = 'Archived';
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

}

?>

<?php

require_once '../../classes/Config.php';

class ManageProducts extends Config {

	private $categoryname = null;
	private $productname = null;
	private $productprice = null;
	private $product_id = null;
	protected $conn;

	public function __construct() {

		$this->conn = new Config();

	}

	public function validateProducts($categoryname, $productname, $productprice, $product_id = "") {

		$this->product_id = $product_id;
		$this->categoryname = $categoryname;
		$this->productname = $productname;
		$this->productprice = $productprice;

		$error = [];
		$success = [];

		try {

			$stmt = $this->conn->runQuery("SELECT product_name
              									FROM products_tbl
              										WHERE product_name=:prodname
              											LIMIT 1");

              $stmt->execute(array(':prodname'=>$this->productname));
              $row=$stmt->fetch(PDO::FETCH_ASSOC);

              if($row['product_name'] == $this->productname) {

                  $error[] = "Exist";

              }

              $stmt = $this->conn->runQuery("SELECT *
              									FROM products_tbl
              										WHERE product_id=:prodid
              											LIMIT 1");

              $stmt->execute(array(':prodid'=>$this->product_id));
              $row=$stmt->fetch(PDO::FETCH_ASSOC);

              if ($this->product_id == "") {

	              if(count($error) == 0) {

	              	$this->addProduct();
	              	$success[] = 'Success';
	              	echo json_encode($success);

	              } else {

	       			echo json_encode($error);

	              }

	          }

	          if ($this->product_id != "") {

	              	$this->editProduct($this->categoryname, $this->product_id, $this->productname, $this->productprice);
	              	$success[] = 'Success';
	              	echo json_encode($success);

	          }       

          } catch (PDOException $e) {
              
              echo $e->getMessage();

          }

	}

	public function addProduct() {

        try {

			$status = "Active";
			$stmt = $this->conn->runQuery("INSERT INTO products_tbl (
											productcategory_id,
											product_name,
											product_price,
											product_status
										) VALUES (
											:catid,
											:prodname,
											:prodprice,
											:status
										)
									");

			$stmt->bindparam(":catid", $this->categoryname);
			$stmt->bindparam(":prodname", $this->productname);
			$stmt->bindparam(":prodprice", $this->productprice);
		    $stmt->bindparam(":status", $status);

		    $stmt->execute();

		    return $stmt;

        } catch (Exception $e) {

              echo $e->getMessage();

        }
              
              
	}

	public function editProduct() {

        try {

        	// $stmt = $this->conn->runQuery("SELECT productcategory_name
        	// 									FROM productcategories_tbl
        	// 										WHERE productcategory_id=:catid
        	// 											LIMIT 1");
        	// $stmt->execute(array(":catid"=>$categoryname));
        	// $row = $stmt->fetch(PDO::FETCH_ASSOC);

        	// $categoryname = $row['productcategory_name'];

			$stmt1 = $this->conn->runQuery("UPDATE products_tbl
												SET productcategory_id=:catid, product_name=:prodname, product_price=:prodprice
													WHERE product_id=:prodid");

			$stmt1->bindparam(":prodname", $this->productname);
			$stmt1->bindparam(":prodprice", $this->productprice);
			$stmt1->bindparam(":prodid", $this->product_id);
		    $stmt1->bindparam(":catid", $this->categoryname);

		    $stmt1->execute();

		    return $stmt1;

        } catch (Exception $e) {

              echo $e->getMessage();

        }
              
              
	}

	public function getProductList() {

		try {

			$stmt = $this->conn->runQuery("SELECT products_tbl.product_id,
											products_tbl.product_name,
											products_tbl.product_price,
											products_tbl.product_status,
											productcategories_tbl.productcategory_name
											FROM products_tbl
												LEFT JOIN productcategories_tbl
												ON products_tbl.productcategory_id = productcategories_tbl.productcategory_id
										");

			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$product_id = $row['product_id'];
				$categoryname = $row['productcategory_name'];
				$productname = $row['product_name'];
				$productprice = $row['product_price'];
				$product_status = $row['product_status'];

				?>
					<tr>
						<td><?php echo $product_id; ?></td>
						<td><?php echo substr($categoryname, 0, 10); ?></td>
						<td>
							<a href="./manage.products.php?productid=<?php echo $product_id; ?>&status=<?php echo $product_status; ?>" class="btn-link">
								<?php echo substr($productname, 0, 18); ?>
							</a>
						</td>
						<td><?php echo $productprice; ?></td>
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
			$stmt = $this->conn->runQuery("SELECT * FROM products_tbl
											WHERE product_status=:status");
			$stmt->execute(array(":status"=>$status));

				?>
				<option value="" disabled selected>Select a product name.</option>
	        	<?php

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$productname = $row['product_name'];
				$product_id = $row['product_id'];

				?>
					<option value="<?php echo $product_id; ?>">
						<?php echo $productname; ?>
					</option>
				<?php


			}
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	private $currentValue = null;

	public function oldProductValue($list) {

		$this->currentValue = $list;

		try {

			$stmt = $this->conn->runQuery("SELECT *
											FROM products_tbl
												WHERE product_id=:prodid
												LIMIT 1");
			$stmt->execute(array(":prodid"=>$this->currentValue));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$product_name = $row['product_name'];
			$product_price = $row['product_price'];
			$productcategory_id = $row['productcategory_id'];

			?>
				<div class="form-group">
	                <label class="form-control-label" for="categoryname_selected" id="categoryname_selected_label">Category name</label>
	                <select class="form-control" name="categoryname_selected" id="categoryname_selected">
	                  <?php
	                  	$status = "Active";
	                  	$stmt1 = $this->conn->runQuery("SELECT * FROM productcategories_tbl WHERE productcategory_status=:status");
	                  	$stmt1->execute(array(":status"=>$status));
	                  	
	                  	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
	                  	{
	                  		$productcategory_id2 = $row1['productcategory_id'];
	                  		$productcategory_name = $row1['productcategory_name'];
	                  		?>
	                  		<option value="<?php echo $productcategory_id2; ?>"
	                  			<?php
	                  				if ($productcategory_id == $row1['productcategory_id'])
	                  				{
	                  					?>
										selected
	                  					<?php
	                  				}
	                  			?>
	                  		>
	                  			<?php echo $productcategory_name; ?>	
	                  		</option>
	                  		<?php
	                  	}

	                  ?>
	                </select>
	            </div>
	            <div class="form-group">
	                <label class="form-control-label" for="newprodname" id="newprodnamelabel">New product name</label>
	                <input class="form-control" type="text" id="newprodname" name="newprodname" value="<?php echo $product_name; ?>"/>
	            </div>
	            <div class="form-group">
	                <label class="form-control-label" for="newprodprice" id="newprodpricelabel">New price</label>
	                <input class="form-control" type="text" id="newprodprice" name="newprodprice" value="<?php echo $product_price; ?>"/>
	            </div>
			<?php
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function archiveProduct($product_id) {

		try {

			$status = 'Archived';
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

}

?>

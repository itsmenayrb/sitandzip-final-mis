<?php

require_once '../../classes/Config.php';

class ManageInventory extends Config {

	protected $conn;
	public $expenses = 0;

	public function __construct() {

		$this->conn = new Config();

	}

	public function displayExpenses($startDate, $endDate) {

		try {

			$status = 'Verified';
			$stmt = $this->conn->runQuery("SELECT item_total
											FROM expenses_tbl
												WHERE expenses_status=:status
												AND item_datepurchased
													BETWEEN :startdate AND :enddate");
			$stmt->execute(array(":startdate" => $startDate, ":enddate" => $endDate, ":status" => $status));

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$expenses = $row['item_total'];
				$this->expenses+=$expenses;

			}

			$this->expenses = number_format($this->expenses, 2);
			echo json_encode($this->expenses);
			
		} catch (PDOException $e) {
			
			echo $e->getMessage();

		}

	}

	public function saveItem($employee_id, $item_name, $description, $qty, $date_purchased) {


		try {

			$date_purchased = DateTime::createFromFormat('m/d/Y', $date_purchased);
			$date_purchased = $date_purchased->format('Y-m-d');

			$stmt1 = $this->conn->runQuery("SELECT inventory_tbl.item_name,
												expenses_tbl.item_datepurchased
												FROM inventory_tbl INNER JOIN expenses_tbl
													ON inventory_tbl.item_id = expenses_tbl.expenses_id
														WHERE inventory_tbl.item_name=:item
														AND expenses_tbl.item_datepurchased=:date_purchased");

			$stmt1->execute(array(':item'=>$item_name, ':date_purchased' => $date_purchased));
			$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

			if ($row1['item_name'] == $item_name && $row1['item_datepurchased']) {

				echo json_encode(array('error' => 'The item that you want to add with the same date is already exist. Update the item instead.'));

			} else {

				$status = "On stock";
				$stmt2 = $this->conn->runQuery("INSERT INTO inventory_tbl (
											employee_id,
											item_name,
											item_description,
											item_quantity,
											item_status
											) VALUES (
												:empid,
												:item_name,
												:item_description,
												:item_quantity,
												:status
											)
										");

				$stmt2->bindparam(":empid", $employee_id);
				$stmt2->bindparam(":item_name", $item_name);
				$stmt2->bindparam(":item_description", $description);
				$stmt2->bindparam(":item_quantity", $qty);
			    $stmt2->bindparam(":status", $status);

			    $stmt2->execute();

			    return $stmt2;

			}


        } catch (PDOException $e) {

              echo $e->getMessage();

        }


	}

	public function saveExpenses($employee_id, $price, $qty, $date_purchased) {

		try {

			$date_purchased = DateTime::createFromFormat('m/d/Y', $date_purchased);
			$date_purchased = $date_purchased->format('Y-m-d');

			$status = 'Verified';

			$total = $price * $qty;			
		    $stmt3 = $this->conn->runQuery("INSERT INTO expenses_tbl (
										employee_id,
										item_price,
										item_quantity,
										item_total,
										item_datepurchased,
										expenses_status
										) VALUES (
											:empid,
											:item_price,
											:item_quantity,
											:item_total,
											:item_datepurchased,
											:status
										)
									");

			$stmt3->bindparam(":empid", $employee_id);
			$stmt3->bindparam(":item_price", $price);
			$stmt3->bindparam(":item_quantity", $qty);
			$stmt3->bindparam(":item_total", $total);
		    $stmt3->bindparam(":item_datepurchased", $date_purchased);
		    $stmt3->bindparam(":status", $status);

		    $stmt3->execute();

		    return $stmt3;


        } catch (PDOException $e) {

              echo $e->getMessage();

        }

	}

	public function showItemToUpdate($item_id) {

		try {

          $stmt = $this->conn->runQuery("SELECT * FROM inventory_tbl
          									INNER JOIN expenses_tbl
          									ON inventory_tbl.item_id = expenses_tbl.expenses_id
          										WHERE inventory_tbl.item_id=:item_id LIMIT 1");

          $stmt->execute(array(':item_id' => $item_id));

          if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
            
            $item_id = $row['item_id'];
            $item_name = $row['item_name'];
            $item_description = $row['item_description'];
            $item_quantity = $row['item_quantity'];
            $item_price = $row['item_price'];
            $total = $row['item_total'];
            $item_datepurchased = $row['item_datepurchased'];
            $item_dateupdated = $row['item_dateupdated'];
            $item_status = $row['item_status'];

            $item_datepurchased = DateTime::createFromFormat('Y-m-d', $item_datepurchased);
			$item_datepurchased = $item_datepurchased->format('m/d/Y');

            ?>
            <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="form-control-label" for="current_itemname">Item name</label>
                    <input type="text" name="current_itemname" id="current_itemname" class="form-control" placeholder="Item name" value="<?= $item_name; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label" for="current_item_quantity">Quantity</label>
                    <input type="number" name="current_item_quantity" id="current_item_quantity" class="form-control" value="<?= $item_quantity; ?>" min="0">
                  </div>
                </div>

            </div>
            <div class="form-group">
                <label class="form-control-label" for="current_itemprice">Item price</label>
                <input type="text" name="current_itemprice" id="current_itemprice" class="form-control" placeholder="Item price per kilo/piece/can" value="<?= $item_price; ?>">
            </div>
            <div class="form-group">   
                <label class="form-control-label" for="date_purchased">Date of purchase</label>
                <div class="input-group date" data-provide="datepicker" data-date-end-date='0d'>
                    <div class="input-group-addon input-group-prepend">
                        <span class="nc-icon nc-calendar-60 input-group-text"></span>
                    </div>
                    <input type="text" class="form-control" id="current_date_purchased" value="<?= $item_datepurchased; ?>">
                </div>
            </div>
	        <div class="form-group">
	            <label class="form-control-label" for="current_item_description">Description</label>
	            <textarea name="current_item_description" id="current_item_description" class="form-control" cols="30" rows="3" placeholder="Example: 3 packs of 1/2 kilo of spaghetti."><?= $item_description; ?></textarea>
	        </div>
            
            <?php
          }
          
        } catch (PDOException $e) {
          echo $e->getMessage();
        }

	}

	public function updateItem($item_id, $employee_id, $item_name, $description, $qty) {


		try {

			$status = "On stock";

			if ($qty == 0) {
				$status = 'Out of Stock';
			}

			$dateUpdated = date('Y-m-d');

			$stmt = $this->conn->runQuery("UPDATE inventory_tbl SET 
										employee_id=:empid,
										item_name=:item_name,
										item_description=:item_description,
										item_quantity=:item_quantity,
										item_status=:status,
										item_dateupdated=:item_dateupdated
											WHERE item_id=:item_id 
									");

			$stmt->bindparam(":item_id", $item_id);
			$stmt->bindparam(":empid", $employee_id);
			$stmt->bindparam(":item_name", $item_name);
			$stmt->bindparam(":item_description", $description);
			$stmt->bindparam(":item_quantity", $qty);
		    $stmt->bindparam(":status", $status);
			$stmt->bindparam(":item_dateupdated", $dateUpdated);

		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }


	}

	public function updateExpenses($item_id, $employee_id, $qty, $price, $date_purchased) {


		try {

			$date_purchased = DateTime::createFromFormat('m/d/Y', $date_purchased);
			$date_purchased = $date_purchased->format('Y-m-d');

			$total = $price * $qty;

			$stmt = $this->conn->runQuery("UPDATE expenses_tbl SET 
										employee_id=:empid,
										item_price=:item_price,
										item_total=:item_total,
										item_quantity=:item_quantity,
										item_datepurchased=:item_datepurchased
											WHERE expenses_id=:expenses_id 
									");

			$stmt->bindparam(":expenses_id", $item_id);
			$stmt->bindparam(":empid", $employee_id);
			$stmt->bindparam(":item_price", $price);
			$stmt->bindparam(":item_total", $total);
			$stmt->bindparam(":item_quantity", $qty);
			$stmt->bindparam(":item_datepurchased", $date_purchased);

		    $stmt->execute();

		    return $stmt;

        } catch (PDOException $e) {

              echo $e->getMessage();

        }


	}

	public function archiveItem($item_id) {

		try {

			$status = 'Void';
			$dateUpdated = date('Y-m-d');

			$stmt = $this->conn->runQuery("UPDATE inventory_tbl
											SET item_status=:status, item_dateupdated=:date_updated
												WHERE item_id=:item_id");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":date_updated", $dateUpdated);
			$stmt->bindparam(":item_id", $item_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function archiveExpenses($item_id) {

		try {

			$status = 'Void';
			$stmt = $this->conn->runQuery("UPDATE expenses_tbl
											SET expenses_status=:status
												WHERE expenses_id=:expenses_id");
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":expenses_id", $item_id);

			$stmt->execute();

			return $stmt;
			
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

	public function getDetailsOfSelectedItem($item_id) {

		try {
			
            $stmt = $this->conn->runQuery("SELECT item_quantity FROM inventory_tbl WHERE item_id=:item_id");
            $stmt->execute(array(":item_id" => $item_id));

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $item_quantity = $row['item_quantity'];
            }

            echo json_encode($item_quantity, JSON_NUMERIC_CHECK);

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getItemFromDb($item_id, $item_quantity) {
		try {
			
            $stmt = $this->conn->runQuery("SELECT item_quantity FROM inventory_tbl WHERE item_id=:item_id LIMIT 1");
            $stmt->execute(array(":item_id" => $item_id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($item_quantity > $row['item_quantity']) {
            	echo json_encode(array('error' => 'Insufficient stocks'));
            } else {
            	$item_quantity = $row['item_quantity'] - $item_quantity;
            	$dateUpdated = date('Y-m-d');

            	if ($item_quantity == 0) {
            		$status = "Out of stock";
            		$stmt2 = $this->conn->runQuery("UPDATE inventory_tbl SET item_quantity=:item_quantity, item_status=:status, item_dateupdated=:date_updated WHERE item_id=:item_id");

	            	$stmt2->bindparam(':item_id', $item_id);
	            	$stmt2->bindparam(':item_quantity', $item_quantity);
	            	$stmt2->bindparam(':status', $status);
	            	$stmt2->bindparam(':date_updated', $dateUpdated);

	            	$stmt2->execute();
	            	return $stmt2;
            	} else {
	            	$stmt1 = $this->conn->runQuery("UPDATE inventory_tbl SET item_quantity=:item_quantity, item_dateupdated=:date_updated WHERE item_id=:item_id");

	            	$stmt1->bindparam(':item_id', $item_id);
	            	$stmt1->bindparam(':item_quantity', $item_quantity);
	            	$stmt1->bindparam(':date_updated', $dateUpdated);

	            	$stmt1->execute();
	            	return $stmt1;
            	}
            }

		} catch (PDOException $e) {
			echo $e->getMessage();
		}	
	}

}
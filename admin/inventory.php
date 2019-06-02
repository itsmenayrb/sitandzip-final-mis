<?php

  session_start();
  require_once '../classes/Config.php';
  $config = new Config();

  if (!isset($_SESSION['employee_position']) || !isset($_SESSION['employee_username']) || !isset($_SESSION['employee_id'])) {
    $config->redirect('./index.php');
  }

  // echo $_SESSION['employee_username'];

  $GLOBALS['current_session'] = $_SESSION['employee_username'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />   
    <title>Sit & Zip | Inventory</title>

    <?php include './includes/libraries.php'; ?>
    <script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="admin-style.css">

  </head>
  <body class="">
    
    <div class="wrapper">

      <?php include './includes/sidebar.php'; ?>

      <div class="main-panel">
    
        <?php include './includes/navigation.php'; ?>
          
        <div class="content">

          <div class="legend">
            <legend>Critical Level: 
              <i class="fa fa-circle text-warning"></i> Items with < 10
              <i class="fa fa-circle text-danger"></i> Items with < 5
            </legend>
          </div>
          <div class="row">
            <div class="col-md-12 flex-grow">
              <?php
              $stmt = $config->runQuery("SELECT * FROM inventory_tbl ORDER BY item_quantity");
              $stmt->execute();
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $quantity = $row['item_quantity'];
                $item_name = $row['item_name'];

                if ($quantity > 5 && $quantity < 10) {
                  ?>
                  <div class="card col-md-3 card-stats text-white bg-warning mb-3 mr-2">
                    <div class="card-body">
                      <h5 class="card-title"><?= $item_name ?></h5>
                      <p class="card-text p-2">Remaining Quantity: <?= $quantity; ?></p>
                    </div>
                  </div>
                  <?php
                } else if ($quantity < 5) {
                  ?>
                  <div class="card col-md-3 card-stats text-white bg-danger mb-3 mr-2">
                    <div class="card-body">
                      <h5 class="card-title"><?= $item_name ?></h5>
                      <p class="card-text p-2">Remaining Quantity: <?= $quantity; ?></p>
                    </div>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8">
              <div class="card card-stats">
                <div class="card-body ">
                  <table class="table display nowrap" id="inventory-table-outofstock" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                      try {

                        $status = 'Out of Stock';
                        $stmt = $config->runQuery("SELECT * FROM inventory_tbl WHERE item_status=:status GROUP BY item_name");
                        $stmt->execute(array(':status' => $status));

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          $item_id = $row['item_id'];
                          $item_name = $row['item_name'];
                          $item_description = $row['item_description'];
                          $item_status = $row['item_status'];

                          ?>
                            <tr>
                              <td><?= $item_name; ?></td>
                              <td><?= $item_description; ?></td>
                              <td><span id="status"><?= $item_status; ?></span></td>
                            </tr>
                          <?php
                        }
                        
                      } catch (PDOException $e) {
                        echo $e->getMessage();
                      }

                    ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer ">
                  <hr>
                  <div class="legend">
                    <i class="fa fa-circle text-warning"></i> Out of stock
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
              <div class="flex-grow">
                <button class="btn btn-danger" id="getItemBtn" data-toggle="modal" data-target="#getItemModal">Get item</button>
                <button class="btn btn-primary" id="addItemBtn" data-toggle="modal" data-target="#addItemModal">Add Item</button>
                <button class="btn btn-warning" id="viewAllItemBtn" data-toggle="modal" data-target="#viewAllItemModal">View All</button>
              </div>
              <div id="reportrange" class="text-center card mb-4">
                  <i class="fa fa-calendar">
                    <span></span>
                    <i class="fa fa-caret-down"></i>
                  </i>
              </div>
              <div class="card card-stats">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-5 col-md-4">
                      <div class="icon-big text-center icon-warning">
                        <i class="nc-icon nc-money-coins text-success"></i>
                      </div>
                    </div>
                    <div class="col-7 col-md-8">
                      <div class="numbers">
                        <p class="card-category">Expenses</p>
                        <p class="card-title" id="totalExpenses">
                          <p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ">
                  <hr>
                  <div class="stats">
                    <i class="fa fa-calendar-o"></i> Total Expenses
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="card card-stats">
            <div class="card-body">
              <table class="table display nowrap" id="inventory-table" style="width: 100%">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    try {

                      $status = 'On stock';
                      $stmt = $config->runQuery("SELECT *, SUM(item_quantity) as sum_quantity FROM inventory_tbl WHERE item_status=:status GROUP BY item_name");
                      $stmt->execute(array(':status' => $status));

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                      {
                        $item_id = $row['item_id'];
                        $item_name = $row['item_name'];
                        $item_description = $row['item_description'];
                        $item_quantity = $row['sum_quantity'];
                        $item_status = $row['item_status'];


                        ?>
                          <tr>
                            <td><?= $item_name; ?></td>
                            <td><?= $item_description; ?></td>
                            <td><?= $item_quantity; ?></td>
                            <td><span id="status"><?= $item_status; ?></span></td>
                            
                          </tr>
                        <?php
                      }
                      
                    } catch (PDOException $e) {
                      echo $e->getMessage();
                    }

                  ?>
                </tbody>
              </table>
            </div>
            <hr>
            <div class="card-footer">
              <div class="legend">
                  <i class="fa fa-circle text-primary"></i> On stock
                </div>
            </div>
          </div>
          
        </div>

        <?php include './includes/footer.php'; ?>

      </div>

    </div>

    <div class="modal" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="hiddenGetEmployeeId" id="hiddenGetEmployeeId" value="<?php echo $_SESSION['employee_id']; ?>">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <span id="error" class="text-warning form-text text-muted"></span>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="form-control-label" for="itemname">Item name</label>
                    <input type="text" name="itemname" id="itemname" class="form-control" placeholder="Item name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label" for="item_quantity">Quantity</label>
                    <input type="number" name="item_quantity" id="item_quantity" class="form-control" value="1" min="1">
                  </div>
                </div>

              </div>
              <div class="form-group">
                <label class="form-control-label" for="itemprice">Item price</label>
                <input type="text" name="itemprice" id="itemprice" class="form-control" placeholder="Item price per kilo/piece/can">
              </div>
              <div class="form-group">
                
                <label class="form-control-label" for="date_purchased">Date of purchased</label>
                <div class="input-group date" data-provide="datepicker" data-date-end-date='0d'>
                    <div class="input-group-addon input-group-prepend">
                        <span class="nc-icon nc-calendar-60 input-group-text"></span>
                    </div>
                    <input type="text" class="form-control" id="date_purchased">
                </div>
              </div>
              <div class="form-group">
                <label class="form-control-label" for="item_description">Description</label>
                <textarea name="item_description" id="item_description" class="form-control" cols="30" rows="3" placeholder="Example: 3 packs of 1/2 kilo of spaghetti."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="inventoryBtn">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal" id="getItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="hiddenGetEmployeeId" id="hiddenGetEmployeeId" value="<?php echo $_SESSION['employee_id']; ?>">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel3">Get Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label class="form-control-label" for="displayItemSelect">Item name</label>
                <select id="displayItemSelect" class="form-control">
                  <option value="" selected disabled>Select an item.</option>
                  <?php
                    $status = "On stock";
                    $stmt = $config->runQuery("SELECT item_name, item_id, item_datepurchased FROM inventory_tbl INNER JOIN expenses_tbl ON inventory_tbl.item_id = expenses_tbl.expenses_id WHERE item_status=:status");
                    $stmt->execute(array(":status" => $status));
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      $item_id = $row['item_id'];
                      $item_name = $row['item_name'];
                      $item_datepurchased = $row['item_datepurchased'];

                      $item_datepurchased = strtotime($item_datepurchased);
                      $item_datepurchased = date('F jS Y', $item_datepurchased);
                      ?>
                        <option value="<?= $item_id; ?>"><?= $item_name; ?> - bought on  <?= $item_datepurchased; ?></option>
                      <?php
                    }

                  ?>
                </select>
              </div>
              <div class="form-group">
                
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="getInventoryItemBtn">Get</button>
            </div> -->
          </form>
        </div>
      </div>
    </div>

    <div class="modal" id="getItemQuantityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="hiddenGetEmployeeId" id="hiddenGetEmployeeId" value="<?php echo $_SESSION['employee_id']; ?>">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel4"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="hiddenGetItemId" value="">
              <label class="form-control-label" for="getItemQuantityInput">How many you will get?</label>
              <div class="form-group">
                <input type="number" id="getItemQuantityInput" class="form-control" autofocus="true" value="1" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="getItemQuantityBtn">Get</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal" id="viewAllItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">View All</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table display nowrap" id="detailed-inventory-table" style="width: 100%">
                <thead class="text-center">
                  <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Date Purchased</th>
                    <th>Date Updated</th>
                    <th>Status</th>
                    <th><i class="nc-icon nc-settings-gear-65"></i></th>                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                    try {

                      $stmt = $config->runQuery("SELECT * FROM inventory_tbl
                                                  INNER JOIN expenses_tbl
                                                    ON inventory_tbl.item_id = expenses_tbl.expenses_id
                                                      ORDER BY expenses_tbl.item_datepurchased DESC");
                      $stmt->execute();

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
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

                        $item_datepurchased = strtotime($item_datepurchased);
                        $item_datepurchased = date('F jS Y', $item_datepurchased);

                        // if($item_dateupdated === '000-00-00') {
                        //   $item_dateupdated = "";
                        // } else {
                        //   $item_dateupdated = strtotime($item_dateupdated);
                        //   $item_dateupdated = date('F jS Y', $item_dateupdated);

                        // }

                        ?>
                          <tr>
                            <td><?= $item_name; ?></td>
                            <td><?= $item_description; ?></td>
                            <td><?= $item_quantity; ?></td>
                            <td><?= $item_price; ?></td>
                            <td><?= $total; ?></td>
                            <td><?= $item_datepurchased; ?></td>
                            <td><?= $item_dateupdated; ?></td>
                            <td><?= $item_status; ?></td>
                            <td>
                              <?php

                                if ($item_status <> 'Void')
                                {

                                  ?>
                                  <button type="button" class="btn btn-success itemUpdateBtn" title="Update" data-id="<?= $item_id; ?>" data-target='#updateThisItemModal' data-toggle='modal'>
                                    <i class="nc-icon nc-spaceship"></i>
                                  </button>
                                  <?php
                                  if ($item_status <> 'Out of stock')
                                  {
                                    ?>
                                    <button type="button" class="btn btn-danger itemArchiveBtn" title='Archive' data-id="<?= $item_id; ?>">
                                      <i class="nc-icon nc-simple-remove"></i>
                                    </button>
                                    <?php
                                  }
                                }
                              ?>
                          </tr>
                        <?php
                      }
                      
                    } catch (PDOException $e) {
                      echo $e->getMessage();
                    }
                  ?>
                </tbody>
                <tr>
                  <td colspan="9">Total Expenses: </td>
                </tr>
              </table>
            </div>
        </div>
      </div>
    </div>

    <div class="modal" id="updateThisItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="hiddenGetEmployeeId" id="hiddenGetEmployeeId" value="<?php echo $_SESSION['employee_id']; ?>">
            <input type="hidden" id="hiddenItemId" value="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel2">Update Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <span id="error-update" class="text-warning form-text text-muted"></span>
              <div id="item-to-update-container">
                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary saveUpdateItemBtn">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include './includes/scripts.php'; ?>
    <script type="text/javascript" src="./jsfunctions/inventory.js"></script>
    <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
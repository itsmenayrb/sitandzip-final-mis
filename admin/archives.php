<?php

  session_start();
  require_once '../classes/Config.php';
  $config = new Config();

  if (!isset($_SESSION['employee_position']) || !isset($_SESSION['employee_username']) || !isset($_SESSION['employee_id'])) {
    $config->redirect('./index.php');
  }

  if ($_SESSION['employee_position'] != 'Admin') {
    $config->redirect('./403.php');
  }

  $GLOBALS['current_session'] = $_SESSION['employee_username'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />  
    <title>Sit & Zip | Archives</title>

    <?php include 'includes/libraries.php'; ?>
    <script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
  
  </head>
  <body>

  <div class="wrapper">

      <?php include './includes/sidebar.php'; ?>
      <div class="main-panel">
        
        <?php include './includes/navigation.php'; ?>
        <div class="content">

          <div class="row">
            <div class="col-md-12">
              <div class="card card-stats">
                <div class="card-header">
                  <h5 class="card-title">Category</h5>
                </div>
                <div class="card-body">
                  <table id="categoriesArchivedTable" class="table display nowrap">
                    <thead>
                    <tr>
                      <th>Category Name</th>
                      <th>Category Status</th>
                      <th>Restore</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $status = "Archived";
                      $stmt = $config->runQuery("SELECT * FROM productcategories_tbl
                                      WHERE productcategory_status=:status");
                      $stmt->execute(array(":status"=>$status));

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                      {
                        $category_name = $row['productcategory_name'];
                        $status = $row['productcategory_status'];
                        $category_id = $row['productcategory_id'];

                        ?>
                          <tr>
                            <td><?php echo $category_name; ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                              <button type="button" class="btn btn-success restoreThisCategory" role="button" data-id="<?php echo $category_id; ?>" data-name="<?php echo $category_name; ?>"><i class="nc-icon nc-refresh-69"></i> Restore</button>
                            </td>
                          </tr>
                        <?php

                      }

                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title">Product</h5>
                </div>
                <div class="card-body">
                  <table id="productArchivedTable" class="table display nowrap">
                    <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Product Price</th>
                      <th>Product Status</th>
                      <th>Restore</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $status = "Archived";
                      $stmt = $config->runQuery("SELECT * FROM products_tbl WHERE product_status=:status");
                      $stmt->execute(array(":status"=>$status));

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                      {
                        $product_id = $row['product_id'];
                        $product_name = $row['product_name'];
                        $product_price = $row['product_price'];
                        $product_status = $row['product_status'];
                        ?>
                        <tr>
                          <td><?php echo $product_name; ?></td>
                          <td><?php echo $product_price; ?></td>
                          <td><?php echo $product_status; ?></td>
                          <td>
                            <button type="button" class="btn btn-success restoreThisProduct" role="button" data-id="<?php echo $product_id; ?>" data-name="<?php echo $product_name ?>"><i class="nc-icon nc-refresh-69"></i> Restore</a>
                          </td>
                        </tr>
                        <?php
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title">Item</h5>
                </div>
                <div class="card-body">
                  <table id="itemArchivedTable" class="table display nowrap">
                    <thead>
                    <tr>
                      <th>Item name</th>
                      <th>Item quantity</th>
                      <th>Item Status</th>
                      <th>Restore</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $status = "Void";
                      $stmt = $config->runQuery("SELECT * FROM inventory_tbl WHERE item_status=:status");
                      $stmt->execute(array(":status"=>$status));

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                      {
                        $item_id = $row['item_id'];
                        $item_name = $row['item_name'];
                        $item_quantity = $row['item_quantity'];
                        $status = $row['item_status'];
                        ?>
                        <tr>
                          <td><?= $item_name; ?></td>
                          <td><?= $item_quantity; ?></td>
                          <td><?= $status; ?></td>
                          <td>
                            <button type="button" class="btn btn-success restoreThisItem" role="button" data-id="<?php echo $item_id; ?>" data-name="<?php echo $item_name ?>"><i class="nc-icon nc-refresh-69"></i> Restore</a>
                          </td>
                        </tr>
                        <?php
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title">User</h5>
                </div>
                <div class="card-body">
                  <table id="userArchivedTable" class="table display nowrap">
                    <thead>
                    <tr>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Restore</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $status = "Deactivated";
                      $stmt = $config->runQuery("SELECT * FROM employeesaccount_tbl WHERE employee_status=:status");
                      $stmt->execute(array(":status"=>$status));

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                      {
                        $employee_id = $row['employee_id'];
                        $employee_username = $row['employee_username'];
                        $employee_email = $row['employee_email'];
                        $status = $row['employee_status'];
                        ?>
                        <tr>
                          <td><?= $employee_username; ?></td>
                          <td><?= $employee_email; ?></td>
                          <td><?= $status; ?></td>
                          <td>
                            <button type="button" class="btn btn-success restoreThisAccount" role="button" data-id="<?php echo $employee_id; ?>" data-name="<?php echo $employee_username ?>"><i class="nc-icon nc-refresh-69"></i> Restore</a>
                          </td>
                        </tr>
                        <?php
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>


      <?php include './includes/footer.php'; ?>
      </div>

  </div>

  <?php include './includes/scripts.php'; ?>
  <script type="text/javascript" src="./jsfunctions/archives.js"></script>
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
<?php

  session_start();
  require_once '../classes/Config.php';
  $config = new Config();

  $transact_by = $_SESSION['employee_username'];

  if ($config->is_loggedin() == "") {
    $config->redirect('./index.php');
  }

  if ($config->is_loggedin() == "") {
    $config->redirect('./index.php');
  }

  $GLOBALS['current_session'] = $_SESSION['employee_username'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />  
    <title>Sit & Zip | Orders</title>

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

          <div class="row row-flex row-flex-wrap">

            <?php

              $status = 'Pending';
              $stmt = $config->runQuery("SELECT order_transactionid FROM orders_tbl WHERE order_status=:status GROUP BY order_transactionid");
              $stmt->execute(array(":status"=>$status));
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
              {
                $transaction_id = $row['order_transactionid'];

                ?>
                <div class="col-md-3">
                  <div class="card card-stats flex-col">
                    <div class="card-header">
                      <div class="card-title"><?php echo $transaction_id; ?></div>
                    </div>
                    <hr>
                    <div class="card-body flex-grow">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Product</th>
                            <th>Qty</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $stmt1 = $config->runQuery("SELECT order_productname, order_quantity FROM orders_tbl WHERE order_transactionid=:transaction_id");

                            $stmt1->execute(array(":transaction_id"=>$transaction_id));

                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
                            {
                              $product_name = $row1['order_productname'];
                              $quantity = $row1['order_quantity'];
                              ?>
                                <tr>
                                  <td><?php echo $product_name; ?></td>
                                  <td><?php echo $quantity; ?></td>
                                </tr>
                              <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                      <button type="button" role="button" class="btn btn-primary btn-block processOrderBtn" data-id="<?php echo $transaction_id; ?>" data-name="<?php echo $transact_by; ?>">Processed</button>
                    </div>
                  </div>
                </div>
                <?php
              }
            ?>
          </div>

        </div>

        <?php include './includes/footer.php'; ?>
      </div>

  </div>

  <?php include './includes/scripts.php'; ?>
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  <script type="text/javascript" src="./jsfunctions/manage.orders.js"></script>
  </body>
</html>
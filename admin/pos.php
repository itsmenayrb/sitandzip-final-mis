<?php

  session_start();
  require_once '../classes/Config.php';
  $config = new Config();
  $transact_by = $_SESSION['employee_username'];
  $transaction_id = $config->generateTransactId();
  $_SESSION['transaction-id'] = $transaction_id;

  if (!isset($_SESSION['employee_username']) || !isset($_SESSION['employee_position']) || !isset($_SESSION['employee_id'])) {
    $config->redirect('./index.php');
  }

  $GLOBALS['current_session'] = $_SESSION['employee_username'];

  $status = "Active";
  $stmt = $config->runQuery("SELECT * FROM products_tbl WHERE product_status=:status");

  $stmt->execute(array(":status"=>$status));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />  
    <title>Sit & Zip | Point of Sale</title>

    <?php include './includes/libraries.php'; ?>
    <script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="admin-style.css">
  
  </head>
  <body>

    <div class="wrapper">

      <?php include './includes/sidebar.php'; ?>
      <div class="main-panel">
        
        <?php include './includes/navigation.php'; ?>
        <div class="content">
          
          <div class="container" id="before-button-container">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-8 mb-xs-4 mb-sm-4">
                <div id="button-container">
                  <ul>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                      $product_id = $row['product_id'];
                      $product_name = $row['product_name'];
                      $product_price = $row['product_price'];

                      ?>
                      <li id="<?php echo $product_id; ?>">
                        <button type="button" class="mu-readmore-btn pos-btn" id='thisPrice' data-name="<?php echo $product_name; ?>" data-price="<?php echo $product_price; ?>">
                            <?php $product_name = wordwrap($product_name, 9, "<br/>\n"); echo $product_name; ?>
                        </button>
                      </li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4"> 
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="transaction-form">
                  <label>Transaction id: <span id="transaction-id-span"><?php echo $transaction_id; ?></span><br>
                  <span>Transact by: <?php echo $transact_by; ?></span></label>
                  <input type="hidden" value="<?php echo $transaction_id; ?>" id="hiddenTransactionId"/>
                  <input type="hidden" value="<?php echo $transact_by; ?>" id="hiddenTransactBy"/>
                  <table class="table table-sm" id="transaction-table">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th style="width: 50px">Qty</th>
                        <th style="width: 90px">Price</th>
                        <!-- <th style="width: 120px">Sub-Total</th> -->
                        <th style="width: 40px; text-align: center;">X</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                  <div class="well">
                    <table class="table" id="amount-holder-table">
                      <tr>
                        <th style="width: 60%">Total Amount:</th>
                        <th><input type="text" id="totalAmount" value="0.00" readonly/><input type="hidden" id="totalAmounthidden" name='totalAmount'></th>
                      </tr>
                      <tr>
                        <th>Payment: </th>
                        <th><input type="text" id="customerPayment" value="0.00" readonly/><input type="hidden" id="customerPaymenthidden" value="0.00" name="customerPayment"/></th>
                      </tr>
                      <tr>
                        <th>Change: </th>
                        <th><input type="text" id="customerChange" value="0.00" readonly/><input type="hidden" id="customerChangehidden" value="0.00" name="customerChange" readonly/></th>
                      </tr>
                    </table>

                  </div>
                  <div class="well">
                    <div class="row">
                      <div class="col-md-12">
                        <button type="button" class="finalize-sale-btn btn btn-warning btn-block" disabled="disabled">Finalize Order</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
        <?php include './includes/footer.php'; ?>
      </div>

    </div>
  <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myPayment">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myPayment">Payment</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="paymentInput" placeholder="Payment here." autofocus="true" required />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="getPaymentBtn" data-dismiss="modal">Enter</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="mySummary">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="mySummary">Summary</h4>
        </div>
        <div class="modal-body">
          <table class="table">
            <tr>
              <th>Total amount: </th>
              <th><span id="totalAmountSpan"></span></th>
            </tr>
            <tr>
              <th>Payment: </th>
              <th><span id="paymentSpan"></span></th>
            </tr>
            <tr>
              <th>Change: </th>
              <th><span id="changeSpan"></span></th>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="summaryBtn">OK</button>
        </div>
      </div>
    </div>
  </div>

  <?php include './includes/scripts.php'; ?>
  <script type="text/javascript" src="./jsfunctions/pos.js"></script>
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
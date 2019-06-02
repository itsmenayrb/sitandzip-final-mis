<?php

  session_start();
  require_once '../classes/Config.php';
  $config = new Config();

  if ($config->is_loggedin() == "") {
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
    <title>Sit & Zip | Sales</title>

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

          <div id="reportrange" class="text-center card mb-4">
              <i class="fa fa-calendar">
                <span></span>
                <i class="fa fa-caret-down"></i>
              </i>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-stats">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-1 col-md-1">
                      <div class="icon-big text-center icon-warning">
                        <i class="nc-icon nc-money-coins text-success"></i>
                      </div>
                    </div>
                    <div class="col-11 col-md-11">
                      <div class="numbers">
                        <p class="card-category">Revenue</p>
                        <p class="card-title" id="totalSales">
                          <p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ">
                  <hr>
                  <div class="stats">
                    <i class="fa fa-calendar-o"></i> Total Sales
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title"><i class="nc-icon nc-chart-bar-32"></i></h5>
                </div>
                <div class="card-body">
                  <div class="chart-container">
                    <canvas id="myChart" width="400" height="200"></canvas>
                  </div>
                </div>
                <div class="card-footer">
                  <hr/>
                  <div class="chart-legend">
                    <i class="fa fa-circle text-info"></i> Line
                    <i class="fa fa-circle text-warning"></i> Bar
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title"><i class="nc-icon nc-chart-bar-32"></i></h5>
                </div>
                <div class="card-body">
                  <table class="table display nowrap" id="sales-table">
                    <thead>
                      <tr>
                        <th>Transaction Id</th>
                        <th>Total Amount</th>
                        <th>Customer's Payment</th>
                        <th>Customer's Change</th>
                        <th>Transacted by</th>
                        <th>Transaction date</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Transaction Id</th>
                        <th>Total Amount</th>
                        <th>Customer's Payment</th>
                        <th>Customer's Change</th>
                        <th>Transacted by</th>
                        <th>Transaction date</th>
                      </tr>
                    </tfoot>
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
  <script type="text/javascript" src="./jsfunctions/sales.js"></script>
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
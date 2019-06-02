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
    <title>Sit & Zip | Dashboard</title>

    <?php include './includes/libraries.php'; ?>
    <link rel="stylesheet" type="text/css" href="admin-style.css">

  </head>
  <body class="">
    
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
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-stats">
                <div class="card-body">
                  <div class="row">
                    <div class="col-5 col-md-4">
                      <div class="icon-big text-center icon-warning">
                        <i class="nc-icon nc-money-coins text-success"></i>
                      </div>
                    </div>
                    <div class="col-7 col-md-8">
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
                    <i class="fa fa-calendar-o"></i> Revenue
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
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
            <div class="col-lg-4 col-md-4 col-sm-12">
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
                        <p class="card-category">Profit</p>
                        <p class="card-title" id="netProfit">
                          <p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ">
                  <hr>
                  <div class="stats">
                    <i class="fa fa-calendar-o"></i> Net Profit
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title">Revenue</h5>
                </div>
                <div class="card-body">
                  <canvas id="myChart" width="400" height="100"></canvas>
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

          <?php
            $dates = "";
            $totalSales = 0;
            $eachRevenue = [];
            $stmt = $config->runQuery("SELECT *, COUNT(*), SUM(sales_totalamount) as sales
                                      FROM sales_tbl
                                      GROUP BY YEAR(sales_date), MONTH(sales_date) LIMIT 12");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

              $sales = (int)$row['sales'];
              $eachRevenue[] = $sales;
              //$totalSales = $sales;

              $date = date('M Y', strtotime($row['sales_date']));
              $dates = $dates . '"' . $date . '", ';
              $totalSales = $totalSales . $sales . ',';
            }


            $status = "Verified";
            $date_expenses = "";
            $totalExpenses = 0;
            $eachExpenses = [];

            $stmt1 = $config->runQuery("SELECT *, COUNT(*), SUM(item_total) as expenses
                                      FROM expenses_tbl WHERE expenses_status=:status
                                      GROUP BY YEAR(item_datepurchased), MONTH(item_datepurchased) LIMIT 12");
            $stmt1->execute(array(":status" => $status));
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
              $expenses = (int)$row1['expenses'];
              $eachExpenses[] = $expenses;
              $date_expense = date('M Y', strtotime($row1['item_datepurchased']));
              $date_expenses = $date_expenses . '"' . $date_expense . '", ';
              $totalExpenses = $totalExpenses . $expenses . ',';
            }

            $totalSales = trim($totalSales, ',');
            $totalSales = ltrim($totalSales, '0');
            $dates = trim($dates, ',');

            $totalExpenses = trim($totalExpenses, ',');
            $totalExpenses = ltrim($totalExpenses, '0');
            $date_expenses = trim($date_expenses, '0');

            $eachProfit = [];
            for ($i = 0; $i < count($eachRevenue); $i++) {
              $eachProfit[] = (int)$eachRevenue[$i] - (int)$eachExpenses[$i];
            }

          ?>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-chart">
                <div class="card-header">
                  <h5 class="card-title">Monthly Report</h5>
                </div>
                <div class="card-body">
                  <canvas id="myMonthly" width="400" height="100"></canvas>
                </div>
                <div class="card-footer">
                  <hr/>
                  <div class="chart-legend">
                    <i class="fa fa-circle text-primary"></i> Profit
                    <i class="fa fa-circle text-danger"></i> Revenue
                    <i class="fa fa-circle text-warning"></i> Expenses
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">
              
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
            <div class="col-md-5">
              <div class="card ">
                <div class="card-header ">
                  <h5 class="card-title">Emails</h5>
                  <p class="card-category">Unread messages</p>
                </div>
                <div class="card-body ">
                  <table class="table display nowrap" id="messages-table-dashboard" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>Message</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $status = 'Unread';
                        $stmt = $config->runQuery("SELECT message_subject, message_body
                                                    FROM messages_tbl WHERE message_status=:status ORDER BY message_date DESC LIMIT 5");
                        $stmt->execute(array(':status' => $status));
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          $subject = $row['message_subject'];
                          $message = $row['message_body'];
                          ?>
                            <tr>
                              <td><?= $subject; ?></td>
                              <td><?= $message; ?></td>
                            </tr>
                          <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer ">
                  <hr>
                  <div class="stats">
                    <i class="fa fa-calendar"></i> Inquiries
                  </div>
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
    <script type="text/javascript">
      var ctx = document.getElementById('myMonthly').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?= $dates; ?>],
        datasets: [{
            label: 'Revenue',
            data: [<?= $totalSales; ?>],
            backgroundColor: 'rgba(0, 0, 0, 0.0)',
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2
        }, {
            label: 'Expenses',
            data: [<?= $totalExpenses; ?>],
            backgroundColor: 'rgba(0, 0, 0, 0.0)',
            borderColor: '#fbc658',
            borderWidth: 2
        }, {
            label: 'Profit',
            data: <?= json_encode($eachProfit); ?>,
            backgroundColor: 'rgba(0, 0, 0, 0.0)',
            borderColor: '#51bcda',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
    </script>
  </body>
</html>
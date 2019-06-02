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
    <title>Sit & Zip | Reservations</title>

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

          <table class="table display nowrap" id="table-reservation" style="width: 100%">
            <thead>
              <tr>
                <th>Full name</th>
                <th>Contact number</th>
                <th>Number of person</th>
                <th>Date</th>
                <th>Time</th>
                <th>Message</th>
                <th>Status</th>
                <th><i class="nc-icon nc-settings-gear-65"></i></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $stmt = $config->runQuery("SELECT * FROM reservations_tbl ORDER BY reservation_date ASC");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $reservation_id = $row['reservation_id'];
                  $fullname = $row['reservation_fullname'];
                  $contact_number = $row['reservation_contactnumber'];
                  $number_of_people = $row['reservation_numberofpeople'];
                  $reservation_date = $row['reservation_date'];
                  $reservation_time = $row['reservation_time'];
                  $reservation_message = $row['reservation_message'];
                  $status = $row['reservation_status'];

                  $reservation_date = strtotime($reservation_date);
                  $reservation_date = date('F jS Y', $reservation_date);
                  ?>
                    <tr>
                      <td><?= $fullname; ?></td>
                      <td><?= $contact_number; ?></td>
                      <td><?= $number_of_people; ?></td>
                      <td><?= $reservation_date; ?></td>
                      <td><?= $reservation_time; ?></td>
                      <td><?= $reservation_message; ?></td>
                      <td><?= $status; ?></td>
                      <td class="text-center">
                        <?php
                          if ($status == 'Pending') {
                            ?>
                              <button class="btn btn-sm btn-success approveReservationBtn" type="button"  data-id="<?= $reservation_id; ?>" data-reservation="<?= $reservation_date; ?>" data-name="<?= $_SESSION['employee_id']; ?>">
                                Approve
                              </button>
                              <button class="btn btn-danger btn-sm rejectReservationBtn" type="button" data-id="<?= $reservation_id; ?>" data-reservation="<?= $reservation_date; ?>" data-name="<?= $_SESSION['employee_id']; ?>">
                                Reject
                              </button>
                            <?php
                          } else if ($status == 'Approved') {
                            ?>
                              <span class="badge badge-pill badge-success"><i class="nc-icon nc-check-2"></i></span>
                            <?php
                          } else if ($status == 'Cancelled' || $status == 'Rejected') {
                            ?>
                              <span class="badge badge-pill badge-danger"><i class="nc-icon nc-simple-remove"></i></span>
                            <?php
                          }
                        ?>
                      </td>
                    </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
        </div>
        <?php include './includes/footer.php'; ?>
      </div>
    </div>
    <?php include './includes/scripts.php'; ?>
    <script type="text/javascript" src="./jsfunctions/reservation.js"></script>
    <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
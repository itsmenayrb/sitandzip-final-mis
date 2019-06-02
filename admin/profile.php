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
    <title>Sit & Zip | Profile</title>

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
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            To reset your password, please contact the administrator.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-user">
                <div class="card-header">
                  <h5 class="card-title">Edit Profile</h5>
                </div>
                <div class="card-body">
                  <form method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                    <?php
                      $employee_id = $_SESSION['employee_id'];
                      $stmt = $config->runQuery("SELECT * FROM employeesaccount_tbl WHERE employee_id=:employee_id");
                      $stmt->execute(array(':employee_id' => $employee_id));
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $username = $row['employee_username'];
                        $email = $row['employee_email'];
                        $contact_number = $row['employee_contactnumber'];
                        $firstname = $row['employee_firstname'];
                        $lastname = $row['employee_lastname'];
                        ?>
                          <div class="row">
                            <input type="hidden" id="hiddenEmployeeId" value="<?= $employee_id; ?>">
                            <div class="col-md-5 pr-1">
                              <div class="form-group">
                                <label>Company (disabled)</label>
                                <input type="text" class="form-control" disabled placeholder="Company" value="Sit & Zip Garden Cafe-Bacoor">
                              </div>
                            </div>
                            <div class="col-md-3 px-1">
                              <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Username" value="<?= $username; ?>" disabled>
                              </div>
                            </div>
                            <div class="col-md-4 pl-1">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" placeholder="Email" value="<?= $email; ?>" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 pr-1">
                              <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" id="firstname" placeholder="First Name" value="<?= $firstname; ?>">
                              </div>
                            </div>
                            <div class="col-md-6 pl-1">
                              <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" id="lastname" placeholder="Last Name" value="<?= $lastname; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" id="contact_number" placeholder="Contact Number" value="<?= $contact_number; ?>" minlength="10" maxlength="11">
                              </div>
                            </div>
                          </div>
                        <?php
                      }
                    ?>
                    <div class="row">
                      <div class="update ml-auto mr-auto">
                        <button type="submit" class="btn btn-primary btn-round" id="updateProfileBtn">Update Profile</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>

        <?php include './includes/footer.php'; ?>

      </div>

    </div>  
    <?php include './includes/scripts.php'; ?>
    <script type="text/javascript" src="./jsfunctions/general.js"></script>
    <script type="text/javascript" src="./jsfunctions/profile.js"></script>
  </body>
</html>
<?php

  require_once '../classes/Config.php';
  $config = new Config();
  session_start();

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
    <title>Sit & Zip | Users</title>

    <?php include './includes/libraries.php'; ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> -->
    <script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="admin-style.css">

  </head>
  <body>

    <div class="wrapper">

      <?php include './includes/sidebar.php'; ?>
      <div class="main-panel">
        
        <?php include './includes/navigation.php'; ?>
        <div class="content">

          <a class="btn-link" href="./manage.users.php">Back</a>

          <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <h5><i class="icon fa fa-info"></i> Note!</h5>
            Click the name of the user that you want to update or archive on the table.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="row">
            
            <div class="col-md-6">
              
                <?php if (!isset($_GET['employeeid']) && !isset($_GET['status'])) { ?> 
                  <div class="card ">
                    <div class="card-header ">
                      <h5 class="card-title">Add an account</h5>
                    </div>

                    <div class="card-body ">
                      <div id="errordiv" class="text-warning">
                        <p id="error"></p>
                      </div>
                      <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="addUserForm">
                        <div class="form-group">
                          <label class="form-control-label" for="position">Position</label>
                          <select id="position" name="position" class="form-control">
                            <option value="" disabled selected>Select a position</option>
                            <option value="Admin">Administrator</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Cook">Cook</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="form-control-label" id="other-position-label" for="otherPosition">Position</label>
                          <input type="text" class="form-control" placeholder="Position" id="otherPosition" name="otherPosition">
                        </div>

                        <div class="form-group">
                          <label class="form-control-label" for="username">Username</label>
                          <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                          <label class="form-control-label" for="email">Email</label>
                          <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                          <label class="form-control-label" for="password">Password</label>
                          <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-warning" name="registerBtn" id="registerBtn">Create</button>
                      </form>

                    </div>
                  </div>
                <?php } else { ?>
                  <div class="card ">
                    <div class="card-header ">
                      <h5 class="card-title float-left">Edit User Profile</h5>
                      <span class="clearfix">
                        <?php
                        $employee_id = $config->checkInput($_GET['employeeid']);
                        $status = $config->checkInput($_GET['status']);
                        if($status == 'Active' && $employee_id <> 1)
                        {
                          ?>
                          <button type="button" class="btn btn-sm btn-info float-right" id="edituser-holder-btn">Edit</button>
                          <?php
                        }
                        ?>
                      </span>
                    </div>

                    <div class="card-body ">

                      <?php
                        $stmt = $config->runQuery("SELECT * FROM employeesaccount_tbl
                                                    WHERE employee_id = :empid LIMIT 1");
                        $stmt->execute(array(":empid" => $employee_id));
                        ?>

                        <form class="text-white" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="editUserForm">
                          <div>
                            <span id="error-edit" class="text-warning"></span>
                          </div>
                            
                            <input type="hidden" id="hiddenUserId" value="<?php echo $employee_id; ?>"/>
                            <input type="hidden" id="hiddenUserStatus" value="<?php echo $status; ?>"/>

                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                              $username = $row['employee_username'];
                              $email = $row['employee_email'];
                              $firstname = $row['employee_firstname'];
                              $lastname = $row['employee_lastname'];
                              $contact_number = $row['employee_contactnumber'];
                              $position = $row['employee_position'];

                              ?>
                              <div class="form-group">
                                <label class="form-control-label" for="newusername">Username</label>
                                <input class="form-control" type="text" id="newusername" name="newusername" value="<?php echo $username; ?>" disabled/>
                              </div>
                              <div class="form-group">
                                <label class="form-control-label" for="newemail">Email</label>
                                <input class="form-control" type="text" id="newemail" name="newemail" value="<?php echo $email; ?>" disabled/>
                              </div>
                              <div class="form-group">
                                <label class="form-control-label" for="newposition">Position</label>
                                <select id="newposition" name="newposition" class="form-control" disabled>
                                  <option value="" disabled selected>Select a position</option>
                                  <option value="Admin">Administrator</option>
                                  <option value="Cashier">Cashier</option>
                                  <option value="Cook">Cook</option>
                                  <option value="Other">Other</option>
                                </select>
                              </div>
                              <div class="form-group" id="newposition-div">
                                <label class="form-control-label" id="new-other-position-label" for="newotherPosition">Position</label>
                                <input type="text" class="form-control" placeholder="Position" id="newotherPosition" name="newotherPosition">
                              </div>
                              <div class="form-group">
                                <label class="form-control-label" for="newfirstname">First name</label>
                                <input class="form-control" type="text" id="newfirstname" name="newfirstname" value="<?php echo $firstname; ?>" disabled/>
                              </div>
                              <div class="form-group">
                                <label class="form-control-label" for="newlastname">Last name</label>
                                <input class="form-control" type="text" id="newlastname" name="newlastname" value="<?php echo $lastname; ?>" disabled/>
                              </div>
                              <div class="form-group">
                                <label class="form-control-label" for="newcontactnumber">Contact number</label>
                                <input class="form-control" type="text" id="newcontactnumber" name="newcontactnumber" value="<?php echo $contact_number; ?>" maxlength="11" disabled/>
                              </div>
                              <?php
                            }
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <button type="submit" class="btn btn-warning" name="editUserBtn" id="editUserBtn" disabled>Save</button>
                            </div>
                            <div class="col-md-6">
                              <a class="dropdown-toggle pull-right" data-toggle="dropdown" href="#" id="advancedSettings"><span class="custom-text">Advance option </span></a>
                              <div class="dropdown-menu text-center" role="menu">
                                  <button type="submit" class="btn btn-danger dropdown-item" name="archiveUserBtn" id="archiveUserBtn">Deactivate</button>
                                  <button type="button" class="btn btn-info dropdown-item" name="resetPasswordTriggerBtn" data-toggle="modal" data-target="#resetPasswordModal" id="resetPasswordTriggerBtn">Reset Password</button>
                              </div>
                            </div>
                          </div>
                        </form>
                    </div>
                  </div>
                <?php } ?>
            </div>

            <div class="col-md-6">
              
              <div class="card">
                
                <div class="card-body">
                  <table class="table" id="table-users">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Position</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Position</th>
                        <th>Status</th>
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

    <div class="modal" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="form-control-label" for="newpassword">New password</label>
              <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="New password" minlength="8">
            </div>
            <div class="form-group">
              <label class="form-control-label" for="retypenewpassword">Retype new password</label>
              <input type="password" name="retypenewpassword" id="retypenewpassword" class="form-control" placeholder="Retype new password" minlength="8">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="resetPasswordBtn">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  
  <?php include './includes/scripts.php'; ?>
  <script type="text/javascript" src="./jsfunctions/manage.users.js"></script>
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
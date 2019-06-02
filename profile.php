<?php

  require_once './classes/Config.php';
  $config = new Config();
  session_start();
  $customer_id = $_SESSION['customer_id'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Sit & Zip | Profile</title>

    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon"> -->

    <?php include 'includes/libraries.php'; ?>

  </head>
  <body>

  <!--START SCROLL TOP BUTTON -->
  <a class="scrollToTop" href="#">
    <i class="fa fa-angle-up"></i>
    <span>Top</span>
  </a>
  <!-- END SCROLL TOP BUTTON -->

  <!-- HEADER -->
  <?php include 'includes/header.php'; ?>
  <!-- END OF HEADER -->

  <!-- SLIDER -->
  <?php include 'includes/slider.php'; ?>
  <!-- END OF SLIDER -->

  <section id="mu-about-us">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-about-us-area">
            <div class="mu-title">
              <span class="mu-subtitle" style="color: #FFB03B;">Manage your</span>
              <h2>Profile</h2>
              <i class="fa fa-spoon" style="color: #FFB03B;"></i>              
              <span class="mu-title-bar"></span>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="mu-about-us-left" role="navigation">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs nav-stacked" role="tablist">
                    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" class="mu-readmore-btn">Profile</a></li>
                    <li role="presentation"><a href="#reservations" aria-controls="reservations" role="tab" data-toggle="tab" class="mu-readmore-btn">Reservations</a></li>
                    <li role="presentation"><a href="#testimonials" aria-controls="testimonials" role="tab" data-toggle="tab" class="mu-readmore-btn">Testimonials</a></li>
                  </ul>

                </div>
              </div>
              <div class="col-md-8">
                <div class="mu-about-us-right" style="border-left: 0.1px solid #ccc;">                
                  
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- Profile -->
                    <div role="tabpanel" class="tab-pane active" id="profile">
                      <div class="container">
                        <h2 class="mu-slider-small-title" style="margin-bottom: 20px;">Profile</h2>
                        <form class="mu-contact-form" method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" style="max-width: 700px;" id="customer-profile-form">

                          <?php
                            $stmt = $config->runQuery("SELECT * FROM customersaccount_tbl
                                                          WHERE customer_id=:customer_id LIMIT 1");

                            $stmt->execute(array(":customer_id" => $customer_id));
                            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              $username = $row['customer_username'];
                              $email = $row['customer_email'];
                              $fullname = $row['customer_fullname'];
                              $contact_number = $row['customer_contactnumber'];
                              ?>
                                <input type="hidden" id="hiddenCustomerId" value="<?= $customer_id; ?>">
                                <div class="col-xs-12 col-md-6">
                                  <div class="form-group">
                                    <label class="form-control-label" for="username">Username</label>
                                    <input type="text" id="username" class="form-control" placeholder="Username" value="<?= $username; ?>" disabled/>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                  <div class="form-group">
                                    <label class="form-control-label" for="email">Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="Email" value="<?= $email; ?>" disabled/>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label class="form-control-label" for="fullname">Full name</label>
                                    <input type="text" id="fullname" class="form-control" placeholder="Full name" value="<?= $fullname; ?>"/>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label class="form-control-label" for="contact_number">Contact number</label>
                                    <input type="text" id="contact_number" class="form-control" placeholder="Contact number" value="<?= $contact_number; ?>" minlength="10" maxlength="11"/>
                                  </div>
                                </div>
                              <?php
                            }
                          ?>
                          <div class="col-md-12" style="margin-top: 20px;">
                            <button type="submit" class="mu-send-btn" id="saveProfileBtn">Save</button>
                          </div>
                        </form>
                      </div>

                      <div class="container">
                        <hr>
                          <h2 class="mu-slider-small-title" style="margin-bottom: 20px;">Account</h2>
                          <div class="col-md-12">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#resetPasswordModal" data-backdrop='static' data-keyboard="false">Change my password</button> 
                            
                          </div>
                      </div>
                    </div>

                    <!-- Reservations -->
                    <div role="tabpanel" class="tab-pane" id="reservations">
                      <div class="container">
                        <h2 class="mu-slider-small-title" style="margin-bottom: 20px;">Reservations</h2>
                        
                        <div class="row" style="max-width: 700px;">
                          <div class="col-md-12">
                            <table class="table display nowrap" style="width: 100%;" id="profile-reservation-table">
                              <thead>
                                <tr>
                                  <th>Reservation Date</th>
                                  <th>Reservation Time</th>
                                  <th>Number of people</th>
                                  <th>Reservation Status</th>
                                  <th><i class="glyphicon glyphicon-cog"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  $stmt = $config->runQuery("SELECT * FROM reservations_tbl WHERE customer_id=:customer_id");
                                  $stmt->execute(array(":customer_id" => $customer_id));
                                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $reservation_id = $row['reservation_id'];
                                    $reservation_date = $row['reservation_date'];
                                    $reservation_time = $row['reservation_time'];
                                    $number_of_people = $row['reservation_numberofpeople'];
                                    $reservation_status = $row['reservation_status'];

                                    $reservation_date = strtotime($reservation_date);
                                    $reservation_date = date('F jS Y', $reservation_date);

                                    ?>
                                      <tr>
                                        <td><?= $reservation_date; ?></td>
                                        <td><?= $reservation_time; ?></td>
                                        <td><?= $number_of_people; ?></td>
                                        <td><?= $reservation_status; ?></td>
                                        <td>
                                          <?php
                                            if ($reservation_status == 'Pending') {
                                              ?>
                                                <button class="btn btn-success updateGetReservationId" type="button" title="Update" data-toggle="modal" data-target="#updateReservationModal" data-id="<?= $reservation_id; ?>" data-backdrop='static' data-keyboard="false">
                                                  <i class="glyphicon glyphicon-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger cancelReservationBtn" type="button" title="Cancel" data-id="<?= $reservation_id; ?>" data-reservation="<?= $reservation_date; ?>">
                                                  <i class="glyphicon glyphicon-remove"></i>
                                                </button>
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
                        </div>
                      </div>
                    </div>

                    <!-- Testimonials -->
                    <div role="tabpanel" class="tab-pane" id="testimonials">
                      <div class="container">
                        <h2 class="mu-slider-small-title" style="margin-bottom: 20px;">Tell us your experience</h2>
                        <div class="row" style="max-width: 750px;">
                          <form method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                            <input type="hidden" id="hiddenCustomerId2" value="<?= $customer_id; ?>">
                            <div class="col-md-12">
                              <div class="form-group">
                                <textarea class="form-control" maxlength="250" id="customer_testimonials" cols="30" rows="5"></textarea></textarea>
                              </div>
                            </div>
                            <div class="col-md-8">
                              <button type="button" class="btn btn-lg btn-primary" id="testimonialsBtn">Share</button>
                            </div>
                            <div class="col-md-4">
                                Remaining characters: <span id="textarea-counter" class="form-text text-muted">250</span>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal" tabindex="-1" role="dialog" id="resetPasswordModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="mu-contact-form" method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" style="max-width: 700px;" id="reset-password-form">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reset password</h4>
          </div>
          <div class="modal-body">
              <input type="hidden" id="hiddenCustomerId1" value="<?= $_SESSION['customer_id']; ?>">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="current_password">Current password</label>
                  <input type="password" id="current_password" class="form-control" placeholder="Current password"/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="new_password">New password</label>
                  <input type="password" id="new_password" class="form-control" placeholder="New password"/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="retype_new_password">Retype new password</label>
                  <input type="password" id="retype_new_password" class="form-control" placeholder="Retype new password"/>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveNewPassword">Save changes</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal" tabindex="-1" role="dialog" id="updateReservationModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="mu-contact-form" method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" style="max-width: 700px;" id="update-reservation-form">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Update reservation</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" id="hiddenReservationId" value="">
             <div id="reservationContainer">
               
             </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveReservationUpdate">Save changes</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <?php include 'includes/footer.php'; ?>

  <?php include 'includes/scripts.php'; ?>
  <script type="text/javascript" src="./assets/profile.js"></script>
  </body>
</html>
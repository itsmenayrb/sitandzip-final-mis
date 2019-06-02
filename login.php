<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Sit & Zip | Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

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
    <section id="login">
      
    <section id="mu-about-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="mu-about-us-area">
              <div class="mu-title">
                <span class="mu-subtitle" style="color: #FFB03B;">Keep in touch with us.</span>
                <h2>Log in</h2>
                <i class="fa fa-spoon" style="color: #FFB03B;"></i>              
                <span class="mu-title-bar"></span>
                  <div id="errordiv" class="text-warning">
                    <span id="error"></span>
                  </div>
              </div>
              <div class="container">
                <form class="mu-login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                  <div class="form-group">
                    <span class="form-control-label" for="username">Username or Email</span>                       
                    <input type="text" class="form-control" placeholder="Username or Email" id="username" name="username" required>
                  </div>
                  <div class="form-group">
                    <span class="form-control-label" for="password">Password</span>
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                  </div>
                  <button type="submit" class="mu-send-btn" name="loginBtn" id="loginBtn">Log in</button>
                  <hr>
                  Don't have an account? Click <a class="btn-link" href="./register.php">here</a> to sign up.<br>
                  <a class="btn-link" href="./forgotpassword.php">I forgot my password.</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    </section>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#loginBtn').on('click', function(e) {
          e.preventDefault();
          var username = $('#username').val();
          var email = $('#username').val();
          var password = $('#password').val();

          if (username == '' || password == '' || email == '') {
            $('#error').text('All fields are required.');
          } else {
            $.ajax({
              method: 'POST',
              url: './controller/LoginController.php',
              data: {
                  username: username,
                  email: email,
                  password: password,
                  login: 1
              },
              dataType: 'json',
              success: function(response) {
                var err = response.length;
                if ( err > 0 ) {
                  for (var i = 0; i < err; i++) {
                    $('#error').text(response[i]);
                  }
                }
                if(response == 'Success') {
                  window.location.href = './index.php';
                }
              }
            });
          }
        });
      });
    </script>
  </body>
</html>
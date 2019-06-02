<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Sit & Zip | Register</title>

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
    
    <section id="mu-about-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="mu-about-us-area">
              <div class="mu-title">
                <span class="mu-subtitle" style="color: #FFB03B;">Tell us your experience.</span>
                <h2>Create an account</h2>
                <i class="fa fa-spoon" style="color: #FFB03B;"></i>              
                <span class="mu-title-bar"></span>
                  <div id="errordiv" class="text-warning">
                    <span id="error"></span>
                  </div>
              </div>
              <div class="container">
                <form class="mu-login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                  <div class="form-group">
                    <span class="form-control-label" for="username">Username</span>
                    <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                  </div>
                  <div class="form-group">
                    <span class="form-control-label" for="email">Email</span>
                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                  </div>
                  <div class="form-group">
                    <span class="form-control-label" for="password">Password</span>
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                  </div>
                  <div class="form-group">
                    <span class="form-control-label" for="cpassword">Re-type Password</span>
                    <input type="password" class="form-control" placeholder="Re-type Password" id="cpassword" name="cpassword" required>
                  </div>
                  <button type="submit" class="mu-send-btn" name="registerBtn" id="registerBtn">Join</button>
                  <hr>
                  Already have an account? Click <a class="btn-link" href="./login.php#login">here</a> to sign in.<br>
                  <a class="btn-link" href="./forgotpassword.php">I forgot my password.</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#registerBtn').on('click', function(e) {
          e.preventDefault();
          var username = $('#username').val();
          var email = $('#email').val();
          var password = $('#password').val();
          var cpassword = $('#cpassword').val();

          if (username == '' || password == '' || email == '' || cpassword == '') {
            $('#error').text('All fields are required.');
          } else if (password != cpassword) {
            $('#error').text('Password did not match.');
          } else if (validateEmail(email) == false) {
            $('#error').text('Invalid email address.');
          } else if (password.length < 8) {
            $('#error').text('Password must be at least 8 alphanumeric characters.');
          } else {
            $.ajax({
              method: 'POST',
              url: './controller/RegisterController.php',
              data: {
                  username: username,
                  email: email,
                  password: password,
                  cpassword: cpassword,
                  register: 1
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
                  window.setTimeout(function() {
                    $('#error').text('Registered Successfully! You will be redirected to the login page.');
                    window.location.href = './login.php';
                  }, 5000)
                }
              }
            });
          }
        });
      });

      function validateEmail(email) {
        var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
        return re.test(email);
      } 

    </script>
  </body>
</html>
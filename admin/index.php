<?php

  require_once '../classes/Config.php';
  session_start();
  $config = new Config();

  if (isset($_SESSION['position'])) {
    $config->redirect('./dashboard.php');
  }

//echo $_SESSION['employee_username'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />   
    <title>Sit & Zip | Log in</title>

    <?php include './includes/libraries.php'; ?>
    <link rel="stylesheet" type="text/css" href="admin-style.css">

  </head>
  <body>

    <div class="wrapper">
      <div class="sidebar" data-color="orange" data-active-color="danger">
      </div>
      <div class="main-panel">
        
        <div class="content">

              <form class="mu-login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                <h3 class="card-title">Sit & Zip Garden Cafe - Bacoor</h3>
                <h5 class="card-subtitle text-muted mb-3">Login</h5>
                <div id="errordiv" class="text-warning">
                  <span id="error"></span>
                </div>
                <div class="form-group">
                  <span class="form-control-label" for="username">Username</span>                       
                  <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                </div>
                <div class="form-group">
                  <span class="form-control-label" for="password">Password</span>
                  <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="loginBtn" id="loginBtn">Log in</button>
              </form>

          


        </div>
        <?php include './includes/footer.php'; ?>
      </div>

    </div>

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
                window.location.href = './dashboard.php';
              }
            }
          });
        }
      });
    });
  </script>
  </body>
</html>
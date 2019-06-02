<?php

  require_once '../classes/Config.php';
  session_start();

  $config = new Config();

  if ($config->is_loggedin() == "") {
    $config->redirect('./index.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />   
    <title>Sit & Zip | Forbidden</title>

    <?php include './includes/libraries.php'; ?>
    <link rel="stylesheet" type="text/css" href="admin-style.css">

  </head>
  <body>

    <div class="wrapper">
      <div class="sidebar" data-color="orange" data-active-color="danger">
      </div>
      <div class="main-panel">
        
        <div class="content">
              
              <p class="display-3">Error 403 | Forbidden</p>
              <p class="lead mb-5">Oops! It looks like that you do not have enough privilege to access the page.<br> If you think this is a mistake, please contact your administrator.</p>
              
              <a class="btn-link mt-5 float-left" href="./dashboard.php"><u>Go back to dashboard</u></a>
              
        </div>
        <?php include './includes/footer.php'; ?>
      </div>

    </div>

  <?php include 'includes/scripts.php'; ?>
  </body>
</html>
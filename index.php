<?php

  require_once './classes/Config.php';
  $config = new Config();
  session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Sit & Zip | Home</title>

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

  <!-- Start About us -->
  <?php include 'includes/aboutus.php'; ?>
  <!-- End About us -->

  <!-- Start Counter Section -->
  <?php include 'includes/counter.php'; ?>
  <!-- End Counter Section --> 

  <!-- Start Restaurant Menu -->
  <?php include 'includes/menu.php'; ?>
  <!-- End Restaurant Menu -->

  
  <!-- Start Reservation section -->
  <?php 
  if(isset($_SESSION['customer_username'])){
    include 'includes/reservation.php';
  }
  ?>
  <!-- End Reservation section -->

 
  <!-- Start Client Testimonial section -->
  <?php include 'includes/testimonials.php'; ?>
  <!-- End Client Testimonial section -->

  <!-- Start Contact section -->
  <?php include 'includes/contactus.php'; ?>
  <!-- End Contact section -->

  <?php include 'includes/footer.php'; ?>

  <?php include 'includes/scripts.php'; ?>
  <script type="text/javascript" src="./assets/menu.js"></script>
  <script type="text/javascript" src="./assets/contact.js"></script>
  <script type="text/javascript" src="./assets/reservation.js"></script>
  </body>
</html>
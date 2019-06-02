<!-- Start header section -->
<header id="mu-header">  
  <nav class="navbar navbar-default mu-main-navbar" role="navigation">  
    <div class="container">
      <div class="navbar-header">
        <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- LOGO -->                                                        
        <a class="navbar-brand" href="./index.php">Sit&Zip</a> 
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul id="top-menu" class="nav navbar-nav navbar-right mu-main-nav">
          <li><a href="index.php#mu-slider">HOME</a></li>
          <li><a href="index.php#mu-about-us">ABOUT US</a></li>                       
          <li><a href="index.php#mu-restaurant-menu">MENU</a></li>
          <?php if (isset($_SESSION['customer_username'])) : ?>                       
          <li><a href="index.php#mu-reservation">RESERVATION</a></li>
          <?php endif ?>
          <li><a href="index.php#mu-contact">CONTACT</a></li>
          <?php if (!isset($_SESSION['customer_username'])) { ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">ACCOUNTS <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">                
                <li><a href="./login.php#login">Login</a></li>
                <li><a href="./register.php">Register</a></li>         
              </ul>
            </li>
          <?php } else { ?>
            <li class="dropdown">
              <a class="dropdown-toggle text-uppercase" data-toggle="dropdown" href="#"><?php echo $_SESSION['customer_username']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">                
                <li><a href="./profile.php">Profile</a></li>
                <li><a href="./logout.php?logout=true">Log out</a></li>         
              </ul>
            </li>
          <?php } ?>
        </ul>                            
      </div><!--/.nav-collapse -->       
    </div>          
  </nav> 
</header>
<!-- End header section -->
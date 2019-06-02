<div class="sidebar" data-color="orange" data-active-color="danger">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
  -->
  <div class="logo">
    <a href="./dashboard.php" class="simple-text logo-normal text-center">
      Sit & Zip
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item">
        <a href="./dashboard.php">
          <i class="nc-icon nc-bank"></i>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a href="./messages.php">
          <i class="nc-icon nc-email-85"></i>
          Messages
        </a>
      </li>
      <li class="nav-item">
        <a href="./reservations.php">
          <i class="nc-icon nc-bell-55"></i>
          Reservations
        </a>
      </li>
      <li class="nav-item">
        <a href="./manage.orders.php">
          <i class="nc-icon nc-basket"></i>
          Orders
        </a>
      </li>
      <li class="nav-item btn-rotate dropdown">
        <a href="#" class="nav-link dropdown-toggle" id="pointOfSaleDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="nc-icon nc-atom"></i>
          Point of Sale
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pointOfSaleDropdown">
          <a class="dropdown-item" href="./pos.php">System</a>
          <a class="dropdown-item" href="./manage.categories.php">Manage Category</a>
          <a class="dropdown-item" href="./manage.products.php">Manage Products</a>
        </div>
      </li>
      <li class="nav-item">
        <a href="./inventory.php">
          <i class="nc-icon nc-tile-56"></i>
          Inventory
        </a>
      </li>
      <?php
        if ($GLOBALS['current_session'] == 'Admin')
        {
          ?>
          <li class="nav-item btn-rotate dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="reportsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="nc-icon nc-chart-bar-32"></i>
              Reports
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reportsDropdown">
              <a class="dropdown-item" href="./sales.php">Sales</a>
            </div>
          </li>
          <li class="nav-item">
            <a href="./archives.php">
              <i class="nc-icon nc-simple-remove"></i>
              Archives
            </a>
          </li>
          <li class="nav-item">
            <a href="./manage.users.php">
              <i class="nc-icon nc-single-02"></i>
              Manage Users
            </a>
          </li>
          <?php
        }
      ?>
    </ul>
  </div>
</div>
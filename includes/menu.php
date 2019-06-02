<section id="mu-restaurant-menu">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="mu-restaurant-menu-area">
          <div class="mu-title">
            <span class="mu-subtitle" style="color: #FFB03B;">Discover</span>
            <h2>OUR MENU</h2>
            <i class="fa fa-spoon" style="color: #FFB03B;"></i>              
            <span class="mu-title-bar"></span>
          </div>
          <div class="mu-restaurant-menu-content">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
              <div class="form-group">
                <label class="form-control-label" for="categoryname_select">Select Category</label>
                <select class="form-control" name="categoryname_select" id="categoryname_select">
                  
                </select>
              </div>
            </form>
            <div id="menu-container" class="text-center">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
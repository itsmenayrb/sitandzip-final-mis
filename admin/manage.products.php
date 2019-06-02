<?php

  require_once '../classes/Config.php';
  $config = new Config();
  session_start();

  if ($config->is_loggedin() == "") {
    $config->redirect('./index.php');
  }

  $GLOBALS['current_session'] = $_SESSION['employee_username'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />    
    <title>Sit & Zip | Manage Products</title>

    <?php include 'includes/libraries.php'; ?>
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

          <a class="btn-link" href="./manage.categories.php">Back</a>

          <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <h5><i class="icon fa fa-info"></i> Note!</h5>
            Click the name of the product that you want to edit or archive on the table.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="row">
            
            <div class="col-md-6">

              <?php if (!isset($_GET['productid']) && !isset($_GET['status'])) { ?> 
                  <div class="card ">
                    <div class="card-header ">
                      <h5 class="card-title">Add a product</h5>
                    </div>
            
                    <div class="card-body ">
                      <div>
                        <span id="errorproduct-edit" class="text-warning"></span>
                      </div>          
                      <form class="text-white" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="addProductForm">
                        <div class="form-group">
                          <label class="form-control-label" for="categoryname_select">Category name</label>
                          <select class="form-control" name="categoryname_select" id="categoryname_select">
                            
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="form-control-label" for="productname">Product name</label>
                          <input class="form-control" type="text" id="productname" name="productname" placeholder="Product name"/>
                        </div>
                        <div class="form-group">
                          <label class="form-control-label" for="productprice">Price</label>
                          <input class="form-control" type="text" id="productprice" name="productprice" placeholder="Price"/>
                        </div>
                        <button type="submit" class="btn btn-warning" name="addProductBtn" id="addProductBtn"> Add <span id="spinner"></span></button>
                      </form>

                    </div>
                  </div>

              <?php } else { ?>
                  <div class="card ">
                    <div class="card-header ">
                      <h5 class="card-title float-left">Edit product</h5>
                      <span class="clearfix">
                        <?php
                        $status = $config->checkInput($_GET['status']);
                        if($status == 'Active')
                        {
                          ?>
                          <button type="button" class="btn btn-sm btn-info float-right" id="edit-holder-btn">Edit</button>
                          <?php
                        }
                        ?>
                      </span>
                    </div>

                    <div class="card-body ">

                      <?php
                        $product_id = $config->checkInput($_GET['productid']);
                        $status = $config->checkInput($_GET['status']);
                        $stmt = $config->runQuery("SELECT * FROM products_tbl
                                                    WHERE product_id = :prodid LIMIT 1");
                        $stmt->execute(array(":prodid" => $product_id));

                        ?>

                        <div>
                          <span id="error-edit" class="text-white"></span>
                        </div>

                        <form class="text-white" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="editProductForm">

                          <input type="hidden" id="hiddenProductId" value="<?php echo $product_id; ?>"/>
                          <input type="hidden" id="hiddenProductStatus" value="<?php echo $status; ?>"/>

                          <?php

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                              $product_name = $row['product_name'];
                              $product_price = $row['product_price'];
                              $productcategory_id = $row['productcategory_id'];
                              $product_status = $row['product_status'];
                              ?>
  
                              <div class="form-group">
                                <label class="form-control-label" for="categoryName">Category name</label>
                                <select class="form-control" name="categoryName" id="categoryName" disabled>
                                  <option value="" disabled>Select a category.</option>
                                  <?php

                                    $pcstatus = "Active";
                                    $stmt1 = $config->runQuery("SELECT * FROM productcategories_tbl
                                                                  WHERE productcategory_status=:status
                                                                    ORDER BY productcategory_name");
                                    $stmt1->execute(array(":status"=>$pcstatus));

                                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
                                    {
                                      $pcid = $row1['productcategory_id'];
                                      $pcname = $row1['productcategory_name'];

                                      if ($pcid == $productcategory_id)
                                      {
                                        ?>
                                        <option value="<?php echo $pcid; ?>" selected><?php echo $pcname; ?></option>
                                        <?php
                                      } 
                                      else
                                      {

                                      ?>
                                      <option value="<?php echo $pcid; ?>"><?php echo $pcname; ?></option>
                                      <?php
                                      }
                                    }

                                  ?>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="productName" class="form-control-label">Product name</label>
                                <input type="text" class="form-control" name="productName" placeholder="Product name" id="productName" value="<?php echo $product_name; ?>" required disabled="disabled">
                              </div>

                              <div class="form-group">
                                <label for="productPrice" class="form-control-label">Product price</label>
                                <input type="text" class="form-control" name="productPrice" placeholder="Product price" id="productPrice" value="<?php echo $product_price; ?>" required disabled="disabled">
                              </div>

                              <?php
                            }

                          ?>

                          <div class="row">
                            <div class="col-md-6">
                              <button type="submit" class="btn btn-warning" name="editProductBtn" id="editProductBtn" disabled>Save <span id="editproductspinner"></span></button>
                            </div>
                            <div class="col-md-6">
                              <a class="dropdown-toggle pull-right" data-toggle="dropdown" href="#" id="advancedSettings"><span class="custom-text">Advance option </span></a>
                              <div class="dropdown-menu pull-right text-center" role="menu">
                                  <button type="submit" class="btn btn-sm btn-danger" name="archiveProductBtn" id="archiveProductBtn">Archive<span id="archiveproductspinner"></span></button>
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
                  <table class="table" id="table-product">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Price</th>
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
  
  <?php include './includes/scripts.php'; ?>
  <script type="text/javascript" src="./jsfunctions/manage.categories.js"></script>
  <script type="text/javascript" src="./jsfunctions/manage.products.js"></script>
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
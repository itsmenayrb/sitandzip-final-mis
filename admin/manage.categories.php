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
    <title>Sit & Zip | Manage Categories</title>

    <?php include './includes/libraries.php'; ?>
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
            Click the name of the category that you want to edit or archive on the table.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="row">
            
            <div class="col-md-6">
              
                <?php if (!isset($_GET['categoryid']) && !isset($_GET['status'])) { ?> 
                  <div class="card ">
                    <div class="card-header ">
                      <h5 class="card-title">Add a category</h5>
                    </div>

                    <div class="card-body ">

                      <form class="text-white" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="addCategoryForm">
                        <div>
                          <span id="error"></span>
                        </div>          
                        <div class="form-group">
                          <label class="form-control-label" for="categoryname">Category name</label>
                          <input class="form-control" type="text" id="categoryname" name="categoryname" placeholder="Category name"/>
                        </div>
                        <button type="submit" class="btn btn-warning" name="addCategoryBtn" id="addCategoryBtn"> Add <span id="spinner"></span></button>
                      </form>

                    </div>
                  </div>
                <?php } else { ?>
                  <div class="card ">
                    <div class="card-header ">
                      <h5 class="card-title float-left">Edit category</h5>
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
                        $category_id = $config->checkInput($_GET['categoryid']);
                        $status = $config->checkInput($_GET['status']);
                        $stmt = $config->runQuery("SELECT * FROM productcategories_tbl
                                                    WHERE productcategory_id = :prodcatid LIMIT 1");
                        $stmt->execute(array(":prodcatid" => $category_id));
                        ?>

                        <form class="text-white" method="post" action="" id="editCategoryForm">
                          <div>
                            <span id="error-edit" class="text-warning"></span>
                          </div>
                          <div class="form-group">
                            <input type="hidden" id="hiddenCategoryId" value="<?php echo $category_id; ?>"/>
                            <input type="hidden" id="hiddenCategoryStatus" value="<?php echo $status; ?>"/>
                            <label class="form-control-label" for="newcatname" id="newcatnamelabel">New category name</label>

                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                              $productcategory_name = $row['productcategory_name'];
                              ?>
                              <input class="form-control" type="text" id="newcatname" name="newcatname" value="<?php echo $productcategory_name; ?>" disabled/>
                              <?php
                            }
                            ?>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <button type="submit" class="btn btn-warning" name="editCategoryBtn" id="editCategoryBtn" disabled="">Save <span id="editspinner"></span></button>
                            </div>
                            <div class="col-md-6">
                              <a class="dropdown-toggle pull-right" data-toggle="dropdown" href="#" id="advancedSettings"><span class="custom-text">Advance option </span></a>
                              <div class="dropdown-menu text-center" role="menu">
                                  <button type="submit" class="btn btn-sm btn-danger" name="archiveCategoryBtn" id="archiveCategoryBtn">Archive<span id="archivespinner"></span></button>
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
                  <table class="table" id="table-category">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Category</th>
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
  <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
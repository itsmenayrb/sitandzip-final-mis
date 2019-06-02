<?php

  session_start();
  require_once '../classes/Config.php';
  $config = new Config();

  if (!isset($_SESSION['employee_position']) || !isset($_SESSION['employee_username']) || !isset($_SESSION['employee_id'])) {
    $config->redirect('./index.php');
  }

  // echo $_SESSION['employee_username'];

  $GLOBALS['current_session'] = $_SESSION['employee_username'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />   
    <title>Sit & Zip | Messages</title>

    <?php include './includes/libraries.php'; ?>
    <script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="admin-style.css">

  </head>
  <body class="">
    
    <div class="wrapper">

      <?php include './includes/sidebar.php'; ?>

      <div class="main-panel">
    
        <?php include './includes/navigation.php'; ?>
          
        <div class="content">

          <div class="card ">
            <div class="card-header ">
              <h5 class="card-title">Emails</h5>
              <p class="card-category">All messages</p>
            </div>
            <div class="card-body ">
              <table class="table table-hover display nowrap" id="messages-table" style="width: 100%">
                <thead class="thead-inverse">
                  <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th><i class="nc-icon nc-settings-gear-65"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $status = 'Archived';
                    $stmt = $config->runQuery("SELECT *
                                                FROM messages_tbl WHERE message_status!=:status ORDER BY message_date ASC");
                    $stmt->execute(array(':status' => $status));
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                      $message_id = $row['message_id'];
                      $fullname = $row['message_fullname'];
                      $subject = $row['message_subject'];
                      $message = $row['message_body'];
                      $message_date = $row['message_date'];

                      $message_date = strtotime($message_date);
                      $message_date = date('F jS Y', $message_date);
                      ?>
                        <tr>
                          <td><strong><?= $fullname; ?></strong></td>
                          <td><strong><?= $subject; ?></strong></td>
                          <td><?= $message; ?></td>
                          <td><?= $message_date ?></td>
                          <th>
                            <button type="button" class="btn btn-sm btn-outline-primary replyTriggerBtn" title="Read" data-toggle="modal" data-target="#replyMessageModal" data-id="<?= $message_id ;?>">
                              <i class="nc-icon nc-tap-01"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger archiveMessageBtn" title="Archive" data-id="<?= $message_id ;?>">
                              <i class="nc-icon nc-simple-delete"></i>
                            </button>
                          </th>
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <div class="card-footer ">
              <hr>
              <div class="stats">
                <i class="fa fa-calendar"></i> Inquiries
              </div>
            </div>
          </div>

        </div>

        <?php include './includes/footer.php'; ?>

      </div>

    </div>

    <div class="modal" id="replyMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" id="hiddenGetMessageId" value="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel2">View</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <span id="error-reply" class="text-warning form-text text-muted"></span>
              <div id="message_container">
                
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary sendReplyMessage">Send</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <?php include './includes/scripts.php'; ?>
    <script type="text/javascript" src="./jsfunctions/messages.js"></script>
    <script type="text/javascript" src="./jsfunctions/general.js"></script>
  </body>
</html>
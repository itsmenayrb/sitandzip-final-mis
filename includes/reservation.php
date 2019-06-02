<section id="mu-reservation">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="mu-reservation-area">
          <div class="mu-title">
            <span class="mu-subtitle" style="color: #FFB03B;">Make A</span>
            <h2>Reservation</h2>
            <i class="fa fa-spoon" style="color: #FFB03B;"></i>              
            <span class="mu-title-bar"></span>
          </div>
          <div class="mu-reservation-content">
                <span class="text-danger">All fields are required.</span>
                
            <form class="mu-reservation-form" method="post" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
              <div class="row">
                <?php
                  $customer_id = $_SESSION['customer_id'];
                  $stmt = $config->runQuery("SELECT * FROM customersaccount_tbl
                                                            WHERE customer_id=:customer_id LIMIT 1");

                  $stmt->execute(array(":customer_id" => $customer_id));
                  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $email = $row['customer_email'];
                    $fullname = $row['customer_fullname'];
                    $contact_number = $row['customer_contactnumber'];
                    ?>
                      <input type="hidden" value="<?= $customer_id; ?>" id="hiddenCustomerId"/>
                      <div class="col-md-6">
                        <div class="form-group">        
                          <input type="text" class="form-control" id="reservation_fullname" placeholder="Full Name" value="<?= $fullname; ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="email" class="form-control" id="reservation_email" placeholder="Email" value="<?= $_SESSION['customer_email']; ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" class="form-control" id="reservation_contactnumber" placeholder="Contact Number" minlength="10" maxlength="11" value="<?= $contact_number; ?>">
                        </div>
                      </div>

                    <?php
                  }
                ?>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <select class="form-control" id="reservation_numberofpeople">
                      <option value="0">How Many?</option>
                      <option value="1">1 Person</option>
                      <option value="2">2 People</option>
                      <option value="3">3 People</option>
                      <option value="4">4 People</option>
                      <option value="5">5 People</option>
                      <option value="6">6 People</option>
                      <option value="7">7 People</option>
                      <option value="8">8 People</option>
                      <option value="9">9 People</option>
                      <option value="10+">10+ People</option>
                    </select>                      
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="reservation_date" placeholder="Date">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control datetimepicker-input" id="reservation_time" placeholder="Time" data-toggle="datetimepicker" data-target="#reservation_time">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <textarea class="form-control" cols="30" rows="5" placeholder="Your Message" id="reservation_message"></textarea>
                  </div>
                </div>
                <button type="submit" class="mu-readmore-btn" id="reservationBtn">Make Reservation</button>
              </div>
            </form>      
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
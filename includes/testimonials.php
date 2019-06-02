<section id="mu-client-testimonial">
  <div class="mu-overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-client-testimonial-area">
            <div class="mu-title">
              <span class="mu-subtitle" style="color: #FFB03B;">Testimonials</span>
              <h2>What Customers Say</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
            <!-- testimonial content -->
            <div class="mu-testimonial-content">
              <!-- testimonial slider -->
              <ul class="mu-testimonial-slider">
                <?php
                $stmt = $config->runQuery("SELECT * FROM testimonials_tbl INNER JOIN customersaccount_tbl ON testimonials_tbl.customer_id = customersaccount_tbl.customer_id ORDER BY RAND() LIMIT 3");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $fullname = $row['customer_fullname'];
                  $message = $row['testimonials_message'];
                  ?>
                    <li>
                      <div class="mu-testimonial-single">                   
                        <div class="mu-testimonial-info">
                          <p>"<?= $message; ?>"</p>
                        </div>
                        <div class="mu-testimonial-bio">
                          <p>- <?= $fullname; ?></p>                      
                        </div>
                      </div>
                    </li>
                  <?php
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
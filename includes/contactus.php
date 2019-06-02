<section id="mu-contact">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="mu-contact-area">
          <div class="mu-title">
            <span class="mu-subtitle" style="color: #FFB03B;">Let's have a talk</span>
            <h2>Contact Us</h2>
            <i class="fa fa-spoon" style="color: #FFB03B;"></i>              
            <span class="mu-title-bar"></span>
          </div>
          <div class="mu-contact-content">
            <div class="row">
              <div class="col-md-6">
                <div class="mu-contact-left">
                  <form class="mu-contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                    <span id="error-contact" class="text-warning"></span>
                    <div class="form-group">
                      <span class="text-danger">*</span> indicates required field.
                      
                    </div>
                    <div class="form-group">
                      <label for="name">Your Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="contactus-name" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="email">Email address<span class="text-danger">*</span></label>
                      <input type="email" class="form-control" id="contactus-email" placeholder="Email">
                    </div>                      
                    <div class="form-group">
                      <label for="subject">Subject<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="contactus-subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                      <label for="message">Message<span class="text-danger">*</span></label>                        
                      <textarea class="form-control" id="contactus-message" cols="30" rows="5" placeholder="Type Your Message"></textarea>
                    </div>
                    <button type="submit" class="mu-send-btn" id="contactus-sendBtn">Send Message</button>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mu-contact-right">
                  <div class="mu-contact-widget">
                    <h3>Location</h3>
                    <p>Contact or Visit us.</p>
                    <address>
                      <p><i class="fa fa-phone"></i> (046) - 123 - 4567</p>
                      <p><i class="fa fa-envelope-o"></i>sitandzip@gmail.com</p>
                      <p><i class="fa fa-map-marker"></i>Arc Centre, 289 Aguinaldo Highway, Barangay Real 1, Bacoor City, Cavite, Philippines, 4102</p>
                    </address>
                  </div>
                  <div class="mu-contact-widget">
                    <h3>Open Hours</h3>                      
                    <address>
                      <p><span>Monday - Sunday</span> 11:00 am to 11:00 pm</p>
                    </address>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- email content -->
<div class="container pt-3  pb-3  overflow-hidden">

  <div class="bg-light border-20-hidden">
    <!-- header -->

    <div class="mb-3 bg-light">
      <div class="p-3 w3-theme-d3">
        <div class="row w-100">
          <div class="col-8">
            <img src="<?php echo SITE_URL  ?>/public/img/app/logo.png" class="wl-height-30"> Thanos API
          </div>
        </div>
      </div>
      <!-- user image -->
      
    </div>
    <!-- header -->
    <!-- body -->
    <div class="p-3 mb-3" id="_content_body">
    {{ body }}
    </div>
    <!-- body -->

    <!-- footer -->
    <div class="p-3 _text_14 w3-text-grey w3-light-grey">
      If you have any questions, contact us at citizen@thanosapi.com, we normally reply within 48 hours
    </div>

    <div class="bg-dark">

      <!-- navigations -->
    <div class="pt-3 w3-text-light-grey text-center"> 
      <div class="offset-md-2 col-md-8">
      <ul class=" d-flex justify-content-center list-unstyled">
      <li class="pr-2 pl-2"><a href="<?php echo SITE_URL ?>#login" class="w3-text-light-grey">Login</a></li>
      <li class="pr-2 pl-2"><a href="<?php echo SITE_URL ?>/privacy/terms-of-use" class="w3-text-light-grey">Terms of use</a></li>
      <li class="pr-2 pl-2"><a href="<?php echo SITE_URL ?>/privacy/privacy-policy" class="w3-text-light-grey">Privacy Policy</a></li>
    </ul></div>
    </div>
      <!-- navigations -->

      <div class="row p-3 w3-center w-100">
        <div class="offset-md-2 col-md-8">
          <div class="d-flex justify-content-start">
            <div class="pr-3 pt-3  pb-3 align-self-center"> Download :</div>
            
            <div class="pt-3  pb-3 pr-2">
              <a href="https://play.google.com/store/apps/details?id=com.njofa.njofa&hl=en_CA" class="btn btn-success pr-5 wl-app-btn">
                <ion-icon name="logo-google-playstore" class="float-left mr-1 md hydrated wl-footer-btn-email" role="img" aria-label="logo google playstore"></ion-icon>
                <div>
                  <small>Available on the</small> <br> Google Play
                </div>
              </a>
            </div>
            <div class="pt-3  pb-3">
              <button class="btn btn-light pr-5 wl-app-btn">
                <ion-icon name="logo-apple" class="float-left mr-1 md hydrated wl-footer-btn-email" role="img" aria-label="logo apple"></ion-icon>
                <div>
                  <small>Available on the</small> <br> APP Store
                </div>
              </button>
            </div>
          </div>
        </div>

        <div class=" col-md-4 align-self-center">
          <div class="row">
            <div class="pr-2 pl-2">Follow us:</div>
            <div class="row">
              <div>
                <a href="https://www.facebook.com/njofaworld/" class="pr-2 pl-2 text-light">
                  <img src="<?php echo SITE_URL ?>/public/img/app/email/facebook.png" class="wl-size-20">
                </a>
              </div>
              <div><a href="#" class="pr-2 pl-2 text-light">
              <img src="<?php echo SITE_URL ?>/public/img/app/email/instagram.png" class="wl-size-20">
                </a></div>
              <div><a href="#" class="pr-2 pl-2 text-light">
              <img src="<?php echo SITE_URL ?>/public/img/app/email/linkedin.png" class="wl-size-20">
                </a></div>
              <div class="d-none"><a href="#" class="pr-2 pl-2 text-light">
                  <ion-icon name="logo-linkedin" role="img" class="md hydrated" aria-label="logo linkedin"></ion-icon>
                </a></div>
            </div>
          </div>
        </div>


      </div>
      <div class="">
        <div class="p-2 pt-3  pb-3 text-center w3-theme-d3">(c) Thanosapi by Njofa <?php date('Y') ?></div>
      </div>
      <!-- footer -->
    </div>
  </div>
  </div>
  <!-- email content -->
</div>

<!-- modal -->

<!-- snack bar -->
<div class="snackbar" id="snackbar"></div>
<!-- snack bar -->



<!-- foorwe -->
<!-- Footer -->
<footer class="page-footer font-small bg-main text-light ">

  
  <!-- Copyright Powered by njofa engine -->
  <div class="footer-copyright text-center opacity-8 py-3 bg-dark" style="font-weight: 600px;font-size: 12px;">

    <div class="row py-2 w3-center">

      <div class="col-12">
        <div class="d-flex justify-content-center w3-small">
          <div class="pr-3 py-3"> <a class="text-white" href="/privacy/terms">Terms of Use</a></div>
          <div class="p-3"> <a class="text-white" href="/privacy/privacy-policies">Privacy Policies</a></div>
          <div class="p-3 pr-3"> <a class="text-white" href="/#about">About</a></div>
          <div class="p-3"> <a class="text-white" href="/#contact-us">Contact Us</a></div>
          <div class="p-3 pr-3"> <a class="text-white" href="/#stones">Api Stones</a></div>

        </div>
      </div>
    </div>
    © <?php echo date('Y') ?> Copyright 
    <a href="https://njofa.com/" target="_blank" class="text-light"> Njofa Group Inc</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->

<!-- footer -->






<div class="snackbar" id="snackbar"></div>

<?php
// echo $this->func->rightButtons();
?>

<!--include javascripts-->









<!-- JS PLUGIN -->
<script type="text/javascript" src="/public/js/libraries/lightbox.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.4/plyr.min.js"></script> -->

<!--include javascripts-->

<?php

foreach ($this->LOAD_JS as $key => $value) {
  if ($key == 'main') {
    foreach ($value as $ky => $file) {
      $file = '/public/js/app/' . $file;
      echo '<script src="' . $file . '"> </script>';
    }
  } else {

    // note for other source make sure to include the full path
    if ($key == 'link') {
      $link = $this->LOAD_JS['link'];
      //                 echo $link;
      if (array_key_exists('Files', $this->LOAD_JS)) {
        foreach ($this->LOAD_JS['Files'] as $k => $fileArr) {
          $files = $link . $fileArr;

          if (file_exists($files)) {
            echo '<script src="' . $files . '"> </script>';
          }
        }
      }
    } elseif ($key == 'root') {
      foreach ($value as $ky => $file) {
        if (file_exists($file) || str_replace('http', '', $file)) {
          echo '<script src="' . $file . '"> </script>';
        }
      }
    }
  }
}

if (!empty($this->runJsFunction)) {
  echo '<script>' . $this->runJsFunction . "</script>";
}
?>

<!--include javascripts-->

</body>

</html>
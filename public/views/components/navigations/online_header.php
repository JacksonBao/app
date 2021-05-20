<!DOCTYPE html>
<html>

<head>
  <title><?php echo @$this->pageTitle ?: 'Welcome to thanosapi'; ?></title>
  <!-- flavicon and app icon  -->

  <!-- meta tags -->
  <?php

  if (!empty($this->metaTags)) {
    echo $this->metaTags;
  }
  ?>
  <!-- meta tags -->



  <link rel="apple-touch-icon" sizes="57x57" href="/config/app_icon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/config/app_icon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/config/app_icon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/config/app_icon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/config/app_icon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/config/app_icon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/config/app_icon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/config/app_icon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/config/app_icon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/config/app_icon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/config/app_icon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/config/app_icon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/config/app_icon/favicon-16x16.png">
  <link rel="manifest" href="/config/app_icon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/config/app_icon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- end flavicon and map icon -->


  <!-- meta tag -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
  <meta http-equiv="Content-Type" content="text/css" charset="utf-8" />
  <!-- meta tag -->

  <!-- include css -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.4/plyr.css"> -->
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/fa/all.min.css">

  <link rel="stylesheet" type="text/css" href="/public/css/libraries/w3/w3-css.css">
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/bs/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/ion/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/animate.css">
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/lightbox.css">
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/offline-theme-default.css">
  <link rel="stylesheet" type="text/css" href="/public/css/libraries/awesome-bootstrap-checkbox.css">


  <?php
  if (@isset($this->LOAD_CSS) && is_array($this->LOAD_CSS) && count($this->LOAD_CSS) > 0) {
    foreach ($this->LOAD_CSS as $key => $url) {
      echo '<link rel="stylesheet" type="text/css" href="' . $url . '">';
    }
  }
  ?>

  <link rel="stylesheet" type="text/css" href="/public/css/app/arrow.css">
  <link rel="stylesheet" type="text/css" href="/public/css/app/scrolls.css">
  <link rel="stylesheet" type="text/css" href="/public/css/app/style.css">
  <link rel="stylesheet" type="text/css" href="/public/css/app/wallet.theme.css">


  <!-- include css -->
  <!-- JS PLUGIN -->
  <script type="text/javascript" src="/public/js/libraries/jquery.min.js"></script>
  <script type="text/javascript" src="/public/js/libraries/pp/popper.min.js"></script>
  <script type="text/javascript" src="/public/js/libraries/bs/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script> -->
  <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
  <!-- JS PLUGIN -->
</head>

<body class="bg">


  <!-- header -->
  <!--Navbar Main-->
  <div class="navbar bg-light p-0 border-bottom fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap w-100 py-3 ">
        <div class="p-0 col-6 d-block border-0 d-md-none align-self-center" style="height: 36px;
          overflow: hidden;">
          <a href="/">
          <img src="/public/img/app/logo.png" class="rounded-circle mr-2" height="36px">
          <b class="text-main font-weight-bold opacity">Thanosapi <sup class="badge badge-danger badge-sm">1.0</sup></b>
          </a>
        </div>
        <div class="p-0 col-6 pt-2 pointer text-right d-block border-0 d-md-none align-self-center" style="height: 36px;
          overflow: hidden;" id="sidebarCollapse">
          <i class="fa fa-bars"></i>
        </div>

        <div class="p-0 col-4 d-none border-0 d-md-block col-md-3 col-lg-4 align-self-center" style="height: 36px;
          overflow: hidden;" id="sidebarCollapse">
          <a href="/">
          <img src="/public/img/app/logo.png" class="rounded-circle mr-2" height="36px">
          <b class="text-main font-weight-bold opacity">Thanosapi 
          <sup class="badge badge-danger badge-sm">1.0</sup>
          </b>
          </a>
        </div>



        <div class="p-0 col-2 col-md-8 col-lg-8 d-none border-0 d-md-block">
          <div class="d-flex flex-wrap justify-content-end w-100 ">

            <!-- <div class="mx-1 text-hv-third d-none px-2  _cont_36 _text_12">
            <span class="notify bg-third">5</span>
            <img src="/public/img/app/ck_fm_avatar.png" class="rounded-circle float-left mr-2" height="36px">
            <div class="align-self-center float-left">
              <small>Sign In</small> <br> <span class="">Join Free</span>
            </div>
          </div> -->


            <div class="mx-1 text-hv-third p-2  align-self-center _cont_36 _text_12">
              <b class=""><a href="/#about">About</a></b>
            </div>


            <div class="mx-1 text-hv-third p-2 align-self-center _cont_36 _text_12">
              <b class=""><a href="/#stones">Stones</a></b>
            </div>


            <div class="mx-1 p-2  text-hv-third align-self-center _cont_36 _text_12">
              <b class=""><a href="/#contact-us">Contact Us</a></b>
            </div>



            <div class="mx-1 border-left text-hv-third p-2 align-self-center _cont_36 _text_12">
              <b> <a href="/dashboard"><img src="<?php echo $_SESSION['user']['avatar'] ?>" style="height:20px" alt=""> <?php echo $_SESSION['user']['name'] ?></a></b>
            </div>

            <div class="mx-1 text-hv-third p-2 align-self-center _cont_36 _text_12">
              <div class="align-self-center float-left">
                <b class=""><a href="/auth/logout">logout</a></b>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
  <!--Navbar Main-->

  </div>
  <!-- navbar sub -->


  <!-- header -->

  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" class="scroll-sm bg-light">

      <div id="dismiss" class="bg-dark rounded-pill bg-hv-third">
        <i class="fas fa-arrow-left"></i>
      </div>

      <div class="sidebar-header bg-main  px-2">
        <div class="align-self-center text-white" style="line-height: 35px;font-weight: 700">
            <b> <a href="/dashboard" class="text-white"><img src="<?php echo $_SESSION['user']['avatar'] ?>" style="height:20px" alt=""> <?php echo $_SESSION['user']['name'] ?></a></b>
        </div>
      </div>

      <div class="sideBarCont">
        <ul class="list-unstyled components">
          <p>Quick Links</p>
          <li class="">
            <a href="/#about">About</a>
          </li>
          <li>
            <a href="/#stones">Stone</a>
          </li>
          <li>
            <a href="/#contact-us">Contact Us</a>
          </li>
         
          <li><a href="/auth/logout"><i class="fa fa-user font-weight-light"></i> Log Out</a></li>
          <li><a href="/privacy/terms">Terms of use</a></li>
          <li><a href="/privacy/privacy-policies">Privacy Policies</a></li>
        </ul>
      </div>
      <div class="sidebar-footer bg-main text-center p-3">
        &copy; Copyright <?php echo date('Y'); ?>
      </div>


    </nav>

    <div class="overlay"></div>
  </div>

  <!-- add additional header -->
  <?php
  if (count($this->subHeader) > 0) {
    foreach ($this->subHeader as $key => $headerSubFile) {
      include_once $headerSubFile;
    }
  }
  ?>

  <!-- alert boxed -->
  <?php
  if ($this->alertStatus == true) {
    echo '<div class="container p-2 my-3"><div class="alert alert-danger p-3">' . $this->alertMessage . '</div></div>';
  }
  ?>
  <!-- alert boxed -->






  <!-- share links -->
  <div class="sharethis-inline-share-buttons"></div>
  <!-- share links -->


  <!-- body begins -->
  <div id="app">

<!DOCTYPE html>
<html>
    <head> 
        <title><?php echo @$this->pageTitle ?: 'Welcome to Njofa'; ?></title>
        <!-- flavicon and app icon  -->

     <!-- meta tags -->
        <?php 

        if(!empty($this->meta)){
            echo $this->meta;
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
        <link rel="icon" type="image/png" sizes="192x192"  href="/config/app_icon/android-icon-192x192.png">
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
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/fa/all.min.css" >

        <link rel="stylesheet" type="text/css" href="/public/css/libraries/w3/w3-css.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/bs/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/ion/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/animate.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/lightbox.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/offline-theme-default.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/awesome-bootstrap-checkbox.css">


        <?php
            if(@isset($this->css) && is_array($this->css) && count($this->css) > 0){
                foreach ($this->css as $key => $url) {
                    echo '<link rel="stylesheet" type="text/css" href="'.$url.'">';
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
    <div class="d-flex w-100 py-2 ">
      <div class="p-0 col-4 col-md-3 col-lg-2 align-self-center" style="    height: 36px;
    overflow: hidden;">
          <img src="/public/img/app/logo.png" class="rounded-circle mr-2" height="36px">
          <b class="text-main font-weight-bold opacity">Njofa Market</b>
      </div>
      <div class="p-0 col-8  col-md-5 col-lg-6 align-self-center">
        <div class="input-group w-100">
          <div class="input-group-prepend d-none d-md-block">
              <select class="custom-select" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px; ">
                <option>Product</option>
                <option>Seller</option>
              </select>
          </div>
          <input type="text" class="form-control border-right-0" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
          <div class="input-group-append  px-3 border">
            <a href="#" class="align-self-center w3-opacity w3-hover-opacity-0"><i class="fa fa-cog"></i></a>
          </div>
          <div class="input-group-append">
              <button class="btn btn-third"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </div>

      <div class="p-0 col-2 col-md-4 col-lg-4 d-none border-0 d-md-block">
        <div class="d-flex flex-wrap justify-content-end w-100 ">
          
          <div class="mx-1 text-hv-third  px-2  _cont_36 _text_12">
            <span class="notify bg-third">5</span>
            <img src="/public/img/app/ck_fm_avatar.png" class="rounded-circle float-left mr-2" height="36px">
            <div class="align-self-center float-left">
              <small>Sign In</small> <br> <span class="">Join Free</span>
            </div>
          </div>


          <div class="mx-1 text-hv-third  flex- px-2 align-self-center _cont_36 _text_12">
            <span class="notify bg-third">3</span>
            <i class="fa fa-heart w3-xlarge float-left font-weight-light mt-2 mr-2" style="line-height: 20px;"></i>
            <div class="align-self-center float-left">
              <small>Watch</small> <br> <b class="">List</b>
            </div>
          </div>


          <div class="mx-1  flex- px-2  text-hv-third align-self-center _cont_36 _text_12">
            <span class="notify bg-third">2</span>
            <i class="fa fa-list w3-xlarge float-left  mt-2 mr-2" style="line-height: 20px;"></i>
            <div class="align-self-center float-left">
              <small> Shopping</small> <br> <b class="">List</b>
            </div>
          </div>



          <div class="mx-1 text-hv-third  flex- px-2 align-self-center _cont_36 _text_12">
            <span class="notify bg-third">9</span>
            <i class="fa fa-shopping-cart w3-xlarge float-left  mt-2 mr-2" style="line-height: 20px;"></i>
            <div class="align-self-center float-left">
              <small>My</small> <br> <b class="">Cart</b>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<!--Navbar Main-->

<!-- navbar sub -->
<div class="navbar bg-light p-0 border-bottom" style="margin-top: 50px">
  <div class="container">
    <div class="d-flex w-100 py-2 ">
      <div class="p-0 col-4 col-md-3 col-lg-2 align-self-center">
        <div class="d-flex justify-content-start ">  
          <div class=" align-self-center pr-3 " id="sidebarCollapse">
            <i class="fa fa-bars"></i> 
          </div>
          <div class="_text_14" >
            <select class="custom-select border-0 border-right rounded-0">
              <option>Categories</option>
              <option>Books</option>
            </select>
          </div>
        </div>
      </div>

      <div class="p-0 col-8 col-md-5 col-lg-6 align-self-center">
        <div class="d-flex flex-wrap _text_12">
          <div class="pr-2">
            <a href="#">
              Best Sellers
            </a>
          </div>
          <div class="px-2"><a href="#">New Release</a></div>
          <div class="px-2 "><a href="#">Shops</a></div>
          <div class="px-2 d-none d-md-block"><a href="#">Home & Garden</a></div>
          <div class="px-2 d-none d-md-block"><a href="#">Electronics</a></div>
          <div class="px-2 d-none d-md-block mr-auto"><a href="#">Deals</a></div>
          <div class="px-2"><a href="#"><b style="font-weight: 900">Sell</b></a></div>
          <div class="px-2"><a href="#"><b style="font-weight: 900">Help</b></a></div>
        </div>
      </div>

      <div class="p-0 col-4 col-md-4 col-lg-4 align-self-center d-none d-md-block">
          <div class="d-flex flex-wrap justify-content-end">
            <div class="text-dark align-self-center px-2">
              XAF
            </div>
            <div class="text-dark">
              <select class="custom-select border-0">
                <option>Cameroon</option>
              </select>
            </div>
          </div>
      </div>
  </div>
</div>

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
          <img src="/public/img/app/ck_fm_avatar.png" height="30px;" class="float-left mr-2"> 
          <div class="align-self-center" style="line-height: 35px;font-weight: 700">
            <b>Hello, Sign in</b>
          </div>
        </div>

        <div class="sideBarCont">
        <ul class="list-unstyled components componetList">
           <p>My Account</p>
            <li><a href="#"><span class="badge badge-third float-right">3</span> <i class="fa fa-heart font-weight-light"></i> Watch List</a></li>
            <li><a href="#"><span class="badge badge-third float-right">5</span> <i class="fa fa-list "></i> My Shopping List</a></li>
            <li><a href="#"><span class="badge badge-third float-right">9</span> <i class="fa fa-shopping-cart "></i> My Cart</a></li>

            <p>Shop by category</p>
            <li class="">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Home</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="#">Home 1</a>
                    </li>
                    <li>
                        <a href="#">Home 2</a>
                    </li>
                    <li>
                        <a href="#">Home 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">About</a>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="#">Page 1</a>
                    </li>
                    <li>
                        <a href="#">Page 2</a>
                    </li>
                    <li>
                        <a href="#">Page 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Portfolio</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>

           
        </ul>


            <ul class="list-unstyled components">
            <p>Help & Settings</p>
            <li class="">
              <a>My Account</a>
            </li>
            <li>
              <a>Shops</a>
            </li>
            <li>
              <a>Sell on Njofa</a>
            </li>
            <li>
               <div class="d-flex flex-wrap">
                  <div class="text-dark align-self-center px-2">
                    XAF
                  </div>
                  <div class="text-dark flex-fill">
                    <select class="custom-select border-0">
                      <option>Cameroon</option>
                    </select>
                  </div>
              </div>
            </li>

            <li><a>FAQ</a></li>
            <li><a>Help</a></li>
            </ul>
          </div>
    </nav>

    <div class="overlay"></div>
</div>




<!-- alert boxed -->
<?php 
  if($this->alertStatus == true){
    echo '<div class="container p-2 my-3"><div class="alert alert-danger p-3">'.$this->alertMessage.'</div></div>';
  }
?>
<!-- alert boxed -->






<!-- share links -->
<div class="sharethis-inline-share-buttons"></div> 
<!-- share links -->


        <!-- body begins -->
        <div id="app">

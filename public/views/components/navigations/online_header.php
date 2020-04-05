
<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/Article" prefix="og: http://ogp.me/ns#">
    <head> 
        <title><?php echo $this->pgTitle; ?></title>
     <!-- meta tags -->
        <?php 

        if(!empty($this->meta)){
            echo $this->meta;
        }
        ?>
        <!-- meta tags -->


        <!-- flavicon and app icon  -->

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
        <meta name="msapplication-TileColor" content="#444">
        <meta name="msapplication-TileImage" content="/config/app_icon/ms-icon-144x144.png">
        <meta name="theme-color" content="#444">
        <!-- end flavicon and map icon -->


        <!-- responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <!-- responsive -->


        <!-- include css -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.4/plyr.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/fa/all.min.css" >
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/ion/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/w3/w3.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/bs/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="/public/css/libraries/animate.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/lightbox.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/offline-theme-default.css">
        <link rel="stylesheet" type="text/css" href="/public/css/libraries/awesome-bootstrap-checkbox.css">

        <link rel="stylesheet" type="text/css" href="/v5/public/css/app/default.css">
        <link rel="stylesheet" type="text/css" href="/v5/public/css/app/wallet.theme.css">
        <link rel="stylesheet" type="text/css" href="/v5/public/css/app/arrow.css">
        <link rel="stylesheet" type="text/css" href="/v5/public/css/app/scrolls.css">



        <!-- insert css from files -->
        <?php
            if(is_array($this->css) && count($this->css) > 0){
                foreach ($this->css as $key => $url) {
                    echo '<link rel="stylesheet" type="text/css" href="'.$url.'">';
                }
            }
         ?>
        <!-- insert css from files -->



        <!-- include css -->
    <!-- JS PLUGIN -->
    <script type="text/javascript" src="/public/js/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/libraries/pp/popper.min.js"></script>
    <script type="text/javascript" src="/public/js/libraries/bs/bootstrap.min.js"></script>

    </head>
    <body onclick="headDropdown('close')">




        <!-- HEADER  -->

        <div class="ck_HD_Cnt container-fluid fixed-top">

            <div class="container ck-np-sm">
                <div class="row ck-np-sm">
                    <div class="col-2 col-sm-3 col-md-4 nj-ps">

                        <!-- text -->

                        <a href="/home"><img src="/ck_img_defaults/logo_txt.png" class="hdLogoTxt" style=""></a>

                        <!-- text -->    
                    </div>


                    <!-- right bar -->
                    <div class="col-10 col-sm-9 col-md-8 nj-ps">

                        <!-- links -->

                        <ul class="ckHD_list w3-text-white">

                            <li class="ckHDL_item"><a href="/Profile" title="Goto profile." class=""><img <?php echo $this->func->userData($this->logID,'av');  ?> style="height:25px; width: 25px;margin-top: -10px;border-radius: 100%;"> <?php echo $this->func->len($this->func->userData($this->logID,'fn'), 10);  ?></a></li>

                            <li class="ckHDL_item"><a href="/people" title="Find People"><i class="ion-android-people"></i> <span class="HCntSm">People</span> </a> </li>

                            <li class="ckHDL_item"><a title="Search Njofa" href="/search" ><i class="ion-search"></i> <span class="HCntSm">Search</span>  </a> </li>

                            <li onclick="headDropdown('_hdNote')"  class="ckHDL_item p-0 pl-sm-3 px-3"><a href="javascript:void(0);" title="View notifications" ondblclick="allNotes();"><span class="ion-android-notifications"></span> <?php //echo $noteBar;  ?> </a></li>
                            <li onclick="headDropdown('_hdMenu')"  class="ckHDL_item px-3"><a href="javascript:void(0);" title="Goto Menu"><span class="ion ion-android-apps"></span> <?php //echo $noteBar;  ?> </a></li>


<!-- <li class="ckHDL_item"  onclick="ckLoadMenu('More')"><a href="javascript:void(0);" title="More" ondblclick="ckMenu('More');">More<span class="caret"></span>   </a></li> -->



                            <li class="ckHDL_item"><a title="Get Help!" href="/v5/help/"><i class=" ion ion-help"></i></a></li>



                        </ul>

                        <!-- links -->

                    </div>

                    <!-- right bar -->
                </div>

            </div>
        </div>


        <!-- end header -->
    <!-- NAVIGATION DROPDOWNS -->
    <div class="container-fluid w3-padding-0 p-0" id="" style="">
        <div class="container ck-np-sm clearfix">
<div class="d-flex" style="margin-top: -13px;">
  <div class="ml-auto  p-2 clearfix" style="position: fixed;right: 9%;margin-top: 7px;z-index: 2000 !important;">

  <div class="u-sm-tl w3-hide w3-right _hdCarets" id="_hdMenuCaret" style="right: 16%;position: absolute;"></div>
  <div class="u-sm-tl w3-right w3-hide _hdCarets " id="_hdNoteCaret" style="right:31.5%;position: absolute;"></div>
  
  <div class="w3-hide w3-card-4" data-hddropdown="0" data-inview="0" id="_hdDropdownCnt" style="width:320px;min-height:350px; background: #fff;margin-top: 10px;overflow: hidden;" class="w3-round w3-card-4">

<!-- NOTIFICATIONS -->
<div class="w3-hide _hdDropdown" id="_hdNote">
        <!-- menu section -->
        <div class="w3-border-bottom w3-padding" style="background-color: #00838f">
            <h4 class="lead w3-text-white m-0"><i class="ion ion-android-notifications"></i>  Notifications <span class="badge badge-sm badge-dark float-right" id="_hdNoteCnt">0</span> </h4>
        </div>
        <!-- menu section -->

        <!-- notification body -->
        <div id="_hdNoteInner" class="noteHDBD  scroll-xs" style="">
            
        </div>
        <!-- notification body -->

</div>
<!-- NOTIFICATIONS -->

        
        <!-- QUICK NAVIGATI ONS -->
        <div class="w3-hide _hdDropdown" id="_hdMenu">
        <!-- menu section -->
        <div class="w3-border-bottom w3-padding" style="background-color: #00838f">
            <h4 class="lead w3-text-white m-0"><i class="ion ion-android-apps"></i> Menu</h4>
        </div>
        <!-- menu section -->

        <div class="w3-padding-small" style="padding-top:20px !important;padding-bottom: 20px !important;">
                <div class="d-flex d-flex-wrap justify-content-between w3-center">
                    <div class="p-2 mb-4">
                       <a href="/profile" class="w3-text-grey" title="Goto your profile."> 
                        <div style="border-radius:50%;height: 60px;width: 60px;background-color: #ddd;margin:0px auto 5px;overflow:hidden;">
                            <img style="width:60px;margin:0px auto;" >
                        </div>
                        James Doe
                    </a>
                    </div>


                    <div class="p-2 mb-4">
                       <a href="http://wallet.njofa.com/" class="w3-text-grey" title="Goto your wallet."> 
                        <div style="border-radius:50%;height: 60px;width: 60px;background-color: #ddd;margin:0px auto 5px;line-height: 60px;">
                            <!-- <i class="ion-ios-pulse w3-xxlarge" ></i> -->
                            <img src="/v5/public/img/svg/nj_wallet.svg" style="height: 27px">
                        </div>
                        Wallet
                        </a>
                    </div>


                    <div class="p-2 mb-4">
                       <a href="/shopping" class="w3-text-grey" title="Goto shopping."> 
                        <div style="border-radius:50%;height: 60px;width: 60px;background-color: #ddd;margin:0px auto 5px;line-height: 60px;">
                            <i class="ion-ios-pricetags-outline w3-xxlarge"></i>
                        </div>
                        Shopping
                       </a>
                    </div>
                </div>

                    <div class="d-flex d-flex-wrap justify-content-between w3-center">
                    <div class="p-2 mb-4">
                       <a href="/home" class="w3-text-grey" title="Goto your office conner."> 
                        <div style="border-radius:50%;height: 60px;width: 60px;background-color: #ddd;margin:0px auto 5px;line-height: 60px;">
                            <i class="ion-ios-home-outline w3-xxlarge"></i>
                        </div>
                        v5 Home
                        </a>
                    </div>


                    <div class="p-2 mb-4">
                       <a href="/work" class="w3-text-grey" title="Goto your work profile"> 
                        <div style="border-radius:50%;height: 60px;width: 60px;background-color: #ddd;margin:0px auto 5px;line-height: 60px;">
                            <i class="ion-ios-briefcase-outline w3-xxlarge"></i>
                        </div>
                        Work
                        </a>
                    </div>


                    <div class="p-2 mb-4">
                       <a href="/mycart.co" class="w3-text-grey" title="Goto your cart"> 
                        <div style="border-radius:50%;height: 60px;width: 60px;background-color: #ddd;margin:0px auto 5px;line-height: 60px;">
                            <i class="ion-ios-cart-outline w3-xxlarge"></i>
                        </div>
                        My Cart
                       </a>
                    </div>
                </div>
                </div>
        <!-- QUICK NAVIGATIONS -->


        </div>

        <div class="w3-padding-small w3-hide">
            <ul class="w3-ul">
                <li>Profile</li>
                <li>Shop</li>
                <li>My Cart</li>
                <li>Wallet</li>
                <li>Work <span class="badge badge-sm badge-primary float-right">3</span></li>
                <li>Office <span class="badge badge-sm badge-danger float-right">4</span> </li>
            </ul>
        </div>


  </div>
</div>
</div>
        </div>

    </div>
<!-- NAVIGATION DROPDOWNS -->


<!-- share links -->
<div class="sharethis-inline-share-buttons"></div> 
<!-- share links -->

        <!-- body begins -->
        <div class="container-fluid p-0">
            
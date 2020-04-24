<?php
namespace App\Market\Traits;
/**
*
*/
Trait View
{

  public $header = [];
  public $footer = [];
  public $subHeader = [];

  Public $headerObj = [];
  Public $footerObj = [];
  public $addHeaders = ['shop', 'dash'];
  public $urlNavigation = [
    "DEFAULT" => [
      'en' => [
        "HEADER" => array('public/views/components/navigations/online_header.php'),
        "FOOTER" => array('public/views/components/navigations/online_footer.php'),
        "DASH_HEADER" => array('public/views/components/shop/online_dash_header.php'),
        "DASH_FOOTER" => array('public/views/components/shop/online_dash_footer.php'),
        "SHOP_HEADER" => array('public/views/components/shop/online_shop_header.php'),
        "SHOP_FOOTER" => array('public/views/components/shop/online_shop_footer.php')
      ]
    ],
    "ERROR" => [
      'en' => [
        "HEADER" => array('public/views/components/navigations/offline_header.php'),
        "FOOTER" => array('public/views/components/navigations/offline_footer.php'),
        "DASH_HEADER" => array('public/views/components/shop/offline_dash_header.php'),
        "DASH_FOOTER" => array('public/views/components/shop/offline_dash_footer.php'),
        "SHOP_HEADER" => array('public/views/components/shop/offline_shop_header.php'),
        "SHOP_FOOTER" => array('public/views/components/shop/offline_shop_footer.php')
      ]
    ]
  ];


  public function render($page = false)
  {

    $file = DEFAULT_APP_PATH . 'public/views/pages/'.$this->directory.'/' . $page . '.php';
    if (!file_exists($file)) {
      // return 404
      $file = $this->errorPage();
    }

    if ($this->headerType == FALSE) {// laod error header
      $this->headerObj = $this->urlNavigation['ERROR']['en'];
      $this->header = $this->headerObj['HEADER'];
      // include shop header and dash header
      if(strpos('dash', $this->directory) >= 0){
        array_push($this->subHeader, $this->headerObj['DASH_HEADER'][0]);
      }
      if($this->directory == 'shop'){
        array_push($this->subHeader, $this->headerObj['SHOP_HEADER'][0]);
      }
      // include shop header and dash header

      $this->footerObj = $this->urlNavigation['ERROR']['en'];
      $this->footer = $this->footerObj['FOOTER'];
      // include shop header and dash header
      if(strpos('dash', $this->directory) >= 0){
        array_push($this->footer, $this->headerObj['DASH_FOOTER'][0]);
      }
      if($this->directory == 'shop'){
        array_push($this->footer, $this->headerObj['SHOP_FOOTER'][0]);
      }
      // include shop header and dash header

    } elseif ($this->headerType == 1) { // load defalt header
      $this->headerObj = $this->urlNavigation['DEFAULT']['en'];
      $this->header = $this->headerObj['HEADER'];
      // include shop header and dash header
      if($this->directory == 'dash'){
        array_push($this->subHeader, $this->headerObj['DASH_HEADER'][0]);
      }
      if($this->directory == 'shop'){
        array_push($this->subHeader, $this->headerObj['SHOP_HEADER'][0]);
      }
      // include shop header and dash header

      $this->footerObj = $this->urlNavigation['DEFAULT']['en'];
      $this->footer = $this->footerObj['FOOTER'];
      // include shop header and dash header
      if($this->directory == 'dash'){
        array_push($this->footer, $this->headerObj['DASH_FOOTER'][0]);
      }
      if($this->directory == 'shop'){
        array_push($this->footer, $this->headerObj['SHOP_FOOTER'][0]);
      }
      // include shop header and dash header
    } else {
      $this->header = '';
      $this->footer = '';
    }


    // check if the header and footer file exist
    if (is_array($this->header)) {
      foreach ($this->header as $value){
        include_once DEFAULT_APP_PATH . $value;
      }
    }
    // check if the header and footer file exist

    // check if the header and footer file exist
    $this->compiler($file);
    include_once $file;

    // check if footer exist and include
    if (is_array($this->footer)) {
      foreach ($this->footer as $value) {
        include_once DEFAULT_APP_PATH . $value;
      }
    }


  }

  private function compiler(string $file)
  {
    $filedate =date('d', strtotime(filemtime($file)));
    if($filedate != date('d')) {
    $myfile = fopen($file, "r+") or die("Unable to open file!");
      $content = file_get_contents($file);
      if(str_replace('{{!', '', $content)){
        $content = str_replace( ['{{!', '!}}'], [' <?php ', ' ?> '], $content);
        fwrite($myfile, $content);
      }
      fclose($myfile);
    }
    return true;
  }

}

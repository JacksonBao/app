<?php
namespace App\APP_NAME\Traits;
/**
 *
 */
trait View
{

  public $header = [];
  public $footer = [];
  public $subHeader = [];

  public $viewHeader = 'ONLINE';
  public $headerLang = 'en';
  public $headerKey = 'HEADER';
  public $footerKey = 'FOOTER';

  public $headerObj = [];
  public $footerObj = [];
  public $addHeaders = ['shop', 'dash'];
  public $urlNavigation = [
    "ONLINE" => [
      'en' => [
        "HEADER" => array('public/views/components/navigations/online_header.php'),
        "FOOTER" => array('public/views/components/navigations/online_footer.php')
      ]
    ],
    "OFFLINE" => [
      'en' => [
        "HEADER" => array('public/views/components/navigations/offline_header.php'),
        "FOOTER" => array('public/views/components/navigations/offline_footer.php'),
      ]
    ],
    "ADMIN" => [
      'en' => [
        "HEADER" => array(PARENT_ROOT . '/njofa/admin/render/resource/online_header.php'),
        "FOOTER" => array(PARENT_ROOT . '/njofa/admin/render/resource/online_footer.php'),
      ]
    ]
  ];



  public function render($page = false, string $type = '')
  {
    $rightButton = $this->rightButtons();
    $file = WALLET_DEFAULT_APP_PATH . 'public/views/pages/' . $this->directory . '/' . $page . '.php';
    if (!file_exists($file)) {
      // return 404
      $file = $this->errorPage();
    } else {
      // change header type
      if ($type != '') {
        $this->headerType = $type;
      } else {
        // check if user is logged in
        if ($this->WALLET_UNIQ != FALSE && $this->viewHeader != 'OFFLINE') {
          $this->headerType = 1;
          $user = new \App\APP_NAME\Table\Classes\Users();
          $this->USER_DETAILS = $user->getUser();
          $sq = $this->in_query("SELECT COUNT(id) FROM nj_wl_notifications WHERE receiver = '$this->WALLET_UNIQ' and status = '0'");
          $this->USER_DETAILS['count_notifications'] = $sq->fetch_row()[0];
        }
      }


      if ($this->headerType == FALSE) { // laod error header
        $this->headerObj = $this->urlNavigation['OFFLINE'][$this->headerLang];
        $this->header = $this->headerObj['HEADER'];
        // include shop header and dash header
        if (strpos('dashboard', $this->directory)  != false) {
          array_push($this->subHeader, $this->headerObj['DASH_HEADER'][0]);
        }
        // include shop header and dash header

        $this->footerObj = $this->urlNavigation['OFFLINE']['en'];
        $this->footer = $this->footerObj['FOOTER'];
        // include shop header and dash header
        if (strpos('dashboard', $this->directory) > 0) {
          array_push($this->footer, $this->headerObj['DASH_FOOTER'][0]);
        }
        // include shop header and dash header

      } elseif ($this->headerType == 1) { // load defalt header
        $this->headerObj = $this->urlNavigation[$this->viewHeader][$this->headerLang];
        $this->header = $this->headerObj[$this->headerKey];

        $this->footerObj = $this->urlNavigation[$this->viewHeader][$this->headerLang];
        $this->footer = $this->footerObj[$this->footerKey];
        // setup params for admin
        if ($this->viewHeader == 'ADMIN') {
          $this->logID = $this->USER_ID;
          $this->func = $this;
          // include api connector
          include_once PARENT_ROOT . '/api.njofa/config/php/app.db.connect.static.php';
          $this->db = \App\Api\Config\ApiConnectStatic::connectSocial();
          if(ENV == 'PRODUCTION'){
          // set folder path
          include_once PARENT_ROOT . 'v5/config/php/db_connector.php';
          include_once PARENT_ROOT . 'v5/config/php/ck_protect_file.php';
          include_once PARENT_ROOT . 'v5/libs/authentication.php';
          // include_once "../ck_inc_files/ck_hd_incFiles.php";
          // include_once getcwd() ."/../wallet/ck_wl_include/ck_wa_inc.php";
          include_once PARENT_ROOT . 'v5/libs/functions.php';
          $this->func = new \nj\func\functions();
          }
          // include v5 functions
          $this->pgTitle = $this->pageTitle;
          define('FOLDER_PATH', PARENT_URL);
          $this->logID = $this->USER_UNIQ;

          $this->loadJs['root'] = array_merge($this->loadJs['root'], [PARENT_URL . '/admin/public/js/default.js']);
          
          $iconFiles = '
            <link rel="stylesheet" type="text/css" href="/public/css/libraries/ion/ionicons.css">
            <link rel="stylesheet" type="text/css" href="/public/css/libraries/fa/all.min.css">
            <link rel="stylesheet" type="text/css" href="/public/css/app/style.css">
            <link rel="stylesheet" type="text/css" href="/public/css/app/wallet.theme.css">
            <link rel="stylesheet" type="text/css" href="https://www.njofa.com/ck_css_file/action_button.css">
            
          ';
          // add content js to file list
          if(isset($this->content) && is_array($this->content) && array_key_exists('scripts', $this->content)){
            $this->loadJs['root'] = array_merge($this->loadJs['root'], $this->content['scripts']);
          }
          // die(var_dump($this->loadJs));
          $this->runJsFunction .= ' listNav(\'wallet\'); ';
          $this->source = 'wallet';

          if(isset($this->content) && is_array($this->content) && array_key_exists('runScript', $this->content)){
            $this->runJsFunction .=  $this->content['runScript'];
          } 
          $this->js = $this->loadJs;
          $this->runJsFunc = $this->runJsFunction;
        }
      } else {
        $this->header = '';
        $this->footer = '';
      }


      // check if the header and footer file exist
      if (is_array($this->header)) {
        foreach ($this->header as $value) {
        // die(var_dump($value));
          include_once WALLET_DEFAULT_APP_PATH . $value;
        }
      }
      // check if the header and footer file exist

      // check if the header and footer file exist
      $this->compiler($file);
      include_once $file;

      // check if footer exist and include
      if (is_array($this->footer)) {
        foreach ($this->footer as $value) {
          include_once WALLET_DEFAULT_APP_PATH . $value;
        }
      }
    }
  }

  private function compiler(string $file)
  {
    $filedate = date('d', strtotime(filemtime($file)));
    // if($filedate != date('d')) {
    $myfile = fopen($file, "r+") or die("Unable to open file!");
    $content = file_get_contents($file);
    if (str_replace('{{!', '', $content)) {
      $content = str_replace(['{{!', '!}}'], ['<?php ', ' ?>'], $content);
      fwrite($myfile, $content);
    }
    fclose($myfile);
    // }
    return true;
  }
}

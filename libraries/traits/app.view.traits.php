<?php

namespace Traits;

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
    $file = DEFAULT_APP_PATH . 'public/views/pages/' . $this->LOAD_DIR . '/' . $page . '.php';
    if (!file_exists($file)) {
      // return 404
      $file = $this->errorPage();
    } else {
      // change header type
      if ($type != '') {
        $$this->HEADER_TYPE = $type;
      } else {
        // check if user is logged in
        
      }
      
      if($this->model->USER_UNIQ){
        $this->viewHeader = 'ONLINE';
        $$this->HEADER_TYPE = 1;
      }

      if(in_array($this->LOAD_DIR, $this->AUTH_LINKS) && empty($this->model->USER_UNIQ)){
        header('location: /#login');
      }

      $this->metaTags = $this->generateMeta();

      if ($$this->HEADER_TYPE == FALSE) { // laod error header
        $this->headerObj = $this->urlNavigation['OFFLINE'][$this->headerLang];
        $this->header = $this->headerObj['HEADER'];
        // include shop header and dash header
        if (strpos('dashboard', $this->LOAD_DIR)  != false) {
          array_push($this->subHeader, $this->headerObj['DASH_HEADER'][0]);
        }
        // include shop header and dash header

        $this->footerObj = $this->urlNavigation['OFFLINE']['en'];
        $this->footer = $this->footerObj['FOOTER'];
        // include shop header and dash header
        if (strpos('dashboard', $this->LOAD_DIR) > 0) {
          array_push($this->footer, $this->headerObj['DASH_FOOTER'][0]);
        }
        // include shop header and dash header

      } elseif ($$this->HEADER_TYPE == 1) { // load defalt header
        $this->headerObj = $this->urlNavigation[$this->viewHeader][$this->headerLang];
        $this->header = $this->headerObj[$this->headerKey];

        $this->footerObj = $this->urlNavigation[$this->viewHeader][$this->headerLang];
        $this->footer = $this->footerObj[$this->footerKey];
        // setup params for admin
        if ($this->viewHeader == 'ADMIN') {
         
          // include v5 functions
          $this->pgTitle = $this->pageTitle ?: $_ENV['appname'];
          $this->logID = $this->USER_UNIQ;
          // add content js to file list
          if (isset($this->content) && is_array($this->content) && array_key_exists('scripts', $this->content)) {
            $this->LOAD_JS['root'] = array_merge($this->LOAD_JS['root'], $this->content['scripts']);
          }
          
        }
      } else {
        $this->header = '';
        $this->footer = '';
      }


      // check if the header and footer file exist
      if (is_array($this->header)) {
        foreach ($this->header as $value) {
          // die(var_dump($value));
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

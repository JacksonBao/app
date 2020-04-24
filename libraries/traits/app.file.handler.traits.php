<?php
namespace App\Market\Traits;
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
Use \Gumlet\ImageResize;
Use \App\Market\Libraries\Functions;

Trait Uploader {

  public $tmp;
  public $opt;
  public $ext;
  public $tempLoc;
  public $options;
  public $upStatus;
  public $index;

  public $handleFiles = [];
  public $fileHandleOption = ['sub_location' => '', 'user_type' => '', 'user' => 'temporal', 'filename_append' => '', 'sizes' => [
    'original' => '1920x1200', 'medium' => '1024x768', 'small' => '512x512', 'tiny' => ''
  ], 'allow_enlarge' => true];
  public $fileHandleLocation = [];
  public $imageRootFolder = '';
  public $fileHandleDatabseResponse = [];
  public $imageRoot = 'http://im.njofa.dv';

  public $imgArr = ['png', 'jpg', 'gif', 'jpeg'];
  public $vidArr = ['mp4'];
  public $audArr = ['mp3'];
  public $docs = ['txt', 'pdf', 'zip', 'x-zip', 'x-zip-compressed', 'csv', 'octet-stream'];//['txt', 'pdf', 'zip', 'csv'];

  public function newFileHandler()
  {
    $this->handleFiles = [];
    $this->fileHandleOption = ['sub_location' => '', 'user_type' => '', 'user' => '', 'filename_append' => '', 'sizes' => [
      'original' => '1920x1200', 'medium' => '1024x768', 'small' => '512x512', 'tiny' => ''
    ], 'allow_enlarge' => true];
    $this->fileHandleLocation = [];
    $this->imageRootFolder = '';
    $this->fileHhandleDatabseResponse = [];
  }
  public function intImageFolder()
  {
    $this->fileHandleLocation = [
      'page' => str_replace(APP_FOLDER, 'image.app', APP_ROOT) . '/market.app/page/' .$this->fileHandleOption['user']. '/' . date('Y') .'/' . date('m') . '/' . date('d') .'/',
      'user' => str_replace(APP_FOLDER, 'image.app', APP_ROOT) . '/market.app/user/' .$this->fileHandleOption['user']. '/' . date('Y') .'/' . date('m') . '/' . date('d') .'/',
      'visitor' => str_replace(APP_FOLDER, 'image.app', APP_ROOT) . '/market.app/visitor/' .$this->fileHandleOption['user']. '/' . date('Y') .'/' . date('m') . '/' . date('d') .'/',
      'temporal' => str_replace(APP_FOLDER, 'image.app', APP_ROOT) . '/market.app/temporal/' . date('Y') .'/' . date('m') . '/' . date('d') .'/'
    ];
    $this->imageRootFolder = str_replace(APP_FOLDER, 'image.app', APP_ROOT);

  }
  function extReset($loc, $opt){

    $this->tmp = @preg_replace('#[^a-zA-Z*]#i', '', $loc);
    $this->opt = $opt;
    $loc = $this->tmp;

    // declare accepted acceptable files
    $imgArr = ['png', 'jpg', 'gif', 'jpeg'];
    $vidArr = ['mp4'];
    $audArr = ['mp3'];
    $docs = ['txt', 'pdf', 'zip', 'x-zip', 'x-zip-compressed', 'csv', 'octet-stream'];
    // set cceptable extension
    $extArr = $this->imgArr; //  default is images
    if ($loc == 'i'){
      $extArr = $this->imgArr;
    }elseif ($loc == 'v'){
      $extArr = $this->vidArr;
    }elseif ($loc == 'a'){
      $extArr = $this->audArr;
    }elseif ($loc == 'd'){
      $extArr = $this->docs;
    }elseif ($loc == 'id'){
      $extArr = array_merge($this->imgArr, $this->docs);
    }elseif ($loc == 'iv'){
      $extArr = array_merge($this->imgArr, $this->vidArr);
    }elseif ($loc == "*"){
      $extArr = array_merge($this->imgArr, $this->vidArr, $this->audArr, $this->docs);
    }

    $this->ext = $extArr;
    //         end extension
    // options
    $optionArr = [
      'Default' => ['Size' => 100, 'Extensions' => $this->ext],
      'Small' => ['Size' => 50, 'Extensions' => $this->ext],
      'Large' => ['Size' => 128, 'Extensions' => $this->ext]
    ];

    $this->options = $optionArr[$opt];
    // end options
    //
    // define default  location
    // $this->tempLoc = 'https://img.njofa.com/tmp_upload/'; // location for temporal data
    $this->tempLoc = $this->getFileStoreImageFolder('temporal');//'public/tmp/'; // location for temporal data
    // define default  location
    // declare accepted acceptable files
  }


  public function getFileStoreImageFolder(string $location = 'temporal')
  {
    $this->intImageFolder();

    if(!array_key_exists($location, $this->fileHandleLocation)){ $location = 'temporal'; }
    // check if folder apc_exist
    $folder = @$this->fileHandleLocation[$location];

    if(!file_exists($folder)){
      $folderX = rtrim(str_replace($this->imageRootFolder, '', $folder), '/');
      $exp = explode('/', $folderX);
      $lks = $this->imageRootFolder.'/';
      foreach ($exp as $key => $value) {
        if($value == ''){continue;}
        $lks .= $value . '/';
        if (!file_exists($lks)) {
          mkdir($lks, 0755);
        } else {
          continue;
        }
      }
    }
    return $folder;
  }

  function uploadFile() {
    $filesArray = [];

    $ind = @preg_replace('#[^0-9]#', '', $_POST['ind']) ?: '0';
    $this->index = $ind;

    if (isset($_FILES['upFiles'])) {
      $loc = @preg_replace('#[^a-zA-Z*]#', '', $_POST['exts']) ?: 'i';
      $opt = @preg_replace('#[^a-zA-Z]#', '', $_POST['opt']) ?: 'Default';

      $files = $_FILES['upFiles'];

      $this->extReset($loc, $opt);
      $filesArray = $this->uploadMover($files);

    } else {
      $filesArray[0] = ['Status' => 0, 'Data'=>'Could not upload files.', 'Index' => $this->index];
    }
    return json_encode($filesArray);

  }

  function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last)
    {
      case 'g':
      $val *= 1024;
      case 'm':
      $val *= 1024;
      case 'k':
      $val *= 1024;
    }
    return $val;
  }

  function max_file_upload_in_bytes() {
    //select maximum upload size
    $max_upload = $this->return_bytes(ini_get('upload_max_filesize'));
    //select post limit
    $max_post = $this->return_bytes(ini_get('post_max_size'));
    //select memory limit
    $memory_limit = $this->return_bytes(ini_get('memory_limit'));
    // return the smallest of them, this defines the real limit
    return $max_upload .' | '. $max_post .' | '. $memory_limit;
  }

  function uploadMover($file) {
    $f_name = $file['name'];
    $f_size = $file['size'];
    $f_sizeOrg = round(($file['size'] / 1052675.49738), 5);
    $f_tmp = $file['tmp_name'];
    $f_error = $file['error'];



    // declare accepted acceptable files

    // set cceptable extension

    $f_ext = @strtolower(end(explode('.', $f_name)));
    // check file size
    $f_size = round(($file['size'] / 1052675.49738), 3);
    $option = $this->options;

    //        var_dump($option);


    if($f_size <= $option['Size']){
      // check file extension
      if(!empty($f_ext) && in_array($f_ext, $option['Extensions'])){

        //                CHECK FOR ERRORS

        // check for errors

        if ($f_error != UPLOAD_ERR_OK) {
          $err = '';
          switch ($f_error) {

            case UPLOAD_ERR_INI_SIZE:

            $err = "File size is too big. ". $this->max_file_upload_in_bytes();

            break;

            case UPLOAD_ERR_FORM_SIZE:

            $err = "Uploaded File is too big.";

            break;

            case UPLOAD_ERR_PARTIAL:

            $err = "File upload incomplete.";

            break;

            case UPLOAD_ERR_NO_FILE:

            $err =  "Sorry we could not upload file.";

            break;

            case UPLOAD_ERR_NO_TMP_DIR:

            $err = "Sorry we could not upload file.";

            break;

            case UPLOAD_ERR_CANT_WRITE:

            $err =  "Could not upload file";

            break;

            case 8:

            $err = "An error occured please refresh and try again.";

            break;

          }
          $this->upStatus = ['Status' => 0, 'Data' => $err, 'Index' => $this->index ];

        } else { // continue

          // RENAME FILE format: fileID_datetime_usid_sz

          $fileID = Functions::randKey(5,'');

          $datetime = time();
          $new_name = $fileID.'_NJOFA_TCS_'.$datetime.'.'.$f_ext;
          $destination = $this->tempLoc . $new_name;

          // move file
          if(move_uploaded_file($f_tmp, $destination)){
            $data = '';
            $destination = str_replace($this->imageRootFolder, $this->imageRoot, $destination);
            if(in_array($f_ext, $this->imgArr)){// pics
              $data = '<a href="'.$destination.'" data-lightbox="img" data-title="'.$f_name.'"><img src="'.$destination.'" class="img-responsive" style="width:100%;max-height:180px;"></a>';
            } elseif (in_array($f_ext, $this->vidArr) || in_array($f_ext, $this->audArr)){// video audio
              $data = '
              <div style="height:150px;width:100%;overflow:hidden;">

              <video controls style="max-height:150px;max-width:100%;overflow:hidden" poster=""   preload class="w3-col s12">

              <source src="'.$destination.'" type="video/mp4"></source>

              <source src="'.$destination.'" type="audio/mp3"></source>

              </video>

              </div>

              ';
            } else {// docs
              $data = '<div class="p-5 mr-4 font-weight-bold w3-xlarge w3-text-white">' . strtoupper($f_ext) . '</div>';
            }

            $this->upStatus = ['Status' => 200, 'Data' => $data, 'Url'=>$destination, 'Extension' => $f_ext, "OrgName" => $f_name, 'NwName' => $new_name, 'Index' => $this->index, 'Size' => $f_sizeOrg];
          } else {// could not move uploaded file
            $this->upStatus = ['Status' => 0, 'Data' => 'Could not move your file to upload destination.', 'Index' => $this->index];
          }
          // RENAME FILE

        }


        //                CHECK FOR ERRORS



      } else {
        $this->upStatus = ['Status' => 0, 'Data' => 'File extension not supported. Acceptable files (' . join($option['Extensions'], ', '). ').', 'Index' => $this->index];
      }
    } else {
      $this->upStatus = ['Status' => 0, 'Data' => 'File size too big. Max upload size '.$this->options['Size'].'MB', 'Index' => $this->index];
    }

    return $this->upStatus;
    // check file size
  }


  function deleteFile(){

    $this->intImageFolder();
    $status = ['Status'=> 0, 'Data' => ''];
    $fileMain = @preg_replace('#[^a-zA-Z0-9_\.\/\:]#i', '', $_POST['file']);
    $file = str_replace($this->imageRoot, $this->imageRootFolder, $fileMain);

    if(!empty($file)){
      if(file_exists($file)){
        unlink($file);
        $status['Data'] = 'Deleted';
        $status['Status'] = 200;
      } else {
        $status['Data'] = 'Could not find file.';
      }
    } else {
      $status['Data'] = 'Could not find file.';

    }

    return json_encode($status);
  }


  // procees file for database
  function getDatabaseReadyFiles(){
    // include 'libraries/extends/ext.image.resize.exception.php';
    // include 'libraries/extends/ext.image.resize.php';

    $this->intImageFolder();
    if(count($this->handleFiles) > 0){
      // check to see if its one file or multiple files
      if(array_key_exists('Status', $this->handleFiles)){
        $this->handleFiles = [ $this->handleFiles ];
      }

      foreach ($this->handleFiles as $files) {
        $readyFile =  $this->processReadyFiles($files);
        array_push($this->fileHandleDatabseResponse, $readyFile);
      }
    }
    // return files
    return $this->fileHandleDatabseResponse;

  }


  public function processReadyFiles(array $file)
  {

    $settings = $this->fileHandleOption;
    $fileResponse = [];

    $extension = $file['Extension'];
    $filename = $file['NwName'];
    $filename = str_replace('.' . $extension, '', $filename);
    $fileLink = $file['Url'];

    $fileLink = str_replace($this->imageRoot, $this->imageRootFolder, $fileLink);

    $fileNewLink = $this->getFileStoreImageFolder($settings['user_type']);

    // check if subfolder exist
    if(!empty($settings['sub_location'])){
      $subFolder = preg_replace('#[^a-zA-Z0-9/_]#i', '', $settings['sub_location']);
      $fileNewLink .= $subFolder .'/';
      $fileNewLink = $this->getFileStoreImageFolder($settings['user_type']);
    }

    // check if file needs renaming
    if(!empty($settings['filename_append'])){
      $filename .= '_' . $settings['filename_append'];
    }


    // check if file for various sizes and names
    if(in_array($extension, $this->imgArr)) {
      $fileSizes = '';$fileDimensions = '';
      foreach ($settings['sizes'] as $key => $sizes) {
        $sizes = str_replace(' ', '', $sizes);
        if(count(explode('x', strtolower($sizes))) !== 2 ){ continue;}
        list($height, $width) = explode('x', strtolower($sizes));
        $width = $width ?: $height;
        $fileEnd = $filename . '_' . $sizes . '.' . $extension;

        $fileResponse[$key]['name'] = $fileEnd;
        $fileResponse[$key]['height'] = $height;
        $fileResponse[$key]['width'] = $width;

        $fileEnd = $fileNewLink . $fileEnd;
        $fileResponse[$key]['url'] = str_replace($this->imageRootFolder, $this->imageRoot, $fileEnd);

        $action = 'resizeToBestFit';
        if(in_array($key, ['small', 'tiny'])){
          $action = 'crop';
        }

        $rzObj = new ImageResize($fileLink);
        $rzObj->$action($height, $width, $settings['allow_enlarge']);
        $rzObj->save($fileEnd);
        $fileResponse[$key]['size'] = $this::getFileSize($fileEnd);
        $fileSizes .= $fileResponse[$key]['size'] .', ';
        $fileDimensions .= $sizes . ', ';
      }

      // delete file from temporal location
      // unlink($fileLink);

      $fileResponse['log'] = $file;
      $fileResponse['sizes'] = chop($fileSizes, ', ');
      $fileResponse['dimensions'] = chop($fileDimensions, ', ');
    } else {

      // move a copy of the file
      $fileEnd = $filename . '.' . $extension;
      $fileEnd = $fileNewLink . $fileEnd;

      copy($fileLink, $fileEnd);
      $fileResponse['url'] = str_replace($this->imageRootFolder, $this->imageRoot, $fileEnd);
      // move a copy of the file
      $fileResponse['log'] = $file;
      $fileResponse['size'] = $this::getFileSize($fileEnd);

    }

    return $fileResponse;

  }
  // procees file for database


  static function getFileSize(string $file)
  {
    $result='';
    $bytes = floatval(filesize($file));
    $arBytes = array(
      0 => array(
        "UNIT" => "TB",
        "VALUE" => pow(1024, 4)
      ),
      1 => array(
        "UNIT" => "GB",
        "VALUE" => pow(1024, 3)
      ),
      2 => array(
        "UNIT" => "MB",
        "VALUE" => pow(1024, 2)
      ),
      3 => array(
        "UNIT" => "KB",
        "VALUE" => 1024
      ),
      4 => array(
        "UNIT" => "B",
        "VALUE" => 1
      ),
    );

    foreach($arBytes as $arItem)
    {
      if($bytes >= $arItem["VALUE"])
      {
        $result = $bytes / $arItem["VALUE"];
        // $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
        $result = strval(round($result, 2))." ".$arItem["UNIT"];
        break;
      }
    }
    return $result;
  }


}

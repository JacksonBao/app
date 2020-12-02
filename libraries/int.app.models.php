<?php

namespace App\APP_NAME\Libraries;

/**
 *
 */
// include models
include_once getcwd() . '/libraries/int.app.autoloader.in.php';

// end models

class Models extends \App\APP_NAME\Libraries\Functions
{
  public $imageLibrary;
  public $sqlError = '';
  public $sqlLimit = '';
  public $jsFunc;
  public $errors = [];
  function __construct()
  {
    parent::__construct();
    // $this->imgageLibrary = new Gumlet\ImageResize();
    // $this->getApiToken();
    // $this->getLoggedUser();
    // $this->initActiveWallet();
    // if user is not logged in they should go home
    if(empty($this->WALLET_UNIQ) && in_array($this->directory, $this->loginLinks)){
      return $this->response['response'] = 'You have to be logged in to proceed.';
      exit;
    }

  }


  function loadEngineErrors(string $object, string $method, string $lang = lang){
    $errorFile = 'models/app.engine.models/app.engine.errors/'.strtolower($object).'_errors/error_{{lang}}.php';
    $file =  str_replace('{{lang}}', $lang, $errorFile);
    if(file_exists($file)){
      $errorObject = require_once $file;
      if(array_key_exists($method, $errorObject)){
        $this->errors = $errorObject[$method];
      } else {
        $this->errors = [];
      }
    } else {
      $this->errors = [];
    }
  }

  public function responseError($type = '')
  {
    $this->response['response'] = 'Could not process your request.';
    return $this->response;
  }





  // input struc for database
  public function structInsert(array $row) // return string
  {
    try {
      $newRow = [];
      foreach ($row as $key => $value) {
        if ($value == '') {
          continue;
        }
        $newRow[$key] = $value;
      }
      $keys = array_keys($newRow);
      $values = array_values($newRow);
      $keyList = join(', ', $keys);
      $valueList = "'" . join("', '", $values) . "'";

      $sql = "INSERT INTO $this->table  ( $keyList )  VALUES ( " . $valueList . ") ";
      $this->dbm->query($sql) or die($this->table . ' || ' . $valueList . ' || ' . $this->dbm->error);
      if (!empty($this->dbm->error)) {
        $this->sqlError = $this->dbm->error;
        return false;
      } else {
        return $this->dbm->insert_id;
      }
    } catch (\Exception $e) {
      var_dump($e->getMessage());
    }
  }

  public function structUpdate(array $row, int $id)
  {
    $list = '';
    $row['updated_at'] = date('Y-m-d h:i:s');
    foreach ($row as $key => $value) {
      if (strlen($value) < 1) {
        continue;
      }
      $list .= " $key = '$value', ";
    }
    $list = chop($list, ', ');
    $sql = " UPDATE $this->table SET $list, updated_at = now() WHERE id = '$id' LIMIT 1 ";
    $this->dbm->query($sql);
    if ($this->dbm->error) {
      $this->sqlError = $this->dbm->error;
      return false;
    } else {
      return true;
    }
  }

  public function structDelete(int $id, int $limit = 1)
  {
    $sql = "DELETE FROM $this->table WHERE id = '$id' LIMIT $limit ";
    $this->dbm->query($sql);
    if ($this->dbm->error) {
      $this->sqlError = $this->dbm->error;
      return false;
    } else {
      return true;
    }
  }
  // input struc for database

  public function logAdminActivity(string $action, string $id = '')
  {
    // return;
    // register activit
    $action = str_replace('|', '_', $action);
    // $adminActivity = new \App\APP_NAME\Tables\DbPageAdminActivities();
    // $adminActivity->rows->user = $this->user;
    // $adminActivity->rows->action = $action;
    // $adminActivity->rows->item_id = $id;
    // $adminActivity->rows->page = $this->PAGE_ID;
    // $adminActivity->create();
    // register activity
  }

  public function logProductActivity(string $action, string $pid)
  {
    // return;
    $action = str_replace('|', '_', $action);
    // register activity
    // $productLog = new \App\APP_NAME\Tables\DbProductLogs();
    // $productLog->rows->user = $this->user;
    // $productLog->rows->action = $action;
    // $productLog->rows->page_id = $this->PAGE_ID;
    // $productLog->rows->item_id = $pid;
    // $productLog->create();
    // register activity
  }
}

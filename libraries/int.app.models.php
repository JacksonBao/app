<?php
namespace App\Market\Libraries;

/**
*
*/
// include models
include_once 'libraries/int.app.autoloader.in.php';

// end models

class Models extends \App\Market\Libraries\Functions
{
  public $imageLibrary;
  public $sqlError = '';
  public $sqlLimit = '';
  public $jsFunc;

  function __construct()
  {
    parent::__construct();
    // $this->imgageLibrary = new Gumlet\ImageResize();

  }


  public function createSlug(string $item, string $name, string $dir = '')
  {
    $name = strtolower($name);
    $name = preg_replace('#[^a-zA-Z0-9 ]#i', '', $name);
    $name = str_replace(' ', '-', $name);
    $name = rtrim($name, '-');
    $name = ltrim($name, '-');
    $name = substr($name, 0, 150);

    $dbSlug = new \App\Market\Tables\DbSlugs();
    $dbSlug->rows->slug = $name;
    $dbSlug->rows->item_id = $item;
    $dbSlug->rows->directory = $dir ;
    $id = $dbSlug->create();
    if(!$id){
      $dbSlug->rows->slug = $name .'-'.$item;
      $id = $dbSlug->create();
    }
    return $id;

  }

  // param is assoc array [key => [vaue, operan]]
  public function sqlExpress(array $param, string $attach = 'AND')
  {
    $express = '';
    foreach ($param as $key => $value) {
      $operan = $value[1];
      $val = $value[0];
      $express .= " $key $operan '$val' $attach";
    }
    if(strlen($express) > 0){
      $express = chop($express, $attach);
    } else {
      $expres = 1;
    }

    return $express;
  }



  public function responseError($type = '')
  {
    $this->reponse['response'] = 'Could not process your request.';
    return $this->response;
  }



  public function getTableData(string $dbpage, $id){
    if(is_array($id)){
      $id = $this->sqlExpress($id);
    } elseif(is_numeric($id)) {
      $id = " id = '$id' ";
    } elseif(!empty($id)) {
      $id = str_ireplace(['drop', 'delete', 'insert', 'update'], '', $id);
    } else {
      return false;
    }
    if(strpos($dbpage, 'nj_') === FALSE && strpos($dbpage, $this->DATABASE_APPEND) === FALSE){
      $dbpage = $this->DATABASE_APPEND . $dbpage;
    }
    // die($dbpage);

    $query = $this->in_query("SELECT * FROM $dbpage WHERE $id LIMIT 1")or die($this->dbm->error . $dbpage.$id);
    if($query->num_rows > 0) {
      while($row = $query->fetch_assoc()){
        return $row;
      }
    } else {
      return false;
    }

  }



  // input struc for database
  public function structInsert(array $row) // return string
  {
    try{
      $newRow = [];
      foreach ($row as $key => $value) {
        if($value == ''){continue;}
        $newRow[$key] = $value;
      }
      $keys = array_keys($newRow);
      $values = array_values($newRow);
      $keyList = join(', ', $keys);
      $valueList = "'" . join("', '", $values) . "'";

      $sql = "INSERT INTO $this->table  ( $keyList )  VALUES ( " . $valueList. ") ";
      $this->dbm->query($sql)or die($this->table.' || '. $valueList .' || '.$this->dbm->error);
      if(!empty($this->dbm->error)) {
        $this->sqlError = $this->dbm->error;
        return false;
      } else {
        return $this->dbm->insert_id;
      }

    } catch(Exception $e) {
      var_dump($e->getMessage());
    }
  }

  public function structUpdate(array $row, int $id)
  {
    $list = '';
    $row['updated_at'] = date('Y-m-d h:i:s');
    foreach ($row as $key => $value) {
      if(strlen($value) < 1){ continue; }
      $list .= " $key = '$value', ";
    }
    $list = chop($list, ', ');
    $sql = " UPDATE $this->table SET $list, updated_at = now() WHERE id = '$id' LIMIT 1 ";
    $this->dbm->query($sql);
    if($this->dbm->error) {
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
    if($this->dbm->error) {
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
    $adminActivity = new \App\Market\Tables\DbPageAdminActivities();
    $adminActivity->rows->user = $this->user;
    $adminActivity->rows->action = $action;
    $adminActivity->rows->item_id = $id;
    $adminActivity->rows->page = $this->PAGE_ID;
    $adminActivity->create();
    // register activity
  }

  public function logProductActivity(string $action, string $pid)
  {
    // return;
    $action = str_replace('|', '_', $action);
    // register activity
    $productLog = new \App\Market\Tables\DbProductLogs();
    $productLog->rows->user = $this->user;
    $productLog->rows->action = $action;
    $productLog->rows->page_id = $this->PAGE_ID;
    $productLog->rows->item_id = $pid;
    $productLog->create();
    // register activity
  }

}

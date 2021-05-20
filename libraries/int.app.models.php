<?php

namespace Libraries;

if (!session_id()) {
  session_start();
}

use Controllers\Api;
use Libraries\Traits\ApiSetup;
use Models\Tables\DbApiUserKeys;
use Models\Tables\DbApiUsers;

/**
 *
 */
// include models
include_once __DIR__ . '/../libraries/int.app.autoloader.in.php';

// end models

class Models extends \Libraries\Functions
{
  use ApiSetup;
  public $imageLibrary;
  public $sqlError = '';
  public $sqlLimit = '';
  public $jsFunc;
  public $dbOrder = 'ASC';
  public $API_TOKEN = '';
  public $ERROR_LIST = [];
  public $insertIgnore;
  function __construct()
  {
    parent::__construct();


    // auto load errorfile for each item
    $callingClass = debug_backtrace()[1]['class'];
    $split = explode('\\', $callingClass);
    if (isset($split[0]) && $split[0] == 'Models') {
      $errFile = $split[1];
      if ($errFile == 'Api') {
        $folder = 'api_errors/' . $_ENV['api_version'];
        $this->URL_IN_VIEW =  '';
        $this->loadEngineErrors('apiErr', '', '', $folder);
      }
    }
    // check system classes
    $expClass = explode('System', $callingClass);
    if (count($expClass) > 1) {
      $this->loadEngineErrors('system');
    }

    // add throtle list
    if (isset($this->throttleList)) {
      $this->throttleList[] = [
        'usage' => ['restore' => 60, 'max' => 200]
      ];
    }

    // log user
    // $this->authLogUser();
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
    if (strlen($express) > 0) {
      $express = chop($express, $attach);
    } else {
      $express = 1;
    }

    return $express;
  }

  /**
   * @return array
   */
  function loadEngineErrors(string $object, string $method = '', string $lang = '', $route = '')
  {
    $lang = $lang ?: $_ENV['lang'];
    $object = strtolower($object);
    $method = strtolower($method);
    if (!empty($route)) {
      $errorFile = 'models/errors/' . strtolower($route) . '/{{lang}}.php';
    } else {
      $errorFile = 'models/errors/' . strtolower($object) . '_errors/{{lang}}.php';
    }
    $file =  __DIR__ . '/../' . str_replace('{{lang}}', $lang, $errorFile);
    if (file_exists($file)) {
      $errorObject = @$object . 'ErrorObject';
      if (!isset($this->$errorObject)) {
        $this->$errorObject = @json_decode(file_get_contents($file), true);
      }


      if (is_array($this->$errorObject) && array_key_exists($method, $this->$errorObject)) {
        $this->errors = $this->$errorObject[$method];
      } elseif (is_array($this->$errorObject)) {
        $this->ERROR_LIST = $this->$errorObject;
      }
    } else {
      $this->errors = [];
    }
  }

  public function query($sql)
  {
    return $this->db->query($sql);
  }

  public function responseError($type = '')
  {
    $this->reponse['response'] = 'Could not process your request.';
    return $this->response;
  }



  public function getTableData(string $dbpage, $id, int $lim = null)
  {
    if (is_array($id)) {
      $id = $this->sqlExpress($id);
    } elseif (is_numeric($id)) {
      $id = " id = '$id' ";
    } elseif (!empty($id)) {
      $id = str_ireplace([' drop ', ' delete ', ' insert ', ' update '], '', $id);
    } else {
      return false;
    }

    $limit = ' LIMIT 1 ';
    if ($lim === 0) {
      $limit = '';
    } elseif ($lim > 0) {
      $limit = ' LIMIT ' . $lim;
    }

    if (strpos($dbpage, 'nj_') === FALSE && strpos($dbpage, $this->DATABASE_APPEND) === FALSE) {
      $dbpage = $this->DATABASE_APPEND . $dbpage;
    }
    $rowList = [];
    $query = $this->query("SELECT * FROM $dbpage WHERE $id $limit") or die($this->db->error . ' ::: ' . "SELECT * FROM $dbpage WHERE $id $limit");
    if ($query->num_rows > 0) {
      while ($row = $query->fetch_assoc()) {
        if ($lim === null) {
          return $row;
        } else {
          $rowList[] = $row;
        }
      }
      return $rowList;
    } else {
      return false;
    }
  }



  // input struc for database
  public function structInsert(array $row) // return string
  {
    try {
      $newRow = [];
      $bind = '';
      $prep = '';
      foreach ($row as $key => $value) {
        if ($value == '') {
          continue;
        }
        $bind .= '?, ';
        $prep .= 's';
        $newRow[$key] = $value;
      }
      $bind = chop($bind, ', ');

      $keys = array_keys($newRow);
      $values = array_values($newRow);
      if (!in_array('created_at', $keys)) {
        $keys[] = 'created_at';
        $values[] = date('Y-m-d h:i:s');
      }
      $keyList = join(', ', $keys);
      $valueList = "'" . join("', '", $values) . "'";
      // prepare sql
      $prepare = "INSERT $this->insertIgnore INTO $this->tableName  ( $keyList )  VALUES ($bind) ";
      $dbPrepare = $this->db->prepare($prepare);
      if ($dbPrepare !== false) {
        // bind values to prepared statement
        $rc = $dbPrepare->bind_param($prep, $valueList);
        if ($rc != false) {
          $ex = $dbPrepare->execute();
          if ($ex != false) {
            $id = $this->db->insert_id;
            $dbPrepare->close();
            return $id;
          } else {
            $this->sqlError = $this->db->error;
          }
        } else {
          $this->sqlError = $this->db->error;
        }
      } else {
        $this->sqlError = $this->db->error;
      }

      // $sql = "INSERT $this->insertIgnore INTO $this->tableName  ( $keyList )  VALUES ( " . $valueList . ") ";
      // $this->db->query($sql) or die($this->tableName . ' || ' . $valueList . ' || ' . $this->db->error);
      // if (!empty($this->db->error)) {
      //   $this->sqlError = $this->db->error;
      //   return false;
      // } else {
      //   return $this->db->insert_id;
      // }
    } catch (\Exception $e) {
      $this->sqlError = $e->getMessage();
    }
  }

  public function structUpdate(array $row, ?string $id, ?string $limit = '1')
  {
    if (is_array($id)) {
      $id = $this->sqlExpress($id);
    } elseif (is_numeric($id)) {
      $id = " id = '$id' ";
    } elseif (!empty($id)) {
      $id = str_ireplace([' drop ', ' delete ', ' insert ', ' update '], '', $id);
    } else {
      return false;
    }

    if ($limit > 1) {
      $limit = "LIMIT $limit";
    } elseif (strlen($limit) > 5) {
      $limit = str_ireplace([' drop ', ' delete ', ' insert ', ' update '], '', $limit);
    } else {
      $limit = " LIMIT 1";
    }

    $list = '';
    foreach ($row as $key => $value) {
      if (strlen($value) < 1) {
        continue;
      }
      $list .= " $key = '$value', ";
    }


    if (isset($this->dbOrder) && in_array(strtolower($this->dbOrder), ['asc', 'desc'])) {
      $this->dbOrder = " ORDER BY id $this->dbOrder ";
    } else {
      $this->dbOrder = '';
    }

    $list = chop($list, ', ');
    $sql = " UPDATE $this->tableName SET $list, updated_at = now() WHERE $id $this->dbOrder  $limit";
    // die($sql);

    $this->db->query($sql);
    if ($this->db->error) {
      $this->sqlError = $this->db->error;
      return false;
    } else {
      return true;
    }
  }

  public function structDelete(int $id, ?string $limit = '1')
  {
    if (is_array($id)) {
      $id = $this->sqlExpress($id);
    } elseif (is_numeric($id)) {
      $id = " id = '$id' ";
    } elseif (!empty($id)) {
      $id = str_ireplace([' drop '], '', $id);
    } else {
      return false;
    }


    if ($limit > 1) {
      $limit = "LIMIT $limit";
    } elseif (strlen($limit) > 5) {
      $limit = str_ireplace([' drop ', ' delete ', ' insert ', ' update '], '', $limit);
    } else {
      $limit = " LIMIT 1";
    }

    $sql = "DELETE FROM $this->tableName WHERE $id  $limit ";
    $this->db->query($sql);
    if ($this->db->error) {
      $this->sqlError = $this->db->error . ' :: ' . $sql;
      return false;
    } else {
      return true;
    }
  }

  public function tableInputData()
  {
    $newList =  $this->tableColumns;
    $data = (array) []; // $this->rows;
    foreach ($newList as  $column) {
      if (isset($this->$column) && strlen($this->$column) > 0) {
        $data[$column] = $this->$column;
      }
    }
    return $data;
  }


  public function create()
  {
    $table = $this->tableInputData();
    return $this->structInsert($table);
  }

  public function update(?string $id, ?string $limit = '')
  {
    $table = $this->tableInputData();
    return $this->structUpdate($table, $id, $limit);
  }

  public function delete(?string $id, $limit = '')
  {
    return $this->structDelete($id, $limit);
  }

  // input struc for database

}

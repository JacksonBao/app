<?php

namespace Libraries\Traits;

/**
 *
 */
trait ModelTables
{
  private $mt_class;
  private $mt_table;
  private $mt_object;
  private $mt_columns;

  public function generateDefaultDbTables()
  {
    // check if table exist
    $queries = [
      $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_users' => " 
      CREATE TABLE {{table}} (
        `id` int(11) NOT NULL,
        `user` varchar(25) NOT NULL,
        `status` enum('0','1','2') NOT NULL DEFAULT '1',
        `level` enum('1','2','3','4') NOT NULL DEFAULT '1',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ALTER TABLE `{{table}}` ADD PRIMARY KEY (`id`); ALTER TABLE `{{table}}` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
      $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_user_keys' => "
      CREATE TABLE {{table}} (
        `id` int(11) NOT NULL,
        `user` int(11) NOT NULL,
        `auth_key` varchar(32) NOT NULL,
        `status` enum('0','1','2') NOT NULL DEFAULT '1',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
      ALTER TABLE `{{table}}`
        ADD PRIMARY KEY (`id`);ALTER TABLE `{{table}}`
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      ",
      $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_user_reports' => "
      CREATE TABLE {{table}} (
        `id` int(11) NOT NULL,
        `user` int(11) NOT NULL,
        `uniq` varchar(25) NOT NULL,
        `report` text NOT NULL,
        `status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0 = pending, 1 completed, ',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;ALTER TABLE `{{table}}`
      ADD PRIMARY KEY (`id`);ALTER TABLE `{{table}}`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      ",
      $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_user_requests' => "
      CREATE TABLE {{table}} (
        `id` int(11) NOT NULL,
        `user` int(11) NOT NULL,
        `api` varchar(111) NOT NULL,
        `domain` text NOT NULL,
        `request` text NOT NULL,
        `time_taken` varchar(11) NOT NULL COMMENT 'milliseconds',
        `status` enum('0','1','2') NOT NULL DEFAULT '1',
        `log` text NOT NULL COMMENT 'use when call failed',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;ALTER TABLE `{{table}}`
      ADD PRIMARY KEY (`id`);ALTER TABLE `{{table}}`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      ",
      $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_user_sites' => "
      CREATE TABLE {{table}} (
        `id` int(11) NOT NULL,
        `user` int(11) NOT NULL,
        `api` varchar(25) NOT NULL,
        `domain` text NOT NULL,
        `status` enum('0','1','2','3') NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;ALTER TABLE `{{table}}`
      ADD PRIMARY KEY (`id`);ALTER TABLE `{{table}}`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      ",
      $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_user_throttle' => "
      CREATE TABLE `{{table}}` (
        `id` int(11) NOT NULL,
        `user` int(11) NOT NULL,
        `api` varchar(255) NOT NULL,
        `request` text NOT NULL,
        `resume` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        `status` enum('0','1','2') NOT NULL DEFAULT '1',
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `updated_at` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;ALTER TABLE `{{table}}`
      ADD PRIMARY KEY (`id`);ALTER TABLE `{{table}}`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
      ",
      // $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE_APPEND'] . 'api_users' => "",
    ];
    $result = [];

    if($this->db == false){
    if($this->DB_USER_CONNECT != false){
      $this->DB_USER_CONNECT->query("SET SQL_MODE = `NO_AUTO_VALUE_ON_ZERO`;START TRANSACTION;SET time_zone = `+00:00`;");
      $this->DB_USER_CONNECT->query("CREATE DATABASE IF NOT EXISTS ".$_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE']." DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; USE  `".$_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE']."`;");
      // SELECT THE DATABASE AS DEFAULT
      $this->db = $this->DB_USER_CONNECT::select_db($_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE']);
      $this->DB_USER_CONNECT = false;
      $result['database'] = $_ENV[$_ENV['ENVIRONMENT'] . '_DATABASE'] . ' database created successfully';
    }
    foreach ($queries as $table => $query) {
      $query = str_replace('{{table}}', $table, $query);
      $this->query($query);
      $result[$table] = [];
    if (!$this->db->error) {
      if ($this->db->affected_rows > 0) {
        $result[$table] = $table . ' :: Created successfully.';
      } else { // 
        $result[$table] = $table . ' :: already exists.';
      }
    } else { // there was an error
      $result['table'] = 'Could not create table :: '.$table.'  >> ' . $this->db->error;
    }
    }
  }

  return $result;
  }


  function generateModelTableTemplate($table)
  {

    // get table
    // Query to get columns from table
    $this->mt_table = $table;
    $database =  $_ENV[$_ENV['environment'] . '_database'];
    $query = $this->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
    while ($row = $query->fetch_assoc()) {
      $result[] = $row;
    }
    // Array of all column names
    $columnArr =  array_column($result, 'COLUMN_NAME');
    $this->mt_columns = $columnArr;
    // create object
    $this->mt_object = "['" . join("' => '', '", $columnArr) . "' => '']";
    $page = str_replace(['_', ' '], ['.', ''], $table);

    $this->mt_class = str_replace(' ', '', ucwords(str_replace('.', ' ', $page)));
    $myfileClass = fopen("models/tables/db." . strtolower($page) . ".php", "w") or die("Unable to open file!");
    $txt = $this->template();
    fwrite($myfileClass, $txt);
    fclose($myfileClass);

    $myfileClass = fopen("models/classes/" . strtolower($page) . ".php", "w") or die("Unable to open file!");
    $txt = $this->templateClass();
    fwrite($myfileClass, $txt);
    fclose($myfileClass);
  }

  private function templateClass()
  {
    return '<?php
        namespace Models\Classes;
        /**
         * MANAGE ' . $this->mt_class . ' table
         */
        class ' . $this->mt_class . ' extends \Libraries\Models
        { 
            STATIC $tableName = "' . $this->mt_table . '";
            public function __construct(string $id = "")
            {
                parent::__construct();
                // initiate variables
                self::$tableName = \'' .$_ENV[$_ENV['ENVIRONMENT'].'DATABASE_APPEND'].$this->mt_table . '\';
                
            }


        }
    ';
  }

  private function template()
  {

    $columnList = '';
    foreach ($this->mt_columns as $key => $value) {
      $columnList .= "      PUBLIC $$value; \n";
    }

    return '<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ' . $this->mt_class . '
     */
    class Db' . $this->mt_class . ' extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = \'' . $this->mt_table . '\';
      static $table = \'' . $this->mt_table . '\';
      // columns
' . $columnList . '      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) [\'' . implode("', '",  $this->mt_columns) . '\'];
        self::$table = \'' .$_ENV[$_ENV['ENVIRONMENT'].'DATABASE_APPEND'].$this->mt_table . '\';
        $this->tableName = \'' .$_ENV[$_ENV['ENVIRONMENT'].'DATABASE_APPEND'].$this->mt_table . '\';

      }





    }


    ';
  }
}

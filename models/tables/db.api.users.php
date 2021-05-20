<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ApiUsers
     */
    class DbApiUsers extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = 'api_users';
      static $table = 'api_users';
      // columns
      PUBLIC $id; 
      PUBLIC $user; 
      PUBLIC $status; 
      PUBLIC $level; 
      PUBLIC $created_at; 
      PUBLIC $updated_at; 
      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) ['id', 'user', 'status', 'level', 'created_at', 'updated_at'];

      }





    }


    
<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ApiUserKeys
     */
    class DbApiUserKeys extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = 'api_user_keys';
      static $table = 'api_user_keys';
      // columns
      PUBLIC $id; 
      PUBLIC $user; 
      PUBLIC $auth_key; 
      PUBLIC $status; 
      PUBLIC $created_at; 
      PUBLIC $updated_at; 
      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) ['id', 'user', 'auth_key', 'status', 'created_at', 'updated_at'];

      }





    }


    
<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ApiUserThrottle
     */
    class DbApiUserThrottle extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = 'api_user_throttle';
      static $table = 'api_user_throttle';
      // columns
      PUBLIC $id; 
      PUBLIC $user; 
      PUBLIC $api; 
      PUBLIC $request; 
      PUBLIC $resume; 
      PUBLIC $status; 
      PUBLIC $created_at; 
      PUBLIC $updated_at; 
      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) ['id', 'user', 'api', 'request', 'resume', 'status', 'created_at', 'updated_at'];

      }





    }


    
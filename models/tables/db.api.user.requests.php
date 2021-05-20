<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ApiUserRequests
     */
    class DbApiUserRequests extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = 'api_user_requests';
      static $table = 'api_user_requests';
      // columns
      PUBLIC $id; 
      PUBLIC $user; 
      PUBLIC $api; 
      PUBLIC $domain; 
      PUBLIC $request; 
      PUBLIC $time_taken; 
      PUBLIC $status; 
      PUBLIC $log; 
      PUBLIC $created_at; 
      PUBLIC $updated_at; 
      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) ['id', 'user', 'api', 'domain', 'request', 'time_taken', 'status', 'log', 'created_at', 'updated_at'];

      }





    }


    
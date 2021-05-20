<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ApiUserSites
     */
    class DbApiUserSites extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = 'api_user_sites';
      static $table = 'api_user_sites';
      // columns
      PUBLIC $id; 
      PUBLIC $user; 
      PUBLIC $api; 
      PUBLIC $domain; 
      PUBLIC $status; 
      PUBLIC $created_at; 
      PUBLIC $updated_at; 
      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) ['id', 'user', 'api', 'domain', 'status', 'created_at', 'updated_at'];

      }





    }


    
<?php
    namespace Models\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE ApiUserReports
     */
    class DbApiUserReports extends \Libraries\Models
    {
      public $tableColumns;
      public $tableName = 'api_user_reports';
      static $table = 'api_user_reports';
      // columns
      PUBLIC $id; 
      PUBLIC $user; 
      PUBLIC $uniq; 
      PUBLIC $report; 
      PUBLIC $status; 
      PUBLIC $created_at; 
      PUBLIC $updated_at; 
      

      function __construct()
      {
        parent::__construct();
        $this->tableColumns = (array) ['id', 'user', 'uniq', 'report', 'status', 'created_at', 'updated_at'];

      }





    }


    
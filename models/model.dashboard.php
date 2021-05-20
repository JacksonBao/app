<?php

use Models\Classes\ApiUserKeys;
use Models\Classes\ApiUsers;

/**
       * Index model
       */
      class DashboardModel extends \Libraries\Models
      {

      	function __construct()
      	{
      		parent::__construct();

      	}

            
            function intHome()
            {
                  $user = $this->getTableData(ApiUsers::$tableName, " user = '$this->USER_UNIQ' ");
                  if($user != false){
                        // get all user data
                        $userId = $user['id'];
                        $this->response['user_keys'] = $this->getTableData(ApiUserKeys::$tableName, " user = '$userId' ");
                        $apiResult = $this->apiCalls(
                              'reports/basic', [], 'GET'
                        );
                        if($apiResult['success'] == true){
                              $this->response['success'] = true; 
                              $this->response['reports']  = $apiResult['reports'];
                              $this->response['summary'] = $apiResult['summary'];
                              $this->response['failed_requests'] = $apiResult['failed_requests'];
                              $this->response['authorized_domains'] = $apiResult['authorized_domains'];
                        }
                        // get all user data
                  } else {
                        $this->response['message'] = 'User has no api key.';
                  }

                  return $this->response;
            }
      }

      
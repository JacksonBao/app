<?php

namespace Models\Api\V1_0;

use Models\Classes\ApiUserRequests;
use Models\Classes\ApiUserSites;

class ReportsApi extends \Libraries\models
{
    static $requests = [
        'currency' => 'GET', // from, to, amount, 
        'generate' => 'GET', // return usage
        'check' => 'GET', // return usage
        'basic' => 'GET', // return usage
        'usage' => 'GET', // return usage
        'full' => 'GET', // return usage
    ];
    static $throttleList = [
        'currency' => ['restore' => 60, 'max' => 10000], // restore => number of minutes max => request can be made
        'generate' => ['restore' => 60, 'max' => 5000],
        'check' => ['restore' => 60, 'max' => 10000],
        'basic' => ['restore' => 60, 'max' => 10000],
        'usage' => ['restore' => 60, 'max' => 10000],
        'full' => ['restore' => 60, 'max' => 10000],
        // 'history' => ['restore' => 60, 'max' => 15],

    ];
    public $api = 'reports';
    public function __construct()
    {
        parent::__construct();
    }

    public function basic( array $param = [])
    {
        $reportDatabase =  ApiUserRequests::$tableName;
        // get usage by domain
        $this->response['reports'] = [];
        $date = date('Y-m-d', strtotime('7 days ago'));
        $sql = $this->query("SELECT DISTINCT api, domain FROM " .  $reportDatabase . " WHERE user = '$this->apiUser' AND created_at > date_sub(now(), INTERVAL 7 DAY) ")or die($this->db->error);
        $totalRequests = 0;
        $totalFailed = 0;
        $totalSuccess = 0;
        $responseTime = 0;
        $countRequests = 0;
        
        if($sql->num_rows > 0){
            while($row = $sql->fetch_assoc()){
                $api = $row['api'];
                $domain = $row['domain'];
                if(!isset($this->response['reports'][$api])){
                    $this->response['reports'][$api] = [$domain => []];
                } else {
                    $this->response['reports'][$api][$domain] = [];
                }

                // select average time taken, status
                $sql2 = $this->query("SELECT AVG(time_taken) from  $reportDatabase WHERE user = '$this->apiUser' and domain = '$domain' AND api = '$api' AND  created_at < date_sub(now(), INTERVAL 7 DAY)  ");
                $this->response['reports'][$api][$domain]['average'] = (float) round($sql2->fetch_row()[0], 6);
                // select success and failures
                $sql2 = $this->query("SELECT COUNT(id) from  $reportDatabase WHERE user = '$this->apiUser' and domain = '$domain' AND api = '$api' AND  created_at > date_sub(now(), INTERVAL 7 DAY)  AND status = '1' ");
                $this->response['reports'][$api][$domain]['success_request'] =  (int) $sql2->fetch_row()[0];
                $totalSuccess +=  $this->response['reports'][$api][$domain]['success_request'];
                // select success and failures
                $sql2 = $this->query("SELECT COUNT(id) from  $reportDatabase WHERE user = '$this->apiUser' and domain = '$domain' AND api = '$api' AND  created_at > date_sub(now(), INTERVAL 7 DAY)  AND status = '0' ");
                $this->response['reports'][$api][$domain]['failed_request'] =  (int) $sql2->fetch_row()[0];
                $totalFailed +=  $this->response['reports'][$api][$domain]['failed_request'];
                // select success and failures
                $this->response['reports'][$api][$domain]['total_request'] =  (int) $this->response['reports'][$api][$domain]['success_request'] + $this->response['reports'][$api][$domain]['failed_request'];
                $totalRequests += $this->response['reports'][$api][$domain]['total_request'];
                $responseTime += $this->response['reports'][$api][$domain]['average'];
                $countRequests++;
            }
            
            $this->response['summary'] = [
                'total' => $totalRequests,
                'failed' => $totalFailed,
                'success' => $totalSuccess,
                'average_time' => (float) round(($responseTime / $countRequests), 6)
            ];

            // get all failed requests
            $this->response['failed_requests'] = [];
            $sql = $this->query("SELECT * from  $reportDatabase WHERE user = '$this->apiUser' and domain = '$domain' AND api = '$api' AND  created_at > date_sub(now(), INTERVAL 7 DAY)  AND status = '0' LIMIT 25 ");
            if($sql->num_rows > 0){
                while($row = $sql->fetch_assoc()){
                    unset($row['id']);
                    unset($row['user']);
                    unset($row['updated_at']);
                    $row['log'] = json_decode(base64_decode($row['log']));
                $this->response['failed_requests'][] = $row;
                }
            }

            $this->response['authorized_domains'] = [];
            $sql = $this->query("SELECT * from  ".ApiUserSites::$tableName." WHERE user = '$this->apiUser' ");
            if($sql->num_rows > 0){
                while($row = $sql->fetch_assoc()){
                    unset($row['user']);
                    unset($row['updated_at']);
                $this->response['authorized_domains'][] = $row;
                }
            }

            $this->response['success'] = true;
            
        } else {
            $this->response['message'] = 'No api request.';
        }
        // get usage by domain
        return $this->response;
    }


    
    public function fullReport( array $param = [])
    {
        $request = count($param) > 0  ? $param : $this->request;

        $this->validateObject = [
            'from' => ['type' => 'str', 'min' => '3', 'max' => '50'],
            'to' => ['type' => 'str', 'min' => '3', 'max' => '50'],
        ];


        $post = $this->sanitizeRequest($request);

        if ($this->validateStatus == true) {
            $from = $post['from'] ?: '1 week ago';
            $to = @$post['to'];
            
        } else {
            $this->response['message'] = $this->validateError['message'];
        }
        return $this->response;
    }


}
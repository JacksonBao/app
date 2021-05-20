<?php

namespace Libraries\Traits;

use Models\Api\V1_0\CurrencyApi;
use Models\Classes\ApiUserKeys;
use Models\Classes\ApiUserRequests;
use Models\Classes\ApiUserSites;
use Models\Classes\ApiUserThrottle;
use Models\Tables\DbApiUserRequests;
use Models\Tables\DbApiUserThrottle;

/**
 * 
 */
trait ApiSetup
{
    public $apiCallMethod;
    public $canUseApi = false;
    public $response  = ['success' => false, 'message' => '', 'quota_left' => 0];
    public $errors = [];
    public $quotaLeft = 0;
    public $apiUser;
    public $startTime;
    public $request;
    public $host;
    private $accessKey,  $accessToken;
    static $requestTypes = [];
    static $error = '';

    /**
     * Check User can use Api
     * @param string $class and $method
     * @return null
     */
    public function apiAuthenticate(string $class,  string $method)
    {

        // get api details
        if (array_key_exists(strtolower($method), $this->routeList)) {
            $requestMethod = $this->routeList[strtolower($method)];
            $throttle = $this->throttle[strtolower($method)];

            $requestServermethod = $_SERVER['REQUEST_METHOD'];
            if (strtoupper($requestMethod) == 'ANY' || $requestServermethod == $requestMethod) {
                if ($requestServermethod == 'GET') {
                    $this->request = $_GET;
                } elseif($requestServermethod == 'POST') {
                    $requestServermethod = 'POST';
                    $this->request = $_POST;
                } elseif(strtoupper($requestMethod) == 'ANY') {
                    $this->resquest = $_POST ?: $_GET;
                    $requestServermethod = count($_POST) > 0 ? 'POST' : 'GET';
                }


                $accessKey = @$this->request['key'] ?: @$this->emu_getallheaders()['nj-api-key'];
                $accessKey = preg_replace('#[^a-zA-Z0-9]#i', '', $accessKey);
                $this->host = $this->emu_getallheaders()['Host'];

                $userKey = $this->getTableData(ApiUserKeys::$tableName, " auth_key = '$accessKey' AND status = '1'");
                if ($userKey != false) {
                    $this->apiUser = $userKey['id'];
                    // check for throttle request
                    $throttleCheck = $this->apiThrottleCheck($throttle, $this->request);
                    if ($throttleCheck === true) {
                        $user = $userKey['id'];
                        $hostStripped = explode('.', $this->host);
                        $hostDomain = $hostStripped[count($hostStripped) - 2] .'.'. end($hostStripped);
                        $access = $this->getTableData(ApiUserSites::$tableName, " domain LIKE '%$hostDomain' AND user = '$user' ");
                        if ($access != false || substr($this->host, '-' . strlen($_ENV['api_domain'])) == $_ENV['api_domain']){
                            // if ($access != false){
                            // check domain 
                            if (isset($this->request['key'])) {
                                unset($this->request['key']);
                            }

                            if (isset($this->request['url'])) {
                                $this->request['route'] = $this->request['url'];
                                unset($this->request['url']);
                            }


                            $this->canUseApi = true;
                            $this->accessKey = $accessKey;
                            // $this->apiUser = $userKey;
                        } else {
                            $this->response['message'] = str_replace(['{host}'], [strtolower($this->host)],  $this->errors['invalid_host']);
                            $this->response['messagse'] = $_ENV['api_domain'];
                        }
                    } else {
                        $this->response['message'] = str_replace(['{quota}', '{restore}'], [$throttleCheck['quota'], $throttleCheck['restore']],  $this->errors['invalid_throttle']);
                    }
                } else {
                    $this->response['message'] = $this->errors['missing_key'];
                }
            } else {
                $this->response['message'] = str_replace(['{requested}', '{submited}'], [$requestServermethod, $requestMethod], $this->errors['invalid_type']);
            }
        } else {
            $this->response['message'] = $this->errors['invalid'];
        }
    }

    public function apiThrottleCheck(array $throttle, array $request)
    {

        list($restore, $max) = array_values($throttle);
        $this->dbOrder = 'DESC';
        $thrott = $this->getTableData(ApiUserThrottle::$tableName, " request = '$this->host' AND api = '$this->api' AND user = '$this->apiUser' AND status = '1' ");
        if ($thrott != false) {
            $resume = strtotime($thrott['resume']);
            $now = time();
            $canResume = $now - $resume;
            if ($canResume >= 0) {
                $this->quotaLeft = $max;
                $newThrottle = new DbApiUserThrottle;
                $newThrottle->status = 0;
                $newThrottle->update(" request = '$this->host' AND api = '$this->api' AND user = '$this->apiUser' ");
                return true;
            } else {
                return ['quota' => $max, 'restore' => $thrott['resume']];
            }
        } else {
            $sql = $this->query("SELECT count(*) FROM " . ApiUserRequests::$tableName . " WHERE date_sub(now(), INTERVAL $restore MINUTE) AND user = '$this->apiUser' AND api = '$this->api' AND domain = '$this->host'");
            $count = $sql->fetch_row()[0];
            if ($count >= $max) { // it should be throtled
                // get the last request
                $last = $this->getTableData(ApiUserRequests::$tableName,  " date_sub(now(), INTERVAL $restore MINUTE) AND user = '$this->apiUser' AND api = '$this->api' AND domain = '$this->host' ");

                $lastTime = date('i', strtotime($last['created_at']));
                if ($lastTime == 59) { // reset throttle
                    $this->quotaLeft = $max;
                    $newThrottle = new DbApiUserThrottle;
                    $newThrottle->status = 0;
                    $newThrottle->update(" request = '$this->host' AND api = '$this->api' AND user = '$this->user' ", 0);
                    return true;
                } else {
                    $minutesLeft = 60 - $lastTime;
                    $date = date('Y-m-d H:i:s', strtotime('+' . $minutesLeft . ' minutes'));
                    $newThrottle = new DbApiUserThrottle;
                    $newThrottle->api = $this->api;
                    $newThrottle->user = $this->apiUser;
                    $newThrottle->request = $this->host;
                    $newThrottle->resume = $date;
                    $newThrottle->status = 1;
                    $newThrottle->create();
                    return ['quota' => $max, 'restore' => $date];
                }
            } else {
                $this->quotaLeft = $max - $count;
                return true;
            }
        }
    }

    public function registerApiCall(&$response)
    {
        if (strlen($this->api) > 0) {
            $now = (float) microtime();
            $response['time_taken'] = round((($now - $this->startTime) / 60), 5);
            $response['timestamp'] = time();
            $response['quota_left'] = $this->quotaLeft;
            $register = new DbApiUserRequests;
            $register->api = $this->api;
            $register->user = $this->apiUser;
            $register->request = @$response['query']['route'];
            $register->time_taken = $response['time_taken'];
            $register->domain = $this->host;
            $register->status = ($response['success'] == true ? 1 : 0);
            if ($register->status == 0) {
                $register->log = base64_encode(json_encode($response));
            }
            $register->create();
        }
    }

    function emu_getallheaders()
    {
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$name] = $value;
            } else if ($name == "CONTENT_TYPE") {
                $headers["Content-Type"] = $value;
            } else if ($name == "CONTENT_LENGTH") {
                $headers["Content-Length"] = $value;
            }
        }
        return $headers;
    }

    public function missingMethod()
    {
        $this->response['message'] = ''; 
        return $this->response;
    }
}

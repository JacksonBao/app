<?php
namespace Models\Api;

use Models\Classes\ApiUserKeys;
use Models\Classes\ApiUsers;
use Models\Classes\Users;
use Models\Tables\DbApiUserKeys;
use Models\Tables\DbUsers;
use Models\Tables\DbUserSessions;

class AuthApi extends \Libraries\Models
{
    STATIC $requestTypes = [
        'auth' => [
            'login' => 'ANY',
            'signup' => 'POST',
            'resetpassword' => 'POST'
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Refresh Api access key
     * @param array $param email, password
     * @return array $response 
     */
    public function refreshKey( array $param = [])
    {
        $user = $this->apiUser['uniq'];
        // check if user has active session
        $session = $this->getTableData(ApiUserKeys::$tableName, " user = '$user' AND created_at < date_sub(now(), INTERVAL 24 HOUR) AND  status = '1' ");
        if($session != false){
            $access_key = $session['access_key'];
        } else {
            // turn of all access keys
            $newAccesskey = new DbApiUserKeys;
            $newAccesskey->status = 0;
            $newAccesskey->dbOrder = 'DESC';
            $newAccesskey->update(" user = '$user' ", 5);

            $access_key = $this->randKey(32);
            $newAccesskey = new DbApiUserKeys;
            $newAccesskey->user = $user;
            $newAccesskey->access_key = $access_key;
            $newAccesskey->status = 1;
            $newAccesskey->create();
        }

        $this->response['message'] = 'Session refreshed';
        $this->response['access_key'] = $access_key;
        $this->response['status'] = 200;
        return $this->response;
    }



    /**
     * Api login method
     * @param array $param email, password
     * @return array $response 
     * @requestType POST
     */
    public function login( array $param = [])
    {
        $this->validateObject = [
            'email' => ['type' => 'str', 'min' => 5, 'max' => 255],
            'password' => ['type' => 'str', 'min' => 8, 'max' => 16],
        ];
        $param = $param ?: $this->request;
        $post = $this->sanitizeRequest($param);
        if($this->validateStatus == true){
            $email = $post['email'];
            $password = $post['password'];

            $user = $this->getTableData(Users::$tableName, " email = '$email' ");
            if($user != false){
                $dbPassword = base64_decode($user['password']);
                if($password === $dbPassword){
                    $this->response['status'] = true;
                    $this->response['message'] = 'Login successful.';
                    // turn off all users sessions
                    $sessions = new DbUserSessions;
                    $sessions->status = 0;
                    $sessions->dborder = 'DESC';
                    $sessions->update(" user = '".$user['id']."' ", 5);
                    // create users session
                    $sessionkey = ucwords($this->randKey(32));
                    $session = new DbUserSessions;
                    $session->user = $user['id'];
                    $session->token = $sessionkey;
                    $session->status = 1;
                    $session->create();
                    // session key
                    $this->response['token'] = $sessionkey;

                } else {
                    $this->response['message'] = $this->errors['invalid_password'];
                }
            } else {
                $this->response['message'] = str_replace('{email}', $email, $this->errors['invalid_user']);
            }
        } else {
            $this->response['message'] = $this->validateError;
        }
        return $this->response;
    }

    
    /**
     * Api login method
     * @param array $param email, password
     * @return array $response 
     * @requestType POST
     */
    public function signup( array $param = [])
    {
        $this->validateObject = [
            'names' => ['type' => 'str', 'min' => 5, 'max' => 255],
            'email' => ['type' => 'mail', 'min' => 6, 'max' => 255],
            'password' => ['type' => 'html', 'min' => 8, 'max' => 16],
            'retype' => ['type' => 'html', 'min' => 8, 'max' => 16],
        ];
        $param = $param ?: $this->request;
        $post = $this->sanitizeRequest($param);
        if($this->validateStatus == true){  
            $names = $post['names'];
            $email = $post['email'];
            $user = $this->getTableData(Users::$tableName, " email = '$email' ");
            if($user == false){
            $pass = $post['password'];
            $pass2 = $post['retype'];
            if($pass == $pass2){
                $dbPass = base64_encode($pass);
                $user = new DbUsers;
                $user->names = $names;
                $user->email = $email;
                $user->password = $dbPass;
                // additional logic for verification
                $user->create();

                // log user in
                $loginDetails = $this->login(['email' => $email, 'password' => $pass]);

                $this->response['status'] = true;
                $this->response['message'] = 'Account created successfully.';
                $this->response['token'] = $loginDetails['token'];
                
            } else {
                $this->response['message'] = $this->errors['invalid_password_match'];
                $this->response['key'] = 'password';
            }
        } else {
            $this->response['message'] = $this->errors['invalid_email'];
            $this->response['key'] = 'email';

        }
        } else {
            $this->response['message'] = $this->validateError['message'];
            $this->response['key'] = $this->validateError['key'];
        }
        return $this->response;

    }

}

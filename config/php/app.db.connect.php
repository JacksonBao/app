<?php
namespace App\Market\Config;
/**
 *
 */
class DBConnect
{
	public $dbm; // connect Wallet
	public $response = ['status' => 0, 'message' => '', 'response' => '', 'class' => ''];
	public $host;
	public $user;
	public $password;
	public $database;

	function __construct() {
			$this->host = 'localhost';
			$this->user = 'root';
			$this->password = '';
			$this->database = 'njofa_market';

			// $this->host = 'localhost';
			// $this->user = 'u4490457_';
			// $this->password = '';
			// $this->database =  @$_COOKIE['njofa_state'] == 'sandbox' ? 'u4490457_sandbox_njofa' : 'u4490457_njofa';
			if(!$this->dbm){
				// $this->dbm = parent::__construct($this->host,$this->user,$this->password,$this->database);
				try{
				$this->dbm = new \mysqli($this->host,$this->user,$this->password,$this->database);
			} catch(Exception $e){
				echo $e->getMessage();
				exit();
			}

			}
		}

		public function in_query($sql)
		{
			return $this->dbm->query($sql);
		}
	}

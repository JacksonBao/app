<?php
namespace App\APP_NAME\Config;
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
		// var_dump(debug_backtrace());
			$this->host = 'localhost';
			$this->user = 'root';
			$this->password = '';
			// $this->database = 'njofa_wallet';
			$this->database = 'njofa_wallet';

			// $this->host = 'localhost';
			// $this->user = 'u4490457_';
			// $this->password = '';
			// $this->database =  @$_COOKIE['njofa_state'] == 'sandbox' ? 'u4490457_sandbox_njofa' : 'u4490457_njofa';
			// if(!$_SESSION['connect']){
				if(!$this->dbm){

					// $this->dbm = parent::__construct($this->host,$this->user,$this->password,$this->database);
				// $this->dbm = parent::__construct($this->host,$this->user,$this->password,$this->database);
				$this->dbm = new \mysqli($this->host,$this->user,$this->password,$this->database);
				$_SESSION['connect'] = $this->dbm;
			    if ($this->dbm->connect_error) {
					die("Connection failed: " . $this->dbm->connect_error);
				 }
			}
			// return false;
			// } else {
			// 	$this->dbm = $_SESSION['connect'];
			// }
		}

		public function in_query($sql)
		{
			return $this->dbm->query($sql);
		}
	}

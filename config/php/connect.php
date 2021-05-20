<?php

namespace Config;

use Dotenv\Dotenv;

/**
 *
 */
class Connect
{
	public $db = false; // connect OBJECT
	public $DB_USER_CONNECT = false; // connect OBJECT
	public $DATABASE_APPEND  = '';
	public $REGISTERED_COOKIES = [];
	public $ROUTES =  [];
	public $AUTH_LINKS = [];
	public $API_ROUTE = [];
	PUBLIC $URL_IN_VIEW = '';
	
	function __construct()
	{
		Dotenv::createImmutable(__DIR__ . '/../')->load();
		$env = $_ENV['ENVIRONMENT'];
		$_ENV['REQUEST_TYPE'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
		$this->URL_IN_VIEW = $_ENV['REQUEST_TYPE'] . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$host = $_ENV[$env . '_HOST'];
		$user = $_ENV[$env . '_USER'];
		$password = $_ENV[$env . '_PASSWORD'];
		$database = $_ENV[$env . '_DATABASE'];

		if (!$this->db) {
			$this->DB_USER_CONNECT = new \mysqli($host, $user, $password, $database);
			if ($this->DB_USER_CONNECT->connect_error) {
				die("Connection failed: " . $this->DB_USER_CONNECT->connect_error);
			} else {
				// select db
				$db = $this->DB_USER_CONNECT::select_db($database);
				if($db){
					$this->db = $this->DB_USER_CONNECT;
					$this->DB_USER_CONNECT = false;
				}

			}
		}

		// get and configure routes
		$this->ROUTES = explode(',', str_replace(' ', '', $_ENV['APP_ROUTES']));
		$this->AUTH_LINKS = explode(',', str_replace(' ', '', $_ENV['APP_AUTH_ROUTES']));
		
		// GET COOKIES
		$this->REGISTERED_COOKIES = explode(',', str_replace(' ', '', $_ENV['APP_COOKIES']));
		$this->COOKIE_LOCATION = $_ENV['APP_COOKIE_LOCATION'];
		// API ROUTE
		$this->API_ENDPOINT = $_ENV['API_ENDPOINT'];

		// DATABASE APPEND
		$this->DATABASE_APPEND = $_ENV[strtoupper($env) . '_DATABASE_APPEND']; 
		// SET TIME ZONE
		date_default_timezone_set($_ENV['APP_TIME_ZONE']);

		// DEFINE VARIABLES
		define('ENV', $env);
		define('APP', $_ENV['APP_NAME']);
		define('APP_FOLDER', $_ENV['APP_DIR']);
		define('APP_NAME', $_ENV['APP_NAME']);
		define('APP_ROOT', $_SERVER['DOCUMENT_ROOT']);
		define('CURRENT_PATH', getcwd());
		define('DEFAULT_APP_PATH', $_ENV['APP_DEFAULT_DIR']);
		define('SITE_URL', $_ENV['REQUEST_TYPE'] . '://' . $_SERVER['SERVER_NAME']);
		define('lang', (@$_SESSION['LANG'] ?: $_ENV['LANG']));
		// SET UP FOR FILE UPLOAD 
		define('FILE_ROOT', str_replace(APP_FOLDER, $_ENV['APP_FILE_DIR'], APP_ROOT));
		define('PARENT_ROOT', str_replace(APP_FOLDER, '', APP_ROOT));
		define('PARENT_URL', $_ENV['APP_PARENT_URL']);
		define('FILE_DOMAIN', $_ENV['APP_FILE_DOMAIN']);
	}	

}

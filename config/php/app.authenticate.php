<?php
namespace App\APP_NAME\Config;
/**
*
*/

class AppAuthenticate extends DBConnect
{

	public $user = false;
	public $table = '';
	public $headerType = FALSE;
	public $system_urls = ['home', 'help', 'policies', 'admin', 'crons', 'reviews', 'report', 'notifications', 'send', 'setup','contacts', 'transactions', 'auth', 'moneyrequest', 'agent', 'dashboard', 'filehandler','location', 'profile','theme', 'engine', 'apps'];
	public $loginLinks = ['dashboard', 'admin', 'report', 'profile', 'notifications', 'transactions', 'send', 'moneyrequest', 'contacts', 'apps'];
	public $directory;

	public $WALLET_ADMIN_USERS = ['SUXVJ86F', 'SUPVUIOF', 'SUIXQU27', 'SUXVJ86A'];
	public $WALLET_ADMIN_USERS_LIST = "('SUXVJ86F', 'SUPVUIOF', 'SUIXQU27', 'SUXVJ86A')";
	protected $cookieLocation = '';
	public $urlInView = 'https://wallet.njofa.com';

	public $alertSuccess = false;
	public $alertError = false;

	public $appSettings = [ // appname => [countries]
		'debit-credit' => ['38', '231', 'EUR', 'GBP', 'UAE'],
	];


	public $DATABASE_APPEND = 'nj_wl_';
	public $WALLET_APP_FOLDER = 'market.app';
	public $WALLET_APP_NAME = 'Njofa Market v8';
	public $WALLET_APP_ROOT = '';
	public $imagePlaceholder = '/public/img/app/placeholder.jpg';
	// current SHOP ID
	public $AGENT_ID = '';
	public $AGENT_UNIQ = '';
	PUBLIC $USER_UNIQ = '';
	PUBLIC $USER_ID = '';
	public $WALLET_CURRENCY = '';
	public $WALLET_UNIQ = '';
	public $WALLET_ID = '';
	public $WALLET_TYPE = '';
	public $isAdmin = false;
	PUBLIC $USER_WALLET_KEY = '';
	
	PUBLIC $USER_DETAILS = [];
	public $emailTemplate = ['user' => [], 'body' => '', 'notification' => ''];

	public $apiUser = 'N0202804';
	public $apiToken = '';
	public $apiKey = 'n3lHV1gYzUWdSuq1zxxPe8QYWRlswSph';
	public $apiUrl = 'http://api.njofa.dv/';
    public $accountSuspended = false;

	public $headers = [
		'Content-Security-Policy' => [
			"default-src 'none'; font-src 'self' https://*.njofa.com https://fonts.gstatic.com;
			img-src 'self' blob: https://*.njofa.com https://code.jquery.com https://cdnjs.cloudflare.com; object-src 'none'; script-src 'self' https://*.njofa.com https://code.jquery.com  https://js.stripe.com  https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com 'unsafe-inline'; style-src 'self'  https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com  https://fonts.googleapis.com 'unsafe-inline'; connect-src 'self' https://*.njofa.com https://ipinfo.io;manifest-src 'self' https://*.njofa.com; frame-src 'self' https://js.stripe.com",
			
			// "default-src 'self' https://*.njofa.com  https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com  https://fonts.googleapis.com https://code.jquery.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com 'unsafe-inline' 'unsafe-eval'", "img-src 'self' https://*.njofa.com", 
			
			],
		'X-Content-Type-Options' => ['nosniff'],
		'Expect-CT' => ['report-uri=https://njofa.com,
		enforce,
		max-age=6307200'],
		'Feature-Policy' => ['accelerometer *'],
		'Strict-Transport-Security' => ['max-age=63072000; includeSubDomains']
	];
	
	public $registeredCookies = [
		'api_call_int', 'ckssusid_co', 'ck_isLocked_trials', 'sendObject', 'ck_isLocked'
	];
	function __construct()
	{
		parent::__construct();
		$this->WALLET_APP_ROOT = $_SERVER['DOCUMENT_ROOT'];
		$this->urlInView = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		// setup njofa api
		// $tz = (new \DateTime('now', new \	DateTimeZone('Africa/Douala')))->format('P');
		// $this->dbm->query("SET time_zone='$tz';");
		if(ENV == 'PRODUCTION'){
			$this->cookieLocation = 'njofa.com';
		}
		date_default_timezone_set("America/Toronto");

		$sid = session_id();
        setcookie(
            'PHPSESSID',//name
            $sid,//value
            strtotime('+30 days'),//expires at end of session
            '/',//path
            $this->cookieLocation,//domain
            true //secure
        );

		// secure cookies

	}

	public function resetUserDefault()
	{
		 $this->AGENT_ID = '';
		 $this->AGENT_UNIQ = '';
		 $this->USER_UNIQ = '';
		 $this->USER_ID = '';
		 $this->WALLET_CURRENCY = '';
		 $this->WALLET_UNIQ = '';
		 $this->WALLET_ID = '';
		 $this->WALLET_TYPE = '';
		 $this->USER_WALLET_KEY = '';
	}

	

}

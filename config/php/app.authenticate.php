<?php
namespace App\Market\Config;
/**
*
*/

class AppAuthenticate extends DBConnect
{

	public $user = false;
	public $table = '';
	public $headerType = FALSE;
	public $system_urls = ['home', 'setup', 'filehandler','location', 'profile','theme', 'engine'];
	public $urlInView = 'https://wallet.njofa.com';


	public $DATABASE_APPEND = 'nj_mp_';
	public $APP_FOLDER = 'market.app';
	public $APP_NAME = 'Njofa Market v8';
	public $APP_ROOT = '';
	public $imagePlaceholder = '/public/img/app/placeholder.jpg';
	// current SHOP ID
	public $PAGE_ID = 11;
	public $PAGE_UNIQ = 'NJ209403214411';
	PUBLIC $USER_UNIQ = 'NJ2020';

	PUBLIC $userDetails = [
		'NJ2020' => ['id' => '4', 'name' => 'Tosam Fred', 'image' => '/public/img/app/demo/b3.webp'],
		'NJ2019' => ['id' => '3', 'name' => 'Brenda Puss', 'image' => '/public/img/app/demo/b2.webp'],
		'NJ2018' => ['id' => '2', 'name' => 'Anold Sessie', 'image' => '/public/img/app/demo/b1.webp'],
		'NU324AOX1' => ['id' => '1', 'name' => 'Donald Sessie', 'image' => '/public/img/app/demo/p1.webp']
	];

	function __construct()
	{
		parent::__construct();
		$this->user = 'NU324AOX1';
		$this->APP_ROOT = $_SERVER['DOCUMENT_ROOT'];
		$this->urlInView = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	}



}

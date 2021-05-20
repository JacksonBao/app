<?php

/**
 * WALLET HOME CONTROLLER
 */
class Index extends  \Libraries\Controller
{


	function __construct()
	{
		parent::__construct('index');
		$this->pageTitle = $_ENV['app_name'];
		// load parent model
		include_once __DIR__ . '/../models/model.index.php';
		$this->model = new IndexModel();
		$this->LOAD_JS['main'][] = "app.auth.js";

	}

	public function intHome()
	{
		
		$this->meta = [
			'name' => 'Thanosapi.com | Free Currency converter & Crypto Currency converter',
			'description' => 'Developing APIs(stones) for developers by developers. We aim at building api which are fast, reliable and easily customizable. Our api\'s are simple to use and provided by Njofa for all its citizens',
			'author' => 'Njofa Developers',
			'site' => SITE_URL,
			'image' => $_ENV['app_logo'] 
		];
		$this->render('index');
	}
}

<?php

/**
 * PRIVACY CONTROLLER
 */
class Privacy extends \Libraries\Controller
{

	function __construct()
	{
		parent::__construct('privacy');
		$this->pageTitle =  ' Privacy | Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.privacy.php';
		$this->model = new PrivacyModel();
		// Load defaul js
		$this->LOAD_JS['main'][] = "app.privacy.js";
	}

	public function intHome()
	{
		$this->termsOfUse();
	}

	public function terms()
	{
		$this->meta = [
			'name' => 'Terms of use | Free Currency converter & Crypto Currency converter',
			'description' => 'Developing APIs(stones) for developers by developers. We aim at building api which are fast, reliable and easily customizable. Our api\'s are simple to use and provided by Njofa for all its citizens',
			'author' => 'Njofa Developers',
			'site' => SITE_URL,
			'image' => $_ENV['app_logo']
		];
		$this->render('terms');
	}
	public function privacyPolicies()
	{
		$this->meta = [
			'name' => 'Privacy Policies | Free Currency converter & Crypto Currency converter',
			'description' => 'Developing APIs(stones) for developers by developers. We aim at building api which are fast, reliable and easily customizable. Our api\'s are simple to use and provided by Njofa for all its citizens',
			'author' => 'Njofa Developers',
			'site' => SITE_URL,
			'image' => $_ENV['app_logo']
		];
		$this->render('privacy');
	}
}

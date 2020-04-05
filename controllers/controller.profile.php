<?php

/**
 * WALLET HOME CONTROLLER
 */
class Profile extends Controller
{
	

	function __construct()
	{
		parent::__construct('profile');
		$this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.profile.php';	
		$this->model = new ProfileModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}
}
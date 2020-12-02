<?php

/**
 * WALLET HOME CONTROLLER
 */
class Index extends  \App\APP_NAME\Libraries\Controller
{


	function __construct()
	{
		parent::__construct('index');
		$this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.index.php';
		$this->model = new IndexModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}
}

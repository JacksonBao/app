<?php

/**
 * WALLET HOME CONTROLLER
 */
class Theme extends  \App\APP_NAME\Libraries\Controller
{


	function __construct()
	{
		parent::__construct('theme');
		$this->pageTitle = 'Welcome to App Theme';
		// load parent model
		include_once 'models/model.theme.php';
		$this->model = new ThemeModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}
}

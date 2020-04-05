<?php

/**
 * WALLET HOME CONTROLLER
 */
class Category extends Controller
{
	

	function __construct()
	{
		parent::__construct('category');
		$this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.category.php';	
		$this->model = new CategoryModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}

	public function view($para)
	{
		$this->render('view', $this->user);
		
	}
}
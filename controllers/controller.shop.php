<?php

/**
 * WALLET HOME CONTROLLER
 */
class Shop extends Controller
{
	

	function __construct()
	{
		parent::__construct('shop');
		$this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.shop.php';	
		include_once 'models/model.shop.php';	
		$this->model = new ShopModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}


	public function pg($param = []) // $param = page name plus uniq, view
	{
		$page = $param[1];
		$this->$page($param[0]);
	}

	public function about($page = '')
	{
		$this->render('about', $this->user);
	}

	public function reviews($page = '')
	{
		$this->render('reviews', $this->user);
	}


	public function home($page = '')
	{
		$this->render('home', $this->user);		
	}

	public function products($page='')
	{
		$this->render('products', $this->user);		
	}
}
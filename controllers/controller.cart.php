<?php

/**
 * WALLET HOME CONTROLLER
 */
class Cart extends Controller
{
	

	function __construct()
	{
		parent::__construct('cart');
		$this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.cart.php';	
		$this->model = new CartModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}
}
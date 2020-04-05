<?php

/**
 * WALLET HOME CONTROLLER
 */
class Checkout extends Controller
{
	

	function __construct()
	{
		parent::__construct('checkout');
		$this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		include_once 'models/model.checkout.php';	
		$this->model = new CheckoutModel();
	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}
}
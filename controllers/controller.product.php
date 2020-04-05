<?php 

 /**
  * 
  */
 class Product extends Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct('product');
 		$this->pageTitle = 'Welcome to Njofa Market V8.0.1';
		// load parent model
		include_once 'models/model.product.php';	
		$this->model = new ProductModel();
 	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}
 }

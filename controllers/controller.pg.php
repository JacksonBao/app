<?php 

 /**
  * 
  */
 class Pg extends Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct('pg');
 		$this->pageTitle = 'Welcome to Njofa Market V8.0.1';
		// load parent model
		include_once 'models/model.pg.php';	
		$this->model = new PgModel();
 	}

	public function intHome()
	{
		$this->render('index', $this->user);
	}

	public function bestSeller($param = [])
	{
		$this->render('best_seller', $this->user);
	}


	public function newRelease($param = [])
	{
		$this->render('new_release', $this->user);
	}


	public function deals($param = [])
	{
		$this->render('deals', $this->user);
	}
 }

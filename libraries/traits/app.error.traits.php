<?php
namespace Traits;

Trait ErrorHandler{

	public $alertMessage = '';
	public $alertStatus = false;
	public $errorCard = '';


	public function errorMethodMessage($name = '')
	{
		$this->alertStatus = true;
		$this->alertMessage = 'Method Error message - ' . $name;
	}

	public function errorControllerMessage()
	{
		$this->LOAD_DIR = 'error';
		die('Controller Error');
		$this->render('controller', 0);

	}


	public function errorPage()
	{
		$this->errorControllerMessage();
	}
}

<?php
namespace Traits;

Trait RespondHandler{

	public $alertErrorMessages = '';
	public $alertSuccessMessages = '';
	public $alertError = false;
	public $alertSuccess = false;
	public $errorCard = '';


	public function errorMethodMessage($name = '')
	{
		$this->alertStatus = true;
		$this->alertMessage = 'Method Error message - ' . $name;
	}

	public function errorControllerMessage()
	{
		echo 'Controller error <br>';
		var_dump($this->URL_IN_VIEW);

	}


	public function errorPage()
	{
		echo 'errorPage <br> ';
		var_dump($this->URL_IN_VIEW);
	}
}

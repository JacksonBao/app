<?php 

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
		echo 'Controller error <br>';
		var_dump($this->urlInView);
		
	}


	public function errorPage()
	{
		echo 'errorPage <br> ';
		var_dump($this->urlInView);
	}
}

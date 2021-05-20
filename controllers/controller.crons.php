<?php
include_once __DIR__ . '/../libraries/int.app.background.php';
/**
 * CRONS CONTROLLER
 * Register CRONS
 * agent, deposit, notification, report, withdraw
 */
class Crons extends Libraries\Controller
{
	public $register_cron = [
		'deposit',
		'withdraw',
		'agent',
		'report'
	];
	function __construct()
	{
		parent::__construct('crons');
		$this->pageTitle =  ' Crons | ' . $_ENV['app_name'];
		// load parent model
		// include_once __DIR__ . '/../models/model.crons.php';
		// $this->model = new CronsModel();
	}

	public function intHome()
	{
		
	}

	/**
	 * @param string class,string method,array params
	 * @return array $response 
	 * @description Call a cron to run
	 */
	public function call(array $param = [])
	{
		if (count($param) > 1) {
			// declare list
			$fileClass = $param[0]; // a file class to run
			array_shift($param);
			// declare list
			$file = 'models/crons/' . $fileClass . '.cron.php';
			if (file_exists($file)) {

				include_once $file;
				$object = ucwords($fileClass) . 'Cron';
				if (class_exists($object)) {
					$method = $param[0]; // a method to run
					array_shift($param);

					$this->model = new $object();
					$method = str_replace(['_', '-'], ' ', $method);
					$method = ucwords($method);
					$method = lcfirst(str_replace(' ', '', $method));

					if (method_exists($this->model, $method)) {
						$response = $this->model->response;
						$response = $this->model->$method($param);
					} else {
						$response = $this->model->responseError();
					}
				} else {
					$response = $this->model->responseError();
				}
			} else {
				$response = $this->model->responseError();
			}
		} else {
			$response['response'] = '';
		}
		echo json_encode($response);
	}
}

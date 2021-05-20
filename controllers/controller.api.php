<?php
namespace Controllers;

/**
 * API CONTROLLER
 */
class Api extends \Libraries\Controller
{

	public $response = ['success' => false, 'message' => ''];
	PRIVATE $version;
	
	function __construct( $version = 'v1.0')
	{
		$this->version = $version ?: $_ENV['api_version'];
		parent::__construct('api');
		$this->pageTitle =  ' Api | Njofa Wallet V8.0.1';
		// Load defaul js
	}

	public function intHome($params)
	{
	}

	public function init(string $api, array $param = [])
	{
		$response = $this->response;
		$file = __DIR__ . '/../models/api/'.$this->version.'/' . strtolower($api) . '.api.php';
		if (file_exists($file)) {
			$className = $api;
			$class = ucwords($api) . 'Api';
			$class = '\Models\Api\\'.preg_replace('#[^a-zA-Z0-9]#i', '_', $this->version).'\\' . $class;
			if (class_exists($class)) {
				$this->model = new $class();
				$this->model->startTime = (float) microtime();
				$this->model->routeList = $class::$requests;
				$this->model->throttle = $class::$throttleList;

				$response = $this->model->response;
				$method = @$param[0] ?: '';
				$method = str_replace('-', ' ', $method);
				$method = str_replace(' ', '', lcfirst(ucwords($method)));
				if ( method_exists($this->model, $method)) {
					$this->model->loadEngineErrors('api', 'authenticate');
					$this->model->apiAuthenticate($className, $method);

					if ($this->model->canUseApi == true) {
						$folder = 'api_errors/' . $this->version;
						$this->model->loadEngineErrors('apiErr', $method, '', $folder);
						array_splice($param, 0, 1);
						$response = $this->model->$method($param);
						$response['query'] = $this->model->request;
						$this->model->registerApiCall($response);
					} else {
						$response = $this->model->response;
					}
				} else {
					$response['error_code'] = 500;
					$response['message'] = "HTTP/1.0 500 Request method not found. Please review documentation for method to call.";
				}
			} else {
				$response['error_code'] = 500;
				$response['message'] = "HTTP/1.0 500 Request object not found. Please review documentation for correct objects to call.";
			}
		} else {
			$response['error_code'] = 400;
			$response['message'] = "HTTP/1.0 400 Bad Request route not found.";
		}
		return $response;
	}


	
	public function reports(array $param = [])
	{
		return $this->init('reports', (array) $param);
	}
}

<?php

use Controllers\Api;

/**
 *
 */
class Bootstrap extends Config\Routes
{
	public $url;
    public $dir;
    public $param;
    public $controller;
    public $response;
    public $homeControllerUrl = __DIR__ . '/../controllers/controller.index.php';
	
	function __construct()
	{
		// start engine
		parent::__construct();
		$this->intV8Engine();
		
	}


	public function intV8Engine()
	{
		$route = getcwd();
		$routeSplit = explode('\\', $route);
		$folder = $routeSplit[count($routeSplit) - 2];
		if($folder == 'versions') {
			if(isset($_GET['url'])){
			$route = getcwd();
			$routeSplit = explode('\\', $route);
			$version = end($routeSplit);
			

	        $url = preg_replace('#[^a-zA-Z0-9 /_-]#i', '', $_GET['url']);
	        $url2 = preg_replace('#[^a-zA-Z0-9/_-]#i', '', $_GET['url']);

	        if(!empty($url)){
				$url = rtrim($url, '/');
	            $urlExp = explode('/', $url);

	            $urlLower = strtolower($url);
	            $urlLowerExp = explode('/', $urlLower);

	            $controllerName = $urlLowerExp[0];
				$api = new Api( $version );
				// check method
				if(method_exists($api, $controllerName)){
					array_shift($urlLowerExp);
					$response = $api->$controllerName($urlLowerExp);
				} else {
					$response['status'] = false;
					$response['message'] = 'Invalid end point.';
				}
			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Invalid request.';
		}
			header('Content-Type: application/json');
			echo json_encode($response);
			exit;

		} elseif(isset($_GET['url'])){
	        $url = preg_replace('#[^a-zA-Z0-9 /_-]#i', '', $_GET['url']);
	        $url2 = preg_replace('#[^a-zA-Z0-9/_-]#i', '', $_GET['url']);

	        if(!empty($url)){

				$url = rtrim($url, '/');
	            $urlExp = explode('/', $url);

	            $urlLower = strtolower($url);
	            $urlLowerExp = explode('/', $urlLower);

	            $controllerName = $urlLowerExp[0];

	            if(in_array($controllerName, $this->ROUTES)){

	            	$controllerFileName = 'controller.'.$controllerName.'.php';
	            	// include controller
	            	include_once __DIR__ .'/../controllers/' . $controllerFileName;

	            	// initaite crawler
	            	$controllerClass = ucfirst($controllerName);
	            	$controller = new $controllerClass();
	            	// check if we have pointing method

	            	if(count($urlLowerExp) > 1){
	            		// regenrate method without controller
	            		$urlClean = array_splice($urlExp, 1);

	            		$methodName = strtolower($urlClean[0]);
	            		// check if method is highened
	            		if(preg_match('#[^-_]#', $methodName)){
	            			$string = str_replace(['_', '-'], ' ', $methodName);
	            			$methodName = ucwords($string);
	            			$methodName = lcfirst(str_replace(' ', '', $methodName));
	            		}

	            		if(method_exists($controller, $methodName)) {
		            			$requestObject = array_splice($urlClean, 1);
		            			$controller->$methodName($requestObject);
		            	} else { // Load controller home page with error
		            		$controller->errorMethodMessage($methodName);
							$controller->intHome();
		            	}
	            	} else { // load method home
	            		$controller->intHome();
	            	}

	            } else { // the method doesnt exist load home
	            	include_once $this->homeControllerUrl;
					$homeController = new Index();
					if(preg_match('#[^-_]#', $controllerName)){
						$string = str_replace(['_', '-'], ' ', $controllerName);
						$controllerName = ucwords($string);
						$controllerName = lcfirst(str_replace(' ', '', $controllerName));
					}
					
					if(method_exists($homeController, $controllerName)){
						// $requestObject = array_splice($urlClean, 1);
						array_shift($urlExp);
						$homeController->$controllerName($urlExp);
					} else {
						// ver sion control for api
						$homeController->errorControllerMessage();
					}
	            }

	        } else { // load home page
	        	include_once $this->homeControllerUrl;
	        	$homeController = new Index();
	        	$homeController->intHome();

	        }
		} else { // load home page
			include_once $this->homeControllerUrl;
	        	$homeController = new Index();
	        	$homeController->intHome();
		}
	}

}

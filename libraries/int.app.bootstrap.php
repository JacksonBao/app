<?php

/**
 * 
 */
class Bootstrap 
{
	public $url;
    public $dir;
    public $param;
    public $controller;
    public $system_urls = ['home', 'category', 'cart', 'checkout', 'shop', 'pg', 'product', 'profile', 'dash', 'pg', 'qr', 'about', 'help', 'faq', 'theme'];
    public $response;
    public $homeControllerUrl = 'controllers/controller.index.php';
	
	function __construct()
	{
		// start engine
		$this->intV8Engine();
	}


	public function intV8Engine()
	{
		if(isset($_GET['url'])){
	        $url = preg_replace('#[^a-zA-Z0-9 /_-]#i', '', $_GET['url']);
	        $url2 = preg_replace('#[^a-zA-Z0-9/_-]#i', '', $_GET['url']);

	        if(!empty($url)){

				$url = rtrim($url, '/');
	            $urlExp = explode('/', $url);

	            $urlLower = strtolower($url);
	            $urlLowerExp = explode('/', $urlLower);
	            
	            $controllerName = $urlLowerExp[0];
	            
	            if(in_array($controllerName, $this->system_urls)){ 

	            	$controllerFileName = 'controller.'.$controllerName.'.php';
	            	// include controller
	            	include_once 'controllers/' . $controllerFileName;

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
	            	$homeController->errorControllerMessage();

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
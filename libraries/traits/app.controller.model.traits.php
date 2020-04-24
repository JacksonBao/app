<?php
 namespace App\Market\Traits;
/**
 *
 */
Trait ControllerModel
{

  private $className;

  public function generateClasses(string $method)
  {
    // controller file
    $method = strtolower($method);
    $controllerFile = 'controllers/controller.'.$method.'.php';
    $methodFile = 'models/model.'.$method.'.php';
    $method = ucwords($method);

    // create directory for $fileSizes
    $pageIndex = 'public/views/pages/'. $method .'/index.php';
    if(!file_exists($pageIndex)){
      $pageIndex = fopen($controllerFile, "w") or die("Unable to open file!");
      fwrite($pageIndex, '<h1>'.$method.'</h1>');
      fclose($pageIndex);
    }

    // controller file
    $controllerTemplate = $this->controllerFileTemplate($method);
    $methodTemplate = $this->methodFileTemplate($method);

    $myfile = fopen($controllerFile, "w") or die("Unable to open file!");
    fwrite($myfile, $controllerTemplate);
    fclose($myfile);

    $myfile2 = fopen($methodFile, "w") or die("Unable to open file!");
    fwrite($myfile2, $methodTemplate);
    fclose($myfile2);


  }


  private function controllerFileTemplate(string $method)
  {
    return '<?php

    /**
     * '.strtoupper($method).' CONTROLLER
     */
    class '.$method.' extends \App\Market\Libraries\Controller
    {

    	function __construct()
    	{
    		parent::__construct(\''.strtolower($method).'\');
    		$this->pageTitle =  \' '.ucfirst($method).' | Njofa Market V8.0.1\';
    		// load parent model
    		include_once \'models/model.'.strtolower($method).'.php\';
    		$this->model = new '.$method.'Model();
    	}

    	public function intHome()
    	{
    		$this->render(\'index\');
    	}
    }
    ';
  }


  private function methodFileTemplate(string $method)
  {
      return '<?php


      /**
       * Index moel
       */
      class '.$method.'Model extends \App\Market\Libraries\Models
      {

      	function __construct()
      	{
      		parent::__construct();

      	}
      }

      ';
  }

}

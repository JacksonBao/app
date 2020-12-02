<?php
 namespace App\APP_NAME\Traits;
/**
 *
 */
Trait ControllerModel
{

  private $className;

  public function generateErrorFiles(string $method)
  {
    // controller file
    $method = strtolower($method);
    $controllerFile = 'models/app.engine.models/app.engine.errors/'.$method.'_errors/error_en.php';;
    // $method = ucwords($method);

    // create directory for $fileSizes
    $pageIndex = $controllerFile;
      @mkdir('models/app.engine.models/app.engine.errors/'.$method.'_errors/');
      $pageIndexOpen = fopen($pageIndex, "w") or die("Unable to open file!");
      $content = '
        <?php 
            
        /**
         * '.strtoupper($method).' ERROR LIST
         */

        return [];
        
      ';
      fwrite($pageIndexOpen, $content);
      fclose($pageIndexOpen);
    

  }

  public function generateClasses(string $method)
  {
    // controller file
    $method = strtolower($method);
    $controllerFile = 'controllers/controller.'.$method.'.php';
    $methodFile = 'models/model.'.$method.'.php';
    $method = ucwords($method);

    // create directory for $fileSizes
    $pageIndex = 'public/views/pages/'. strtolower($method) .'/index.php';
    // if(!file_exists($pageIndex)){
      @mkdir('public/views/pages/'. strtolower($method) .'/');
      $pageIndexOpen = fopen($pageIndex, "w") or die("Unable to open file!");
      fwrite($pageIndexOpen, '<h1>'.$method.'</h1>');
      fclose($pageIndexOpen);
    // }

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
    class '.$method.' extends \App\APP_NAME\Libraries\Controller
    {

    	function __construct()
    	{
    		parent::__construct(\''.strtolower($method).'\');
    		$this->pageTitle =  \' '.ucfirst($method).' | Njofa Wallet V8.0.1\';
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
       * Index model
       */
      class '.$method.'Model extends \App\APP_NAME\Libraries\Models
      {

      	function __construct()
      	{
      		parent::__construct();

      	}
      }

      ';
  }

}

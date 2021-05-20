<?php

/**
 * WALLET HOME CONTROLLER
 */

class Filehandler extends  \Libraries\Controller
{
	use \App\APP_NAME\Traits\Uploader;
	function __construct($loc = 'i', $opt = 'Default')
	{
		parent::__construct('');
		// $this->pageTitle = 'Welcome to Njofa Wallet V8.0.1';
		// load parent model
		// include_once 'models/model.fileHandler.php';
		// $this->model = new FileHandlerModel();
	}

     function intHome($para = []){
     }

     function upload() {
         $resp = $this->uploadFile();
         echo $resp;
     }

     function delete() {
         $resp = $this::deleteFile();
         echo $resp;
     }

}

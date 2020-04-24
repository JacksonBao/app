<?php

/**
 * WALLET HOME CONTROLLER
 */
class Setup extends  \App\Market\Libraries\Controller
{


	function __construct()
	{
		parent::__construct('setup');
		$this->pageTitle = 'Market System Setup';
		// load parent model
		include_once 'models/model.setup.php';
		$this->model = new SetupModel();

	}

	public function intHome()
	{
		$this->conmodel();
	}

	public function conmodel(array $param = [])
	{
			if(count($param) > 0 && $param[0] == 'generate'){
				$this->body = $this->model->generateControllerModel();
			} else {
				$this->body = $this->model->getControllerModels($param);
			}
			$this->render('index');
	}

	public function tables(array $param = [])
	{
		if(count($param) > 0 && $param[0] == 'generate'){
			$this->body = $this->model->generateTableModels();
		} else {
			$this->body = $this->model->getModelTables($param);
		}
		$this->render('index');
	}

}

<?php


/**
 * Index moel
 */


include_once 'libraries/traits/app.model.table.traits.php';
include_once 'libraries/traits/app.controller.model.traits.php';



class SetupModel extends \Libraries\Models
{
	use \Libraries\Traits\ControllerModel;
	use \Libraries\Traits\ModelTables;
	function __construct()
	{
		parent::__construct();
	}

	public function getControllerModels()
	{
		$exist = ''; $notAvailable = '';
		$urlList = $this->ROUTES;
		foreach ($urlList as $key => $meth) {
			$file = 'controllers/controller.'.$meth.'.php';
			if(file_exists($file)){
				$exist .= '<li class="list-group-item bg-light">'.ucwords($meth).'</li>';
			} else {// files does not exist
				$notAvailable .= '<li class="list-group-item bg-dark">'.ucwords($meth).'</li>';
			}
		}
					return '
					<div class="py-2 mb-3 border-bottom"><h4>Tables</h4></div>
					<div class="py-2 mb-2">
						<ul class="list-group text-main">
						'.$notAvailable.'
						'.$exist.'
						</ul>
					</div>
					<div class="py-5 text-center">
						<p class="mb-3">Generate all files </p>
						<a href="/setup/conmodel/generate" class="btn btn-third">GENERATE ALL</a>

					</div>
				</div>
					';
	}
	public function getModelTables()
	{
		
		$exist = ''; $notAvailable = '';

		$sql = "SHOW TABLES FROM " . $_ENV[$_ENV['environment'] .'_database'];
		$result = $this->query($sql);
		while ($row = mysqli_fetch_row($result)) {
			// $this->query("ALTER TABLE ".$row[0]." CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT");
		  $table = str_replace(['nj_wl_', '_'], ['', '.'], $row[0]);
		  $table = str_replace(' ', '', ucwords(str_replace('.', ' ', $table)));
		  $classnameSplit = preg_split('/(?=[A-Z])/', trim($table));
    	  array_shift($classnameSplit);
			// check if file apc_exists
			$file = 'models/classes/' . strtolower(join('.', $classnameSplit)) . '.php';
			if(file_exists($file)){
				$exist .= '<li class="list-group-item bg-light">'.ucwords($table).'</li>';
			} else {// files does not exist
				$notAvailable .= '<li class="list-group-item bg-dark">'.ucwords($table).'</li>';
			}
		}

			return '
			<div class="py-2 mb-3 border-bottom"><h4>Tables</h4></div>
			<div class="py-2 mb-2">
				<ul class="list-group text-main">
				'.$notAvailable.'
				'.$exist.'
				</ul>
			</div>
			<div class="py-5 text-center">
				<p class="mb-3">Generate all files </p>
				<a href="/setup/tables/generate" class="btn btn-third">GENERATE ALL</a>

			</div>
		</div>
			';

	}

public function generateControllerModel()
{
	$list = '';
	$urlList = $this->ROUTES;
	foreach ($urlList as $key => $meth) {
		$file = 'controllers/controller.'.$meth.'.php';
		if(!file_exists($file)){
			$this->generateClasses($meth);
			$list .= '<li class="list-group-item bg-light">'.ucwords($meth).': '.$file.'</li>';
		}
	}

		if(empty($list)) {
			$list = '<h4 class="display-4">You are all caught up</h4>';
		} else {
			$list = '<li><h4>Files created successfully.</h4></li> ' . $list;
		}

		return '
		<div class="py-2 mb-3 border-bottom"><h4>Tables</h4></div>
		<div class="py-2 mb-2">
			<ul class="list-group text-main">
			'.$list.'
			</ul>
		</div>
		<div class="py-5 text-center">
			<p class="mb-3">Generate all files </p>
			<a href="/setup/tables/generate" class="btn btn-third">GENERATE ALL</a>

		</div>
	</div>
		';

}


public function generateTableModels()
{
	
			$list = '';
			$sql = "SHOW TABLES FROM " .  $_ENV[$_ENV['environment'] .'_database'];
			$result = $this->query($sql);
			if(mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_row($result)) {
			
				// $this->query("ALTER TABLE ".$row[0]." CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT");
				$table = str_replace(['nj_wl_', '_'], ['', '.'], $row[0]);
				$table = str_replace(' ', '', ucwords(str_replace('.', ' ', $table)));
				$classnameSplit = preg_split('/(?=[A-Z])/', trim($table));
				array_shift($classnameSplit);
				// check if file apc_exists
				$file = 'models/classes/' . strtolower(join('.', $classnameSplit)) . '.php';

				// check if file apc_exists
				if(!file_exists($file)){
					$this->generateModelTableTemplate($row[0]);
					$list .= '<li class="list-group-item bg-light">'.ucwords($table).': '.$file.'</li>';
				} else {
					continue;
				}

				}
					if(!empty($list)){$list = '<li><h4>Files created successfully.</h4></li> ' . $list;}
			}
			if(empty($list)) {
				$list = '<h4 class="display-4">You are all caught up</h4>';
			}

			return '
			<div class="py-2 mb-3 border-bottom"><h4>Tables</h4></div>
			<div class="py-2 mb-2">
				<ul class="list-group text-main">
				'.$list.'
				</ul>
			</div>
			<div class="py-5 text-center">
				<p class="mb-3">Generate all files </p>
				<a href="/setup/tables/generate" class="btn btn-third">GENERATE ALL</a>

			</div>
		</div>
			';
}

public function generateEngineErrorFiles()
{
	$list = '';
	$urlList = $this->ROUTES;
	
	foreach ($urlList as $key => $meth) {
		// $file = 'controllers/controller.'.$meth.'.php';
		$file = 'models/errors/'.$meth.'_errors/en.php';// controller.'.$meth.'.php';
		if(!file_exists($file)){
			$this->generateErrorFiles($meth);
			$list .= '<li class="list-group-item bg-light">'.ucwords($meth).': '.$file.'</li>';
		}
	}

		if(empty($list)) {
			$list = '<h4 class="display-4">You are all caught up</h4>';
		} else {
			$list = '<li><h4>Files created successfully.</h4></li> ' . $list;
		}

		return '
		<div class="py-2 mb-3 border-bottom"><h4>Tables</h4></div>
		<div class="py-2 mb-2">
			<ul class="list-group text-main">
			'.$list.'
			</ul>
		</div>
		<div class="py-5 text-center">
			<p class="mb-3">Generate all files </p>
			<a href="/setup/tables/generate" class="btn btn-third">GENERATE ALL</a>

		</div>
	</div>
		';
	
}

public function getEngineErrorFiles()
{
	
	$exist = ''; $notAvailable = '';
	$urlList = $this->ROUTES;
	foreach ($urlList as $key => $meth) {
		$file = 'models/app.engine.models/app.engine.errors/'.$meth.'_errors/error_file_en.php';// controller.'.$meth.'.php';
		if(file_exists($file)){
			$exist .= '<li class="list-group-item bg-light">'.ucwords($meth).'</li>';
		} else {// files does not exist
			$notAvailable .= '<li class="list-group-item bg-dark">'.ucwords($meth).'</li>';
		}
	}
				return '
				<div class="py-2 mb-3 border-bottom"><h4>Tables</h4></div>
				<div class="py-2 mb-2">
					<ul class="list-group text-main">
					'.$notAvailable.'
					'.$exist.'
					</ul>
				</div>
				<div class="py-5 text-center">
					<p class="mb-3">Generate all files </p>
					<a href="/setup/engineErrors/generate" class="btn btn-third">GENERATE ALL</a>

				</div>
			</div>
				';
}


}

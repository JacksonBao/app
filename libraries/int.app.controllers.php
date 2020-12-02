<?php
namespace App\APP_NAME\Libraries;

/**
 *
 */
class Controller extends \App\APP_NAME\Config\AppAuthenticate
{
 Use \App\APP_NAME\Traits\View, \App\APP_NAME\Traits\ErrorHandler;

	public $directory;
	public $file;
	public $method = 'intHome';
	public $headerType = FALSE;
	// method JS
	public $meta,$view,$breadcrumbs,$runJsFunction,$pageTitle,$search,$active;
	public $loadCss = [];
	public $loadJs = [ 'root' => [], 'link' => [], 'main' => ['app.js']];
	public $metaTags = [];
	public $alphaArray;
	public $renderStatus = false;

	// method JS


	function __construct($directory, $file = 'index')
	{
		parent::__construct();
		$this->directory = $directory;
		$this->file = $file;
	}
}

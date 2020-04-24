<?php
namespace App\Market\Libraries;

/**
 *
 */
class Controller extends \App\Market\Config\AppAuthenticate
{
 Use \App\Market\Traits\View, \App\Market\Traits\ErrorHandler;

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

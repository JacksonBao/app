<?php


/**
 * 
 */
class Controller extends Functions
{
	public $urlInView = 'https://wallet.njofa.com';
	public $directory;
	public $file;
	public $method = 'intHome';
	
	// method JS
	public $meta,$view,$breadcrumbs,$runJsFunction,$pageTitle,$search,$active;
	public $loadCss = [];
	public $loadJs = ['main' => ['app.js'], 'link' => [], 'root' => []];
	public $metaTags = [];
	public $alphaArray;
	public $renderStatus = false;
	// method JS


	function __construct($directory, $file = 'index')
	{
		parent::__construct();
		$this->directory = $directory;
		$this->file = $file;
		$this->urlInView = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
}
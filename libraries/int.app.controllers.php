<?php
namespace Libraries;

/**
 *
 */
class Controller extends \Libraries\Functions
{
 Use \Traits\View, \Traits\ErrorHandler;

	public $directory;
	public $file;
	public $method = 'intHome';
	public $headerType = FALSE;
	// method JS
	public $meta,$view,$breadcrumbs,$runJsFunction,$pageTitle,$search,$active;
	public $LOAD_CSS = [];
	public $LOAD_JS = [ 'root' => [], 'link' => [], 'main' => ['app.js', 'app.classes.js', 'app.form.validate.js', 'app.api.js']];
	public $metaTags = [];
	public $alphaArray;
	// method JS


	function __construct($directory, $file = 'index')
	{
		parent::__construct();
		$this->LOAD_DIR = $directory;
		$this->file = $file;
		
	}
}

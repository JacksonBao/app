<?php
namespace Config;
/**
*
*/

class Routes 
{

	public $HEADER_TYPE = FALSE;
	public $LOAD_DIR;

	public $ALERT_SUCCESS = false;
	public $ALERT_ERROR = false;

	public $HEADERS = [];
	

	function __construct()
	{
		$this->APP_ROOT = APP_ROOT;

		// SECURE HEADERS
		$this->HEADERS = [
			'Content-Security-Policy' => [
				"default-src 'none'; font-src 'self' https://*.".$_ENV['APP_DOMAIN']." https://fonts.gstatic.com;
				img-src 'self' blob: https://*.".$_ENV['APP_DOMAIN']." https://code.jquery.com https://cdnjs.cloudflare.com; object-src 'none'; script-src 'self' https://*.".$_ENV['APP_DOMAIN']." https://code.jquery.com  https://js.stripe.com  https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com 'unsafe-inline'; style-src 'self'  https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com  https://fonts.googleapis.com 'unsafe-inline'; connect-src 'self' https://*.".$_ENV['APP_DOMAIN']." https://ipinfo.io;manifest-src 'self' https://*.".$_ENV['APP_DOMAIN']."; frame-src 'self' https://js.stripe.com",
				
				// "default-src 'self' https://*.".$_ENV['APP_DOMAIN']."  https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com  https://fonts.googleapis.com https://code.jquery.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com 'unsafe-inline' 'unsafe-eval'", "img-src 'self' https://*.".$_ENV['APP_DOMAIN']."", 
				
				],
			'X-Content-Type-Options' => ['nosniff'],
			'Expect-CT' => ['report-uri=https://'.$_ENV['APP_DOMAIN'].',
			enforce,
			max-age=6307200'],
			'Feature-Policy' => ['accelerometer *'],
			'Strict-Transport-Security' => ['max-age=63072000; includeSubDomains']
		];

	}


}

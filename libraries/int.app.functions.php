<?php

namespace Libraries;

use Models\Classes\ApiUserKeys;

/**
 *
 */

class Functions extends \Config\Connect
{
	use \Traits\EmailTemplateTraits;
	use \Traits\ComponentsTraits;
	use \Traits\CookiesSessionsTraits;
	use \Traits\Uploader, \Traits\ValidateForm;
	use \Traits\NotificationTemplateTraits;
	use \Traits\AdminSupport;
	// use Traits\;
	// use Traits\;

	public $snoopiUrl;
	public $meta = [];
	public $metaTags = '';
	function __construct()
	{
		parent::__construct();
		$ip = $this->getClientIp();
		$this->snoopiUrl = 'https://api.snoopi.io/' . $ip . '?apikey=7d548e49e9d110016dae82dc395a6d30';
		// register secure cookies
		if(isset($_COOKIE)){
			foreach ($this->REGISTERED_COOKIES as $key => $cookie) {
				if(array_key_exists($cookie, $_COOKIE)){
					$content = $_COOKIE[$cookie];
					$this->addCookie($cookie, $content, '1 days');
				}
			}
		}

		$this->getApiToken();
	}


	/**
	 * Generate meta tags for current page
	 * @param array $meta keyList: name, description, creator, site_name, video, image, url
	 * @return string meta tags
	 */

	function generateMeta()
	{
  
	  $meta = $this->meta;
	  $meta['name'] = (isset($meta['name']) ? $meta['name'] . ' | '. APP_NAME : $this->pageTitle);
	  $meta['url'] = @$meta['url'] ?: $this->URL_IN_VIEW;

	  if (is_array($meta)) {
		$ogTags  = $twitter = '';
		$metadesc = '';
		$metaLink = '';
		
		foreach ($meta as $title => $content) {
		  $content = preg_replace('#["]#', '', $content);
  
		  if ($title == "video") {
			$ogTags .= '
					  <meta property="og:video" content="' . @$content['url'] . '" />
					  <meta property="og:video:url" content="' . @$content['url'] . '" />
					  <meta property="og:video:secure_url" content="' . @$content['url'] . '" />
					  <meta property="og:type" content="' . @$content['type'] . '" />
					  <meta property="og:video:width" content="' . @$content['width'] . '" />
					  <meta property="og:video:height" content="' . @$content['height'] . '" />
					  <meta property="og:image" content="' . @$content['image'] . '" />
					';
			continue;
		  } elseif ($title == "name") {
			// <meta name="'.$title.'" content="'.$content.'" />
			$metaLink .= '
				<meta itemprop="' . $title . '" content="' . $content . '" />
				';
				$twitter .= '
				<meta name="twitter:title" content="' . $content . '" />';
				$ogTags .= '
			<meta property="og:title" content="' . $content . '" />
						';
				continue;
			} elseif ($title == 'image') {

				$content = str_replace('http:', 'https:', $content);
				$metaLink .= '
				<meta itemprop="image" content="' . $content . '" />';
				$twitter .= '
				<meta name="twitter:image:src" content="' . $content . '" />';
				$ogTags .= '
				<meta property="og:image" itemprop="image"  content="' . $content . '" />
				';
				continue;
			} elseif ($title == 'site' || $title == 'creator') {
				$twitter .= '
				<meta name="twitter:' . $title . '" content="' . $content . '" />
				';
				continue;
			} elseif ($title == 'site_name' || $title == 'url' || $title == "type") {
				if ($title == 'type' && array_key_exists('video', $meta)) {
				continue;
				}
				$ogTags .= '
				<meta property="og:' . $title . '" content="' . $content . '" />
				';
				continue;
		  }
  
			if ($title == 'description') {
				$metadesc = '<meta name="description" content="' . $content . '">';
			}
	
			$metaLink .= '
				<meta itemprop="' . $title . '" content="' . $content . '" />
				';
			$twitter .= '
				<meta name="twitter:' . $title . '" content="' . $content . '" />
				';
			$ogTags .= '
				<meta property="og:' . $title . '" content="' . $content . '" />
				';
			}
			$metaTags  = $metadesc . ' <!-- Google / Search Engine Tags --> ' . $metaLink . ' <!-- Facebook Meta Tags --> ' . $ogTags . '  <!-- Twitter Meta Tags --> ' . $twitter;
			$this->metaTags = $metaTags;
			return $metaTags;
	  }
	}
  


	function rightButtons(){
		$buttons = '<div style="position:fixed;right:25px;bottom:20px;background:transparent;overflow:hidden; z-index:30;line-height: 30px;text-align: center;z-index: 31" class="pointer">
		<div class="pointer" onclick="toggleBtnRgt()" style="width:30px;height: 30px;background: #ee3829;border-radius: 50%;cursor: pointer">
		<span class="fa fa-th w3-text-white pointer"></span>
		</div>
	  </div>
	  <div  id="rightBtn" style="position:fixed;right:0;bottom:0;width:55px;height:140px;background:transparent;overflow:hidden; z-index:30;display: block;" class="hidden-xs hidden-sm">
	  <!-- list items  -->
	  <ul class="_ft_nav">
	  <li class="_fl_li pointer animated fadeInRight mb-2 " data-placement="left" data-toggle="tooltip" title="Screen Lock." onclick="startPattern()" style="background: rgba(0,0,0,.5)"> <i class="fas fa-lock"></i></li>
	  <li class="_fl_li pointer  animated fadeInRight " data-placement="left" data-toggle="tooltip" title="Log out of njofa." style="background: rgba(0,0,0,.5)"><a href="/auth/logout"><span class="fas fa-sign-out-alt"></span></a></li>
	  </ul>
	  <!-- list items  -->
	  ';
	  return $buttons;
	  }


	// parse css to php array from link
	function convertCss(string $css, string $type = 'file', $req = 'parent') // result: parent => ['d-block'=> 'display:block;margin:auto'], child => ['d-block' => ['display' => 'block']]
	{
		if ($type == 'file') {
			if (file_exists($css)) {
				$file = fopen($css, 'r');
				$css = fread($file, filesize($css));
				fclose($file);
			} else {
				return false;
			}
		}


		// remove all comments
		$regex = array(
			"`^([\t\s]+)`ism" => '',
			"`^\/\*(.+?)\*\/`ism" => "",
			"`(\A|[\n;]+)/\*.+?\*/`s"=>"$1", 
			"`(\A|[;\s]+)//.+\R`"=>"$1\n", 
			"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
		);
		$css = preg_replace(array_keys($regex), $regex, $css);
		// remove all comments
		
		$results = array();
		
		preg_match_all('/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $css, $matches);
		foreach ($matches[0] as $i => $original) {
			if ($req == 'parent') {
				$name = explode('{', $original)[0];
				$name = str_replace(['.', '#'], '', $name);
				$nameExp = explode(',', str_replace(' ', ',', $name));
				foreach ($nameExp as $name1) {
					$name1 = trim($name1);
					if(empty($name1)){continue;}
					$cssItems = trim($matches[2][$i]);
					$cssItems = substr($cssItems, -1) == ';' ? $cssItems : $cssItems . ';';

					$results[$name1] = $cssItems;
				}
				
			} else {
				foreach (explode(';', $matches[2][$i]) as $attr)
					if (strlen(trim($attr)) > 0) // for missing semicolon on last element, which is legal
					{
						list($name, $value) = explode(':', $attr);
						$results[$matches[1][$i]][trim($name)] = trim($value);
					}
			}
		}
		return $results;
	}
	// parse css to php array from link




	// get week start date and end dates
	public function getWeekStartEnd(string $week = '', string $year = '')
	{
		if (empty($week)) {
			$week = date('W');
		}
		if (empty($year)) {
			$year = date('Y');
		}

		$from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
		$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week

		return ['from' => $from, 'to' => $to];
	}

	public function getDateDiff(string $from, string $to)
	{
		// Declare and define two dates 
		$date1 = strtotime($from);
		$date2 = strtotime($to);

		// Formulate the Difference between two dates 
		$diff = abs($date1 - $date2);

		// check status if its minus
		$diffView = ($date1 - $date2 > 0 ? true : false);

		// To get the year divide the resultant date into 
		// total seconds in a year (365*60*60*24) 
		$years = floor($diff / (365 * 60 * 60 * 24));


		// To get the month, subtract it with years and 
		// divide the resultant date into 
		// total seconds in a month (30*60*60*24) 
		$months = floor(($diff - $years * 365 * 60 * 60 * 24)
			/ (30 * 60 * 60 * 24));


		// To get the day, subtract it with years and 
		// months and divide the resultant date into 
		// total seconds in a days (60*60*24) 
		$days = floor(($diff - $years * 365 * 60 * 60 * 24 -
			$months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


		// To get the hour, subtract it with years, 
		// months & seconds and divide the resultant 
		// date into total seconds in a hours (60*60) 
		$hours = floor(($diff - $years * 365 * 60 * 60 * 24
			- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
			/ (60 * 60));


		// To get the minutes, subtract it with years, 
		// months, seconds and hours and divide the 
		// resultant date into total seconds i.e. 60 
		$minutes = floor(($diff - $years * 365 * 60 * 60 * 24
			- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
			- $hours * 60 * 60) / 60);


		// To get the minutes, subtract it with years, 
		// months, seconds, hours and minutes 
		$seconds = floor(($diff - $years * 365 * 60 * 60 * 24
			- $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
			- $hours * 60 * 60 - $minutes * 60));

		// Print the result 
		return [
			'year' => $years, 'months' => $months, 'days' => $days, 'hours' => $hours,
			'minutes' => $minutes, 'seconds' => $seconds, 'status' => $diffView
		];
	}

	function timeAgo($datetime, $full = false)
	{
		$now = new \DateTime;
		$ago = new \DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	function len($str, $len)
	{
		$str = trim($str);
		if (strlen($str) > $len) {
			$str = preg_replace("/\n/", '', $str);
			$str = wordwrap($str, $len);
			$str = explode("\n", $str, 2);
			$str = $str[0] . '<span id="appDots">...</span>';
		}
		return $str;
	}

	
	public function njofaApiCalls(string $method, array $object = [])
	{
		$object = array_merge([
			'api_token' => $this->API_TOKEN,
		], $object);
		$responses = $this->phpPost($object, $_ENV['NJOFA_API_ENDPOINT'] . $method);
		$response = (array) json_decode($responses) ?: ['status' => 0, 'lover' => $responses];
		if($response['status'] == 200){ $response['status'] == true; } else { $response['status'] == false;}
		return $response;
	}

	

    public function apiLog($title,  ?string $error)
    {
        $dir = __DIR__ . '/../public/api/logs/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        if(!file_exists($dir)){
            $this->createDir($dir);
        }
  
      if (strlen($error) > 0) {
        $errorFile = fopen($dir . strtolower($title) . "_logs.txt", "a+") or die("Unable to open file!");
        $txt = date('Y-m-d h:i:s') . ": $error, \n";
        fwrite($errorFile, $txt);
        fclose($errorFile);
      }
    }

    
	public function apiCalls(string $method, array $object = [], string $type = 'POST')
	{
		$object = array_merge([
			'key' => @$_SESSION['user']['api_key'],
		], $object);
		$responses = $this->cUrlGetData( $this->API_ENDPOINT . $method, $object, $type);
		return $responses;
	}



    function cUrlGetData($url, $post_fields = null,  string $type = 'POST', $headers = null)
    {
        $ch = curl_init();
        // $timeout = 5;
        if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        } else {
            $url .= '?' . http_build_query($post_fields);
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        if (is_array($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            // $this->pluginLogs('API_ERR', curl_error($ch));
        }

        curl_close($ch);
        return (array) json_decode($data, true);
    }



	/**
	 * WORKING NJOFA MAIN API
	 */
	public function getApiToken() 
	{

		if (isset($_COOKIE['api_call_int']) && $_COOKIE['api_call_int'] == date('Ymd') && isset($_SESSION['API_ACCESS_TOKEN']) && strlen($_SESSION['API_ACCESS_TOKEN']) == 32) {
			$this->API_TOKEN = $_SESSION['API_ACCESS_TOKEN'];
		} else {
			$object = [
				'api_user' => $_ENV['NJOFA_API_USER'],// $this->apiUser,
				'api_key' => $_ENV['NJOFA_API_KEY'],// $this->apiKey
			];
			// setcokkie for cookie
			$response = (array) json_decode($this->phpPost($object, $_ENV['NJOFA_API_ENDPOINT'] . 'engine/nauth/auth/')) ?: ['status' => ''];
			if ($response['status'] == 200) {
				$this->addCookie("api_call_int", date('Ymd'), '+1 day');//, "/", "", "", FALSE);
				$_SESSION['API_ACCESS_TOKEN'] = $response['token'];
				$this->API_TOKEN = $response['token'];
			}
		}


	}

	public function createSlug(string $name)
	{
		$name = strtolower($name);
		$name = preg_replace('#[^a-zA-Z0-9 ]#i', '', $name);
		$name = str_replace(' ', '-', $name);
		$name = rtrim($name, '-');
		$name = ltrim($name, '-');
		$name = substr($name, 0, 150);
		return $name;
	}


	function ipLocation() : array
	{
		$geo_arr = [];
		if (!isset($_SESSION['USER_GEO_LOCATION']) || empty($_SESSION['USER_GEO_LOCATION']['CountryName'])) {
			$geo = $this->get_url_content($this->snoopiUrl)['content'];
			$geo_arr = (array) json_decode($geo);
			$_SESSION['USER_GEO_LOCATION'] = $geo_arr;
		} else {
			$geo_arr = $_SESSION['USER_GEO_LOCATION'];
		}

		$array['Country'] = @$geo_arr["CountryName"];
		$array['Region'] = @$geo_arr["State"];
		$array['City'] = @$geo_arr["City"];
		$array['Data'] = $geo_arr;
		return $array;
	}


	/**
	 * SEND POST REQUESTS
	 */
	function phpPost($data, $url)
	{
		if (is_array($data)) {
			if (!empty($url)) {
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HEADER, "application/x-www-form-urlencoded");
				$resp = curl_exec($ch);
				if (curl_error($ch)) {
					return curl_error($ch);
				}

				curl_close($ch);
				return $resp;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}




	public function getTableData(string $dbpage, $id, int $lim = null)
	{
		if (is_array($id)) {
			$id = $this->sqlExpress($id);
		} elseif (is_numeric($id)) {
			$id = " id = '$id' ";
		} elseif (!empty($id)) {
			$id = str_ireplace([' drop ', ' delete ', ' insert ', ' update '], '', $id);
		} else {
			return false;
		}

		$limit = ' LIMIT 1 ';
		if ($lim === 0) {
			$limit = '';
		} elseif ($lim > 0) {
			$limit = ' LIMIT ' . $lim;
		}


		if (strpos($dbpage, $this->DATABASE_APPEND) === FALSE) {
			$dbpage = $this->DATABASE_APPEND . $dbpage;
		}
		$rowList = [];
		$query = $this->query("SELECT * FROM $dbpage WHERE $id $limit") or die($this->db->error . $dbpage . $id);
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				if ($lim === null) {
					return $row;
				} else {
					$rowList[] = $row;
				}
			}
			return $rowList;
		} else {
			return false;
		}
	}


	function getRandomUserAgent()
	{
		$userAgents = array(
			"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
			"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
			"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
			"Opera/9.20 (Windows NT 6.0; U; en)",
			"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50",
			"Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]",
			"Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9",
			"Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48"
		);
		$random = rand(0, count($userAgents) - 1);
		return $userAgents[$random];
	}

	/**
	 * get contents from a url
	 */
	function get_url_content($url, $cntx = false) : array
	{
		$cookiesIn = '';
		$userAgent = $this->getRandomUserAgent(); //'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36';
		//CURLOPT_USERAGENT
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => true,     //return headers in addition to content
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_USERAGENT =>  $userAgent,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 300,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLINFO_HEADER_OUT    => true,
			// CURLOPT_SSL_VERIFYPEER => true,     // Validate SSL Cert
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYHOST => FALSE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_COOKIE         => $cookiesIn
		);
		$ch      = curl_init($url);
		curl_setopt_array($ch, $options);
		$rough_content = curl_exec($ch);
		$err     = curl_errno($ch);
		$errmsg  = curl_error($ch);
		$header  = curl_getinfo($ch);
		curl_close($ch);
		$header_content = substr($rough_content, 0, $header['header_size']);
		$body_content = trim(str_replace($header_content, '', $rough_content));
		$pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m";
		preg_match_all($pattern, $header_content, $matches);
		$cookiesOut = implode("; ", $matches['cookie']);
		$header['url']   = $url;
		$header['error_code']   = $err;
		$header['error_message']  = $errmsg;
		$header['headers']  = $header_content;
		$header['content'] = $body_content;
		$header['cookies'] = $cookiesOut;
		return $header;
	}


	/**
	 * Return the body content of an input html
	 */
	function returnHtml(string $html)
	{
		$resultPos = strpos($html, '<body');
		$resultPos2 = strpos($html, '</body');
		$contentBody = substr($html, $resultPos, ($resultPos2 - $resultPos));
		$contentBody = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $contentBody);
		$contentBody = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $contentBody);
		$contentBody = "<!doctype html> <html>" . $contentBody . '</html>';
		return $contentBody;
	}

	
	// get client ip address
	function getClientIp()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP')) {
			$ipaddress = getenv('HTTP_CLIENT_IP');
		} else if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		} else if (getenv('HTTP_X_FORWARDED')) {
			$ipaddress = getenv('HTTP_X_FORWARDED');
		} else if (getenv('HTTP_FORWARDED_FOR')) {
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		} else if (getenv('HTTP_FORWARDED')) {
			$ipaddress = getenv('HTTP_FORWARDED');
		} else if (getenv('REMOTE_ADDR')) {
			$ipaddress = getenv('REMOTE_ADDR');
		} else {
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}

	/** 
	 * get user browser info
	 * */ 
	function userBrowser() : array
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$ub = 'unknown';
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version = "";
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
		// Next get the name of the useragent yes seperately and for good reason
		if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} elseif (preg_match('/Firefox/i', $u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} elseif (preg_match('/OPR/i', $u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		} elseif (preg_match('/Chrome/i', $u_agent)) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} elseif (preg_match('/Safari/i', $u_agent)) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} elseif (preg_match('/Netscape/i', $u_agent)) {
			$bname = 'Netscape';
			$ub = "Netscape";
		}
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9\.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
				$version = @$matches['version'][0];
			} else {
				$version = @$matches['version'][1];
			}
		} else {
			$version = @$matches['version'][0];
		}
		// check if we have a number
		if ($version == null || $version == "") {
			$version = "?";
		}
		return array(
			'userAgent' => $u_agent,
			'name' => $bname,
			'version' => $version,
			'platform' => $platform,
			'pattern' => $pattern
		);
	}
	// get support browser

	/**
	 * Create a directory including sub directories
	 */
	static function createDir(string $folder) : string
	{
		$folderX = rtrim($folder, '/');
		$folderX .=  '/';
		if (!is_dir($folderX)) {
			mkdir($folderX, 0755, true);
		}
		return $folderX;
	}


	/**
	 * READ CSV FILE AND RETURN ARRAY
	 */
	public function readCsv(string $file) : ARRAY
	{
		/* Map Rows and Loop Through Them */
		$rows   = array_map('str_getcsv', file($file));
		$header = array_shift($rows);
		$fileObj = fopen($file, 'r');
		$csv = [];
		while (($line = fgetcsv($fileObj)) !== FALSE) {
			//$line is an array of the csv elements
			$csv[] = array_combine($header, $line);
		}
		array_shift($csv);
		fclose($fileObj);

		return $csv;
	}

	/**
	 * Remove get options used in pagination
	 */
	static function removeGetOptions(string $url, string $key)
	{

		$url = rtrim($url, '?');
		$url = rtrim($url, '&');
		$urlOrg = $url; // ?: $this->URL_IN_VIEW;

		$urlExp = explode($key . '=', $url);
		if (count($urlExp) > 1) {
			$urlExp2 = explode('&', $urlExp[1]);
			if (count($urlExp2) > 1) {
				array_shift($urlExp2);
				$url = $urlExp[0] . join('&', $urlExp2);
			} else {
				$url = $urlExp[0];
				if (strpos($urlOrg, '?' . $key . '=')) {
					$url = str_replace('?', '', $url);
				}
			}
		}
		$apperand = '?';
		if (strpos($url, '?')) {
			$apperand = '&';
		}
		$url = rtrim($url, '&');
		$url .= $apperand;
		return $url;
	}

	/**
	 * Do pagination
	 */
	public function paginate($count = 0, $rows = 10, $page = 0, $func = '') : string // func replace href with custom js function
	{

		$paginationLinks = '';
		if ($count > 0) {
			$pageRows = $rows;
			$totalPages = ceil($count / $pageRows);

			$limit = '';
			$pageNumber = 0;
			if ($totalPages > 0) {
				$pageNumber = 1;
				if ($page > 0) {
					$pageNumber = $page;
				} elseif (isset($_GET['pn']) && !empty($_GET['pn'])) {
					$pageNumber = preg_replace('#[^0-9]#i', '', $_GET['pn']);
				}

				if ($pageNumber < 1) {
					$pageNumber = 1;
				} elseif ($pageNumber > $totalPages) {
					$pageNumber = $totalPages;
				}

				$this->sqlLimit = ' LIMIT ' . ($pageNumber - 1) * $pageRows . ', ' . $pageRows;
			}



			$url = $this::removeGetOptions($this->URL_IN_VIEW, 'pn');



			// calculate and create pagination
			$paginationLinks = '';

			if ($pageNumber > 0) {
				if ($pageNumber > 1) {
					$previous = $pageNumber - 1;
					$linkAction = '';
					if (empty($func)) {
						$linkAction =  'href="' . $url . 'pn=' . $previous . '"';
					} else {
						$linkAction =  ' onclick="' . $func . '(' . $previous . ')" ';
					}
					$paginationLinks = '<li class="page-item"><a class="page-link" ' . $linkAction . '>&laquo;</a></li>';

					for ($i = $pageNumber - 4; $i < $pageNumber; $i++) {
						if ($i > 0) {
							$linkAction = '';
							if (empty($func)) {
								$linkAction =  'href="' . $url . 'pn=' . $i . '"';
							} else {
								$linkAction =  ' onclick="' . $func . '(' . $i . ')" ';
							}
							$paginationLinks .= '<li class="page-item"><a class="page-link" ' . $linkAction . '> ' . $i . ' </a></li>';
						}
					}
				}
				$paginationLinks .= '<li class="page-item active"><a  class="page-link disabled" href="#!"> ' . $pageNumber . ' </a></li>';


				for ($i = $pageNumber + 1; $i <= $totalPages; $i++) {
					$linkAction = '';
					if (empty($func)) {
						$linkAction =  'href="' . $url . 'pn=' . $i . '"';
					} else {
						$linkAction =  ' onclick="' . $func . '(' . $i . ')" ';
					}
					$paginationLinks .= '<li class="page-item"><a class="page-link" ' . $linkAction . '> ' . $i . ' </a></li>';
					if ($i >= $pageNumber + 4) {
						break;
					}
				}

				if ($pageNumber != $totalPages) {
					$next = $pageNumber + 1;
					$linkAction = '';
					if (empty($func)) {
						$linkAction =  'href="' . $url . 'pn=' . $next . '"';
					} else {
						$linkAction =  ' onclick="' . $func . '(' . $next . ')" ';
					}

					$paginationLinks .= '<li class="page-item"><a class="page-link" ' . $linkAction . '>&raquo;</a></li>';
				}
				$paginationLinks = '
		      <nav aria-label="Page navigation example">
				<ul class="pagination justify-content-end my-1">
		      		' . $paginationLinks . '
		      	</ul>
		      </nav>
          ';
			}
			// calculate and create pagination


		}
		return $paginationLinks;
	}




	// generate random key
	static function randKey($length, $type = '')
	{
		$char = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
		if (strtolower($type) == "numeric") {
			$char = array_merge(range(0, 9));
		} elseif (strtolower($type) == "alphabet") {
			$char = array_merge(range('a', 'z'), range('A', 'Z'));
		}
		$val = '';
		for ($i = 0; $i < $length; $i++) {
			$val .= $char[mt_rand(0, count($char) - 1)];
		}
		return $val;
	}
	// end randon number alphabet



	// declare main object
	public $currencyCodes =  array(
		'AF' => 'AFN',
		'AL' => 'ALL',
		'DZ' => 'DZD',
		'AS' => 'USD',
		'AD' => 'EUR',
		'AO' => 'AOA',
		'AI' => 'XCD',
		'AQ' => 'XCD',
		'AG' => 'XCD',
		'AR' => 'ARS',
		'AM' => 'AMD',
		'AW' => 'AWG',
		'AU' => 'AUD',
		'AT' => 'EUR',
		'AZ' => 'AZN',
		'BS' => 'BSD',
		'BH' => 'BHD',
		'BD' => 'BDT',
		'BB' => 'BBD',
		'BY' => 'BYR',
		'BE' => 'EUR',
		'BZ' => 'BZD',
		'BJ' => 'XOF',
		'BM' => 'BMD',
		'BT' => 'BTN',
		'BO' => 'BOB',
		'BA' => 'BAM',
		'BW' => 'BWP',
		'BV' => 'NOK',
		'BR' => 'BRL',
		'IO' => 'USD',
		'BN' => 'BND',
		'BG' => 'BGN',
		'BF' => 'XOF',
		'BI' => 'BIF',
		'KH' => 'KHR',
		'CM' => 'XAF',
		'CA' => 'CAD',
		'CV' => 'CVE',
		'KY' => 'KYD',
		'CF' => 'XAF',
		'TD' => 'XAF',
		'CL' => 'CLP',
		'CN' => 'CNY',
		'HK' => 'HKD',
		'CX' => 'AUD',
		'CC' => 'AUD',
		'CO' => 'COP',
		'KM' => 'KMF',
		'CG' => 'XAF',
		'CD' => 'CDF',
		'CK' => 'NZD',
		'CR' => 'CRC',
		'HR' => 'HRK',
		'CU' => 'CUP',
		'CY' => 'EUR',
		'CZ' => 'CZK',
		'DK' => 'DKK',
		'DJ' => 'DJF',
		'DM' => 'XCD',
		'DO' => 'DOP',
		'EC' => 'ECS',
		'EG' => 'EGP',
		'SV' => 'SVC',
		'GQ' => 'XAF',
		'ER' => 'ERN',
		'EE' => 'EUR',
		'ET' => 'ETB',
		'FK' => 'FKP',
		'FO' => 'DKK',
		'FJ' => 'FJD',
		'FI' => 'EUR',
		'FR' => 'EUR',
		'GF' => 'EUR',
		'TF' => 'EUR',
		'GA' => 'XAF',
		'GM' => 'GMD',
		'GE' => 'GEL',
		'DE' => 'EUR',
		'GH' => 'GHS',
		'GI' => 'GIP',
		'GR' => 'EUR',
		'GL' => 'DKK',
		'GD' => 'XCD',
		'GP' => 'EUR',
		'GU' => 'USD',
		'GT' => 'QTQ',
		'GG' => 'GGP',
		'GN' => 'GNF',
		'GW' => 'GWP',
		'GY' => 'GYD',
		'HT' => 'HTG',
		'HM' => 'AUD',
		'HN' => 'HNL',
		'HU' => 'HUF',
		'IS' => 'ISK',
		'IN' => 'INR',
		'ID' => 'IDR',
		'IR' => 'IRR',
		'IQ' => 'IQD',
		'IE' => 'EUR',
		'IM' => 'GBP',
		'IL' => 'ILS',
		'IT' => 'EUR',
		'JM' => 'JMD',
		'JP' => 'JPY',
		'JE' => 'GBP',
		'JO' => 'JOD',
		'KZ' => 'KZT',
		'KE' => 'KES',
		'KI' => 'AUD',
		'KP' => 'KPW',
		'KR' => 'KRW',
		'KW' => 'KWD',
		'KG' => 'KGS',
		'LA' => 'LAK',
		'LV' => 'EUR',
		'LB' => 'LBP',
		'LS' => 'LSL',
		'LR' => 'LRD',
		'LY' => 'LYD',
		'LI' => 'CHF',
		'LT' => 'EUR',
		'LU' => 'EUR',
		'MK' => 'MKD',
		'MG' => 'MGF',
		'MW' => 'MWK',
		'MY' => 'MYR',
		'MV' => 'MVR',
		'ML' => 'XOF',
		'MT' => 'EUR',
		'MH' => 'USD',
		'MQ' => 'EUR',
		'MR' => 'MRO',
		'MU' => 'MUR',
		'YT' => 'EUR',
		'MX' => 'MXN',
		'FM' => 'USD',
		'MD' => 'MDL',
		'MC' => 'EUR',
		'MN' => 'MNT',
		'ME' => 'EUR',
		'MS' => 'XCD',
		'MA' => 'MAD',
		'MZ' => 'MZN',
		'MM' => 'MMK',
		'NA' => 'NAD',
		'NR' => 'AUD',
		'NP' => 'NPR',
		'NL' => 'EUR',
		'AN' => 'ANG',
		'NC' => 'XPF',
		'NZ' => 'NZD',
		'NI' => 'NIO',
		'NE' => 'XOF',
		'NG' => 'NGN',
		'NU' => 'NZD',
		'NF' => 'AUD',
		'MP' => 'USD',
		'NO' => 'NOK',
		'OM' => 'OMR',
		'PK' => 'PKR',
		'PW' => 'USD',
		'PA' => 'PAB',
		'PG' => 'PGK',
		'PY' => 'PYG',
		'PE' => 'PEN',
		'PH' => 'PHP',
		'PN' => 'NZD',
		'PL' => 'PLN',
		'PT' => 'EUR',
		'PR' => 'USD',
		'QA' => 'QAR',
		'RE' => 'EUR',
		'RO' => 'RON',
		'RU' => 'RUB',
		'RW' => 'RWF',
		'SH' => 'SHP',
		'KN' => 'XCD',
		'LC' => 'XCD',
		'PM' => 'EUR',
		'VC' => 'XCD',
		'WS' => 'WST',
		'SM' => 'EUR',
		'ST' => 'STD',
		'SA' => 'SAR',
		'SN' => 'XOF',
		'RS' => 'RSD',
		'SC' => 'SCR',
		'SL' => 'SLL',
		'SG' => 'SGD',
		'SK' => 'EUR',
		'SI' => 'EUR',
		'SB' => 'SBD',
		'SO' => 'SOS',
		'ZA' => 'ZAR',
		'GS' => 'GBP',
		'SS' => 'SSP',
		'ES' => 'EUR',
		'LK' => 'LKR',
		'SD' => 'SDG',
		'SR' => 'SRD',
		'SJ' => 'NOK',
		'SZ' => 'SZL',
		'SE' => 'SEK',
		'CH' => 'CHF',
		'SY' => 'SYP',
		'TW' => 'TWD',
		'TJ' => 'TJS',
		'TZ' => 'TZS',
		'TH' => 'THB',
		'TG' => 'XOF',
		'TK' => 'NZD',
		'TO' => 'TOP',
		'TT' => 'TTD',
		'TN' => 'TND',
		'TR' => 'TRY',
		'TM' => 'TMT',
		'TC' => 'USD',
		'TV' => 'AUD',
		'UG' => 'UGX',
		'UA' => 'UAH',
		'AE' => 'AED',
		'GB' => 'GBP',
		'US' => 'USD',
		'UM' => 'USD',
		'UY' => 'UYU',
		'UZ' => 'UZS',
		'VU' => 'VUV',
		'VE' => 'VEF',
		'VN' => 'VND',
		'VI' => 'USD',
		'WF' => 'XPF',
		'EH' => 'MAD',
		'YE' => 'YER',
		'ZM' => 'ZMW',
		'ZW' => 'ZWD',
	);

	public $currencySymbols = array(
		'AED' => '&#1583;.&#1573;', // ?
		'AFN' => '&#65;&#102;',
		'ALL' => '&#76;&#101;&#107;',
		'AMD' => '',
		'ANG' => '&#402;',
		'AOA' => '&#75;&#122;', // ?
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => '&#402;',
		'AZN' => '&#1084;&#1072;&#1085;',
		'BAM' => '&#75;&#77;',
		'BBD' => '&#36;',
		'BDT' => '&#2547;', // ?
		'BGN' => '&#1083;&#1074;',
		'BHD' => '.&#1583;.&#1576;', // ?
		'BIF' => '&#70;&#66;&#117;', // ?
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => '&#36;&#98;',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTN' => '&#78;&#117;&#46;', // ?
		'BWP' => '&#80;',
		'BYR' => '&#112;&#46;',
		'BZD' => '&#66;&#90;&#36;',
		'CAD' => '&#36;',
		'CDF' => '&#70;&#67;',
		'CHF' => '&#67;&#72;&#70;',
		'CLF' => '', // ?
		'CLP' => '&#36;',
		'CNY' => '&#165;',
		'COP' => '&#36;',
		'CRC' => '&#8353;',
		'CUP' => '&#8396;',
		'CVE' => '&#36;', // ?
		'CZK' => '&#75;&#269;',
		'DJF' => '&#70;&#100;&#106;', // ?
		'DKK' => '&#107;&#114;',
		'DOP' => '&#82;&#68;&#36;',
		'DZD' => '&#1583;&#1580;', // ?
		'EGP' => '&#163;',
		'ETB' => '&#66;&#114;',
		'EUR' => '&#8364;',
		'FJD' => '&#36;',
		'FKP' => '&#163;',
		'GBP' => '&#163;',
		'GEL' => '&#4314;', // ?
		'GHS' => '&#162;',
		'GIP' => '&#163;',
		'GMD' => '&#68;', // ?
		'GNF' => '&#70;&#71;', // ?
		'GTQ' => '&#81;',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => '&#76;',
		'HRK' => '&#107;&#110;',
		'HTG' => '&#71;', // ?
		'HUF' => '&#70;&#116;',
		'IDR' => '&#82;&#112;',
		'ILS' => '&#8362;',
		'INR' => '&#8377;',
		'IQD' => '&#1593;.&#1583;', // ?
		'IRR' => '&#65020;',
		'ISK' => '&#107;&#114;',
		'JEP' => '&#163;',
		'JMD' => '&#74;&#36;',
		'JOD' => '&#74;&#68;', // ?
		'JPY' => '&#165;',
		'KES' => '&#75;&#83;&#104;', // ?
		'KGS' => '&#1083;&#1074;',
		'KHR' => '&#6107;',
		'KMF' => '&#67;&#70;', // ?
		'KPW' => '&#8361;',
		'KRW' => '&#8361;',
		'KWD' => '&#1583;.&#1603;', // ?
		'KYD' => '&#36;',
		'KZT' => '&#1083;&#1074;',
		'LAK' => '&#8365;',
		'LBP' => '&#163;',
		'LKR' => '&#8360;',
		'LRD' => '&#36;',
		'LSL' => '&#76;', // ?
		'LTL' => '&#76;&#116;',
		'LVL' => '&#76;&#115;',
		'LYD' => '&#1604;.&#1583;', // ?
		'MAD' => '&#1583;.&#1605;.', //?
		'MDL' => '&#76;',
		'MGA' => '&#65;&#114;', // ?
		'MKD' => '&#1076;&#1077;&#1085;',
		'MMK' => '&#75;',
		'MNT' => '&#8366;',
		'MOP' => '&#77;&#79;&#80;&#36;', // ?
		'MRO' => '&#85;&#77;', // ?
		'MUR' => '&#8360;', // ?
		'MVR' => '.&#1923;', // ?
		'MWK' => '&#77;&#75;',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => '&#77;&#84;',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => '&#67;&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#65020;',
		'PAB' => '&#66;&#47;&#46;',
		'PEN' => '&#83;&#47;&#46;',
		'PGK' => '&#75;', // ?
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PYG' => '&#71;&#115;',
		'QAR' => '&#65020;',
		'RON' => '&#108;&#101;&#105;',
		'RSD' => '&#1044;&#1080;&#1085;&#46;',
		'RUB' => '&#1088;&#1091;&#1073;',
		'RWF' => '&#1585;.&#1587;',
		'SAR' => '&#65020;',
		'SBD' => '&#36;',
		'SCR' => '&#8360;',
		'SDG' => '&#163;', // ?
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&#163;',
		'SLL' => '&#76;&#101;', // ?
		'SOS' => '&#83;',
		'SRD' => '&#36;',
		'STD' => '&#68;&#98;', // ?
		'SVC' => '&#36;',
		'SYP' => '&#163;',
		'SZL' => '&#76;', // ?
		'THB' => '&#3647;',
		'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
		'TMT' => '&#109;',
		'TND' => '&#1583;.&#1578;',
		'TOP' => '&#84;&#36;',
		'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => '',
		'UAH' => '&#8372;',
		'UGX' => '&#85;&#83;&#104;',
		'USD' => '&#36;',
		'UYU' => '&#36;&#85;',
		'UZS' => '&#1083;&#1074;',
		'VEF' => '&#66;&#115;',
		'VND' => '&#8363;',
		'VUV' => '&#86;&#84;',
		'WST' => '&#87;&#83;&#36;',
		'XAF' => '&#88;&#65;&#70;',
		'XCD' => '&#36;',
		'XDR' => '',
		'XOF' => '',
		'XPF' => '&#70;',
		'YER' => '&#65020;',
		'ZAR' => '&#82;',
		'ZMK' => '&#90;&#75;', // ?
		'ZWL' => '&#90;&#36;',
	);

	public $countryArray = array(
		'AD' => array('name' => 'ANDORRA', 'code' => '376'),
		'AE' => array('name' => 'UNITED ARAB EMIRATES', 'code' => '971'),
		'AF' => array('name' => 'AFGHANISTAN', 'code' => '93'),
		'AG' => array('name' => 'ANTIGUA AND BARBUDA', 'code' => '1268'),
		'AI' => array('name' => 'ANGUILLA', 'code' => '1264'),
		'AL' => array('name' => 'ALBANIA', 'code' => '355'),
		'AM' => array('name' => 'ARMENIA', 'code' => '374'),
		'AN' => array('name' => 'NETHERLANDS ANTILLES', 'code' => '599'),
		'AO' => array('name' => 'ANGOLA', 'code' => '244'),
		'AQ' => array('name' => 'ANTARCTICA', 'code' => '672'),
		'AR' => array('name' => 'ARGENTINA', 'code' => '54'),
		'AS' => array('name' => 'AMERICAN SAMOA', 'code' => '1684'),
		'AT' => array('name' => 'AUSTRIA', 'code' => '43'),
		'AU' => array('name' => 'AUSTRALIA', 'code' => '61'),
		'AW' => array('name' => 'ARUBA', 'code' => '297'),
		'AZ' => array('name' => 'AZERBAIJAN', 'code' => '994'),
		'BA' => array('name' => 'BOSNIA AND HERZEGOVINA', 'code' => '387'),
		'BB' => array('name' => 'BARBADOS', 'code' => '1246'),
		'BD' => array('name' => 'BANGLADESH', 'code' => '880'),
		'BE' => array('name' => 'BELGIUM', 'code' => '32'),
		'BF' => array('name' => 'BURKINA FASO', 'code' => '226'),
		'BG' => array('name' => 'BULGARIA', 'code' => '359'),
		'BH' => array('name' => 'BAHRAIN', 'code' => '973'),
		'BI' => array('name' => 'BURUNDI', 'code' => '257'),
		'BJ' => array('name' => 'BENIN', 'code' => '229'),
		'BL' => array('name' => 'SAINT BARTHELEMY', 'code' => '590'),
		'BM' => array('name' => 'BERMUDA', 'code' => '1441'),
		'BN' => array('name' => 'BRUNEI DARUSSALAM', 'code' => '673'),
		'BO' => array('name' => 'BOLIVIA', 'code' => '591'),
		'BR' => array('name' => 'BRAZIL', 'code' => '55'),
		'BS' => array('name' => 'BAHAMAS', 'code' => '1242'),
		'BT' => array('name' => 'BHUTAN', 'code' => '975'),
		'BW' => array('name' => 'BOTSWANA', 'code' => '267'),
		'BY' => array('name' => 'BELARUS', 'code' => '375'),
		'BZ' => array('name' => 'BELIZE', 'code' => '501'),
		'CA' => array('name' => 'CANADA', 'code' => '1'),
		'CC' => array('name' => 'COCOS (KEELING) ISLANDS', 'code' => '61'),
		'CD' => array('name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'code' => '243'),
		'CF' => array('name' => 'CENTRAL AFRICAN REPUBLIC', 'code' => '236'),
		'CG' => array('name' => 'CONGO', 'code' => '242'),
		'CH' => array('name' => 'SWITZERLAND', 'code' => '41'),
		'CI' => array('name' => 'COTE D IVOIRE', 'code' => '225'),
		'CK' => array('name' => 'COOK ISLANDS', 'code' => '682'),
		'CL' => array('name' => 'CHILE', 'code' => '56'),
		'CM' => array('name' => 'CAMEROON', 'code' => '237'),
		'CN' => array('name' => 'CHINA', 'code' => '86'),
		'CO' => array('name' => 'COLOMBIA', 'code' => '57'),
		'CR' => array('name' => 'COSTA RICA', 'code' => '506'),
		'CU' => array('name' => 'CUBA', 'code' => '53'),
		'CV' => array('name' => 'CAPE VERDE', 'code' => '238'),
		'CX' => array('name' => 'CHRISTMAS ISLAND', 'code' => '61'),
		'CY' => array('name' => 'CYPRUS', 'code' => '357'),
		'CZ' => array('name' => 'CZECH REPUBLIC', 'code' => '420'),
		'DE' => array('name' => 'GERMANY', 'code' => '49'),
		'DJ' => array('name' => 'DJIBOUTI', 'code' => '253'),
		'DK' => array('name' => 'DENMARK', 'code' => '45'),
		'DM' => array('name' => 'DOMINICA', 'code' => '1767'),
		'DO' => array('name' => 'DOMINICAN REPUBLIC', 'code' => '1809'),
		'DZ' => array('name' => 'ALGERIA', 'code' => '213'),
		'EC' => array('name' => 'ECUADOR', 'code' => '593'),
		'EE' => array('name' => 'ESTONIA', 'code' => '372'),
		'EG' => array('name' => 'EGYPT', 'code' => '20'),
		'ER' => array('name' => 'ERITREA', 'code' => '291'),
		'ES' => array('name' => 'SPAIN', 'code' => '34'),
		'ET' => array('name' => 'ETHIOPIA', 'code' => '251'),
		'FI' => array('name' => 'FINLAND', 'code' => '358'),
		'FJ' => array('name' => 'FIJI', 'code' => '679'),
		'FK' => array('name' => 'FALKLAND ISLANDS (MALVINAS)', 'code' => '500'),
		'FM' => array('name' => 'MICRONESIA, FEDERATED STATES OF', 'code' => '691'),
		'FO' => array('name' => 'FAROE ISLANDS', 'code' => '298'),
		'FR' => array('name' => 'FRANCE', 'code' => '33'),
		'GA' => array('name' => 'GABON', 'code' => '241'),
		'GB' => array('name' => 'UNITED KINGDOM', 'code' => '44'),
		'GD' => array('name' => 'GRENADA', 'code' => '1473'),
		'GE' => array('name' => 'GEORGIA', 'code' => '995'),
		'GH' => array('name' => 'GHANA', 'code' => '233'),
		'GI' => array('name' => 'GIBRALTAR', 'code' => '350'),
		'GL' => array('name' => 'GREENLAND', 'code' => '299'),
		'GM' => array('name' => 'GAMBIA', 'code' => '220'),
		'GN' => array('name' => 'GUINEA', 'code' => '224'),
		'GQ' => array('name' => 'EQUATORIAL GUINEA', 'code' => '240'),
		'GR' => array('name' => 'GREECE', 'code' => '30'),
		'GT' => array('name' => 'GUATEMALA', 'code' => '502'),
		'GU' => array('name' => 'GUAM', 'code' => '1671'),
		'GW' => array('name' => 'GUINEA-BISSAU', 'code' => '245'),
		'GY' => array('name' => 'GUYANA', 'code' => '592'),
		'HK' => array('name' => 'HONG KONG', 'code' => '852'),
		'HN' => array('name' => 'HONDURAS', 'code' => '504'),
		'HR' => array('name' => 'CROATIA', 'code' => '385'),
		'HT' => array('name' => 'HAITI', 'code' => '509'),
		'HU' => array('name' => 'HUNGARY', 'code' => '36'),
		'ID' => array('name' => 'INDONESIA', 'code' => '62'),
		'IE' => array('name' => 'IRELAND', 'code' => '353'),
		'IL' => array('name' => 'ISRAEL', 'code' => '972'),
		'IM' => array('name' => 'ISLE OF MAN', 'code' => '44'),
		'IN' => array('name' => 'INDIA', 'code' => '91'),
		'IQ' => array('name' => 'IRAQ', 'code' => '964'),
		'IR' => array('name' => 'IRAN, ISLAMIC REPUBLIC OF', 'code' => '98'),
		'IS' => array('name' => 'ICELAND', 'code' => '354'),
		'IT' => array('name' => 'ITALY', 'code' => '39'),
		'JM' => array('name' => 'JAMAICA', 'code' => '1876'),
		'JO' => array('name' => 'JORDAN', 'code' => '962'),
		'JP' => array('name' => 'JAPAN', 'code' => '81'),
		'KE' => array('name' => 'KENYA', 'code' => '254'),
		'KG' => array('name' => 'KYRGYZSTAN', 'code' => '996'),
		'KH' => array('name' => 'CAMBODIA', 'code' => '855'),
		'KI' => array('name' => 'KIRIBATI', 'code' => '686'),
		'KM' => array('name' => 'COMOROS', 'code' => '269'),
		'KN' => array('name' => 'SAINT KITTS AND NEVIS', 'code' => '1869'),
		'KP' => array('name' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF', 'code' => '850'),
		'KR' => array('name' => 'KOREA REPUBLIC OF', 'code' => '82'),
		'KW' => array('name' => 'KUWAIT', 'code' => '965'),
		'KY' => array('name' => 'CAYMAN ISLANDS', 'code' => '1345'),
		'KZ' => array('name' => 'KAZAKSTAN', 'code' => '7'),
		'LA' => array('name' => 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'code' => '856'),
		'LB' => array('name' => 'LEBANON', 'code' => '961'),
		'LC' => array('name' => 'SAINT LUCIA', 'code' => '1758'),
		'LI' => array('name' => 'LIECHTENSTEIN', 'code' => '423'),
		'LK' => array('name' => 'SRI LANKA', 'code' => '94'),
		'LR' => array('name' => 'LIBERIA', 'code' => '231'),
		'LS' => array('name' => 'LESOTHO', 'code' => '266'),
		'LT' => array('name' => 'LITHUANIA', 'code' => '370'),
		'LU' => array('name' => 'LUXEMBOURG', 'code' => '352'),
		'LV' => array('name' => 'LATVIA', 'code' => '371'),
		'LY' => array('name' => 'LIBYAN ARAB JAMAHIRIYA', 'code' => '218'),
		'MA' => array('name' => 'MOROCCO', 'code' => '212'),
		'MC' => array('name' => 'MONACO', 'code' => '377'),
		'MD' => array('name' => 'MOLDOVA, REPUBLIC OF', 'code' => '373'),
		'ME' => array('name' => 'MONTENEGRO', 'code' => '382'),
		'MF' => array('name' => 'SAINT MARTIN', 'code' => '1599'),
		'MG' => array('name' => 'MADAGASCAR', 'code' => '261'),
		'MH' => array('name' => 'MARSHALL ISLANDS', 'code' => '692'),
		'MK' => array('name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'code' => '389'),
		'ML' => array('name' => 'MALI', 'code' => '223'),
		'MM' => array('name' => 'MYANMAR', 'code' => '95'),
		'MN' => array('name' => 'MONGOLIA', 'code' => '976'),
		'MO' => array('name' => 'MACAU', 'code' => '853'),
		'MP' => array('name' => 'NORTHERN MARIANA ISLANDS', 'code' => '1670'),
		'MR' => array('name' => 'MAURITANIA', 'code' => '222'),
		'MS' => array('name' => 'MONTSERRAT', 'code' => '1664'),
		'MT' => array('name' => 'MALTA', 'code' => '356'),
		'MU' => array('name' => 'MAURITIUS', 'code' => '230'),
		'MV' => array('name' => 'MALDIVES', 'code' => '960'),
		'MW' => array('name' => 'MALAWI', 'code' => '265'),
		'MX' => array('name' => 'MEXICO', 'code' => '52'),
		'MY' => array('name' => 'MALAYSIA', 'code' => '60'),
		'MZ' => array('name' => 'MOZAMBIQUE', 'code' => '258'),
		'NA' => array('name' => 'NAMIBIA', 'code' => '264'),
		'NC' => array('name' => 'NEW CALEDONIA', 'code' => '687'),
		'NE' => array('name' => 'NIGER', 'code' => '227'),
		'NG' => array('name' => 'NIGERIA', 'code' => '234'),
		'NI' => array('name' => 'NICARAGUA', 'code' => '505'),
		'NL' => array('name' => 'NETHERLANDS', 'code' => '31'),
		'NO' => array('name' => 'NORWAY', 'code' => '47'),
		'NP' => array('name' => 'NEPAL', 'code' => '977'),
		'NR' => array('name' => 'NAURU', 'code' => '674'),
		'NU' => array('name' => 'NIUE', 'code' => '683'),
		'NZ' => array('name' => 'NEW ZEALAND', 'code' => '64'),
		'OM' => array('name' => 'OMAN', 'code' => '968'),
		'PA' => array('name' => 'PANAMA', 'code' => '507'),
		'PE' => array('name' => 'PERU', 'code' => '51'),
		'PF' => array('name' => 'FRENCH POLYNESIA', 'code' => '689'),
		'PG' => array('name' => 'PAPUA NEW GUINEA', 'code' => '675'),
		'PH' => array('name' => 'PHILIPPINES', 'code' => '63'),
		'PK' => array('name' => 'PAKISTAN', 'code' => '92'),
		'PL' => array('name' => 'POLAND', 'code' => '48'),
		'PM' => array('name' => 'SAINT PIERRE AND MIQUELON', 'code' => '508'),
		'PN' => array('name' => 'PITCAIRN', 'code' => '870'),
		'PR' => array('name' => 'PUERTO RICO', 'code' => '1'),
		'PT' => array('name' => 'PORTUGAL', 'code' => '351'),
		'PW' => array('name' => 'PALAU', 'code' => '680'),
		'PY' => array('name' => 'PARAGUAY', 'code' => '595'),
		'QA' => array('name' => 'QATAR', 'code' => '974'),
		'RO' => array('name' => 'ROMANIA', 'code' => '40'),
		'RS' => array('name' => 'SERBIA', 'code' => '381'),
		'RU' => array('name' => 'RUSSIAN FEDERATION', 'code' => '7'),
		'RW' => array('name' => 'RWANDA', 'code' => '250'),
		'SA' => array('name' => 'SAUDI ARABIA', 'code' => '966'),
		'SB' => array('name' => 'SOLOMON ISLANDS', 'code' => '677'),
		'SC' => array('name' => 'SEYCHELLES', 'code' => '248'),
		'SD' => array('name' => 'SUDAN', 'code' => '249'),
		'SE' => array('name' => 'SWEDEN', 'code' => '46'),
		'SG' => array('name' => 'SINGAPORE', 'code' => '65'),
		'SH' => array('name' => 'SAINT HELENA', 'code' => '290'),
		'SI' => array('name' => 'SLOVENIA', 'code' => '386'),
		'SK' => array('name' => 'SLOVAKIA', 'code' => '421'),
		'SL' => array('name' => 'SIERRA LEONE', 'code' => '232'),
		'SM' => array('name' => 'SAN MARINO', 'code' => '378'),
		'SN' => array('name' => 'SENEGAL', 'code' => '221'),
		'SO' => array('name' => 'SOMALIA', 'code' => '252'),
		'SR' => array('name' => 'SURINAME', 'code' => '597'),
		'ST' => array('name' => 'SAO TOME AND PRINCIPE', 'code' => '239'),
		'SV' => array('name' => 'EL SALVADOR', 'code' => '503'),
		'SY' => array('name' => 'SYRIAN ARAB REPUBLIC', 'code' => '963'),
		'SZ' => array('name' => 'SWAZILAND', 'code' => '268'),
		'TC' => array('name' => 'TURKS AND CAICOS ISLANDS', 'code' => '1649'),
		'TD' => array('name' => 'CHAD', 'code' => '235'),
		'TG' => array('name' => 'TOGO', 'code' => '228'),
		'TH' => array('name' => 'THAILAND', 'code' => '66'),
		'TJ' => array('name' => 'TAJIKISTAN', 'code' => '992'),
		'TK' => array('name' => 'TOKELAU', 'code' => '690'),
		'TL' => array('name' => 'TIMOR-LESTE', 'code' => '670'),
		'TM' => array('name' => 'TURKMENISTAN', 'code' => '993'),
		'TN' => array('name' => 'TUNISIA', 'code' => '216'),
		'TO' => array('name' => 'TONGA', 'code' => '676'),
		'TR' => array('name' => 'TURKEY', 'code' => '90'),
		'TT' => array('name' => 'TRINIDAD AND TOBAGO', 'code' => '1868'),
		'TV' => array('name' => 'TUVALU', 'code' => '688'),
		'TW' => array('name' => 'TAIWAN, PROVINCE OF CHINA', 'code' => '886'),
		'TZ' => array('name' => 'TANZANIA, UNITED REPUBLIC OF', 'code' => '255'),
		'UA' => array('name' => 'UKRAINE', 'code' => '380'),
		'UG' => array('name' => 'UGANDA', 'code' => '256'),
		'US' => array('name' => 'UNITED STATES', 'code' => '1'),
		'UY' => array('name' => 'URUGUAY', 'code' => '598'),
		'UZ' => array('name' => 'UZBEKISTAN', 'code' => '998'),
		'VA' => array('name' => 'HOLY SEE (VATICAN CITY STATE)', 'code' => '39'),
		'VC' => array('name' => 'SAINT VINCENT AND THE GRENADINES', 'code' => '1784'),
		'VE' => array('name' => 'VENEZUELA', 'code' => '58'),
		'VG' => array('name' => 'VIRGIN ISLANDS, BRITISH', 'code' => '1284'),
		'VI' => array('name' => 'VIRGIN ISLANDS, U.S.', 'code' => '1340'),
		'VN' => array('name' => 'VIET NAM', 'code' => '84'),
		'VU' => array('name' => 'VANUATU', 'code' => '678'),
		'WF' => array('name' => 'WALLIS AND FUTUNA', 'code' => '681'),
		'WS' => array('name' => 'SAMOA', 'code' => '685'),
		'XK' => array('name' => 'KOSOVO', 'code' => '381'),
		'YE' => array('name' => 'YEMEN', 'code' => '967'),
		'YT' => array('name' => 'MAYOTTE', 'code' => '262'),
		'ZA' => array('name' => 'SOUTH AFRICA', 'code' => '27'),
		'ZM' => array('name' => 'ZAMBIA', 'code' => '260'),
		'ZW' => array('name' => 'ZIMBABWE', 'code' => '263')
	);
}

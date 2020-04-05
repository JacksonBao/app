<?php 


/**
 * 
 */
Trait View
{

    public $header;
    public $footer;

	public $urlNavigation = [
	"DEFAULT" => array(
        "HEADER" => array('public/views/components/navigations/online_header.php'), 
        "FOOTER" => array('public/views/components/navigations/online_footer.php')
        ),
    "ERROR" => array(
        "HEADER" => array('public/views/components/navigations/offline_header.php'), 
        "FOOTER" => array('public/views/components/navigations/offline_footer.php')
    	)
	];


	public function render($page = false, $status = 1, $inc = FALSE)
	{
		
		$file = DEFAULT_WALLET_PATH . 'public/views/pages/'.$this->directory.'/' . $page . '.php';
		if (!file_exists($file)) {
            // return 404
            $file = $this->errorPage();
        } 

        if ($status == FALSE) {// laod error header
            $headerArr = $this->urlNavigation['ERROR']['HEADER'];
            if (is_array($headerArr)) {
                foreach ($headerArr as $value)
                    $this->header .= $value;
            }
            $footerArr = $this->urlNavigation['ERROR']['FOOTER'];
            if (is_array($footerArr)) {
                foreach ($footerArr as $value)
                    $this->footer .= $value;
            }
        } elseif ($status == 1) { // load defalt header 
            $headerArr = $this->urlNavigation['DEFAULT']['HEADER'];
            if (is_array($headerArr)) {
                foreach ($headerArr as $value) {
                    $this->header .= $value;
                }
            }
            $footerArr = $this->urlNavigation['DEFAULT']['FOOTER'];
            if (is_array($footerArr)) {
                foreach ($footerArr as $value)
                    $this->footer .= $value;
            }
        } else {
            $this->header = '';
            $this->footer = '';
        }


        if ($inc !== FALSE) {
            $componentsArr = $this->urlNavigation[$inc];
            if (is_array($componentsArr)) {
                $this->inc_url_title = $inc;
                foreach ($componentsArr as $key => $value) {
                    if (str_replace('_HEADER', $inc)) {
                        $this->inc_urls_header .= DEFAULT_WALLET_PATH . $value;
                    } elseif (str_replace('_FOOTER', $inc)) {
                        $this->inc_urls_footer .= DEFAULT_WALLET_PATH . $value;
                    }
                }
            }
        }



        // check if the header and footer file exist
        if (file_exists(DEFAULT_WALLET_PATH . $this->header) && !empty($this->header)) {
          include_once DEFAULT_WALLET_PATH . $this->header;
        } else {
            echo "string File :: " . DEFAULT_WALLET_PATH . $this->header;;
        }



        // check if the header and footer file exist
        include_once $file;

        // check if footer exist and include
        if (file_exists(DEFAULT_WALLET_PATH . $this->footer) && !empty($this->footer)) {
            include_once DEFAULT_WALLET_PATH . $this->footer;
        }



	}

}
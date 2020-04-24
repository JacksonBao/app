<?php
namespace App\Market\Libraries;

/**
 *
 */



class Functions extends \App\Market\Config\AppAuthenticate
{
	use \App\Market\Traits\EmailTemplateTraits; use  \App\Market\Config\StringEncrypt,  \App\Market\Traits\Uploader, \App\Market\Traits\ValidateForm;
	  // use App\Market\Traits\;
	  // use App\Market\Traits\;

	function __construct()
	{
		parent::__construct();

	}

public function readCsv(string $file)
{
	/* Map Rows and Loop Through Them */
	$rows   = array_map('str_getcsv', file($file));
	$header = array_shift($rows);
	$csv    = array();
	foreach($rows as $row) {
			$csv[] = array_combine($header, $row);
	}
	return $csv;
}

public function sendSMS(string $phone, string $msg)
{
	$msg = substr($msg, 0, 160);

}

	function mysqli_real_escape_array(array $arr, $db = false ) {
      if ( ! $db ) {
          return false;
      }
      $array = array();
      foreach ( $arr as $k=>$v ) {
          if ( is_array( $v ) ) {
              $array[mysqli_real_escape_string( $db, $k )] = $this->mysqli_real_escape_array( $v, $db );
          } else {
              $array[mysqli_real_escape_string( $db, $k )] = mysqli_real_escape_string( $db, $v );
          }
      }
      return $arr;
  }



    public function paginate($count = 0, $rows = 10)
    {

      $paginationLinks = '';
      if($count > 0){
        $pageRows = $rows;
        $totalPages = ceil($count / $pageRows);

        $limit = '';$pageNumber = 0;
        if($totalPages > 0){
        $pageNumber = 1;
        if(isset($_GET['pn']) && !empty($_GET['pn'])){
          $pageNumber = preg_replace('#[^0-9]#i', '', $_GET['pn']);
        }

        if($pageNumber < 1){
          $pageNumber = 1;
        } elseif ($pageNumber > $totalPages) {
          $pageNumber = $totalPages;
        }

        $this->sqlLimit = ' LIMIT ' .($pageNumber - 1) * $pageRows.', '.$pageRows;
        }


				$url = $this->urlInView;
				$urlExp = explode('pn=', $url);
				if(count($urlExp) > 1) {
				$urlExp2 = explode('&', $urlExp[1]);
				if(count($urlExp2) > 1){
					array_shift($urlExp2);
					$url = $urlExp[0] . join('&', $urlExp2);
				} else {
						$url = $urlExp[0];
						if(strpos($this->urlInView, '?pn=')){
							$url = str_replace('?', '', $url);
						}
					}
				}

				$apperand = '?';
				if(strpos($url, '?')){
					$apperand = '&';
				}

        // calculate and create pagination
        $paginationLinks = '';

        if($pageNumber > 0){
        if($pageNumber > 1){
          $previous = $pageNumber - 1;
          $paginationLinks = '<li class="page-item"><a class="page-link" href="'.$url.$apperand.'pn='.$previous.'">&laquo;</a></li>';

          for ($i = $pageNumber - 4; $i < $pageNumber; $i++) {
            if($i > 0){
              $paginationLinks .= '<li class="page-item"><a class="page-link" href="'.$url.$apperand.'pn='.$i.'"> '.$i.' </a></li>';
            }
          }
        }
          $paginationLinks .= '<li class="page-item active"><a  class="page-link disabled" href="#!"> '.$pageNumber.' </a></li>';


          for ($i = $pageNumber + 1; $i <= $totalPages; $i++) {
              $paginationLinks .= '<li class="page-item"><a class="page-link" href="'.$url.$apperand.'pn='.$i.'"> '.$i.' </a></li>';
            if($i >= $pageNumber+4){
              break;
            }
          }

          if($pageNumber != $totalPages){
            $next = $pageNumber + 1;
            $paginationLinks .= '<li class="page-item"><a class="page-link" href="'.$url.$apperand.'pn='.$next.'">&raquo;</a></li>';
          }
          $paginationLinks = '
		      <nav aria-label="Page navigation example">
				<ul class="pagination justify-content-end my-1">
		      		'.$paginationLinks.'
		      	</ul>
		      </nav>
          ';
          }
        // calculate and create pagination


    }
    return $paginationLinks;
    }




		// generate random key
		   static function randKey($length, $type = '') {
		        $char = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
		        if ($type == "Numeric") {
		            $char = array_merge(range(0, 9));
		        } elseif ($type == "Alphabet") {
		            $char = array_merge(range('a', 'z'), range('A', 'Z'));
		        }
		        $val = '';
		        for ($i = 0; $i < $length; $i++) {
		            $val .= $char[mt_rand(0, count($char) - 1)];
		        }
		        return $val;
		    }
		// end randon number alphabet

}

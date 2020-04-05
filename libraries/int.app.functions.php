<?php

/**
 * 
 */
class Functions extends AppAuthenticate
{
	use StringEncrypt, ErrorHandler, View;

	function __construct()
	{
		parent::__construct();
		$this->traitParent = $this;

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

        
        // calculate and create pagination
        $paginationLinks = '';
        if($pageNumber > 0){
        if($pageNumber > 1){
          $previous = $pageNumber - 1;
          $paginationLinks = ' <a href="'.$this->pageLink.'?pn='.$previous.'">&laquo;</a>';

          for ($i = $pageNumber - 4; $i < $pageNumber; $i++) { 
            if($i > 0){
              $paginationLinks .= '<a href="'.$this->pageLink.'?pn='.$i.'"> '.$i.' </a>';
            }
          }
        }
          $paginationLinks .= '<a href="#!" class="active"> '.$pageNumber.' </a>';


          for ($i = $pageNumber + 1; $i <= $totalPages; $i++) {
              $paginationLinks .= '<a href="'.$this->pageLink.'?pn='.$i.'"> '.$i.' </a>';
            if($i >= $pageNumber+4){
              break;
            }
          }   

          if($pageNumber != $totalPages){
            $next = $pageNumber + 1;
            $paginationLinks .= '<a href="'.$this->pageLink.'?pn='.$next.'">&raquo;</a>';
          } 
          $paginationLinks = '
      <div class="px-3 py-4 w3-center">
      <div class="pagination">
      '.$paginationLinks.'
      </div>
      </div>
          ';
          }
        // calculate and create pagination


    }
    return $paginationLinks;
    }


}



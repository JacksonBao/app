
</div>

<!-- modal -->



<!-- Modal -->
<div class="w3-modal" id="_cwMModal" style="z-index:500000;"> <div class="w3-modal-content" id="_cwMMContent"></div></div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="_bModal" tabindex="-1" role="dialog" aria-labelledby="_bModalLabel" aria-hidden="true" style="z-index: 5000000">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="_bModalLabel">Njofa Response</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="_bmBody">
          
          
      </div>
      <div class="modal-footer w3-hide">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    
      </div>
    </div>
  </div>
</div>
<!-- modal -->



<!--include javascripts-->


<div class="snackbar" id="snackbar"></div>

<?php echo $this->func->rightButtons(); ?>






  <!-- JS PLUGIN -->
  <!-- <script type="text/javascript" src="/ck_js_plugin/jquery.min.js"></script> -->
  <!-- <script type="text/javascript" src="/ck_js_plugin/bootstrap.min.js"></script> -->
  <!-- <script type="text/javascript" src="/ck_js_plugin/carousel.js"></script> -->
  <!-- <script type="text/javascript" src="/ck_js_plugin/w3Data.js"></script> -->
  <!-- <script type="text/javascript" src="/ck_js_plugin/lightbox.min.js"></script> -->
  <!-- <script type="text/javascript" src="/ck_js_plugin/scrolltofixed-min.js"></script> -->
  <script type="text/javascript" src="/v5/public/js/ck_mainJs.js"></script>

  <!-- <script type="text/javascript" src="/v5/public/js/ck_mainJs.js"></script> -->


<!-- <script type="text/javascript" src="/v5/public/js/ck_chat_file_process.js"></script> -->
<script type="text/javascript" src="/v5/config/js/lightbox.min.js"></script>
<script type="text/javascript" src="/v5/public/js/ck_user_pattern.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.4/plyr.min.js"></script>
<!-- <script src="https://cdn.plyr.io/3.5.3/plyr.js"></script> -->

<!-- cart sys -->
<!-- <script type="text/javascript" src="/v5/public/js/ck_userCart_sys.js"></script> -->




    <?php 
if(is_array($this->js)){
    $array = $this->js;
    foreach ($array as $key => $value){
        if($key == 'Main'){
            foreach($value as $ky => $file){
                $file = '/v5/public/js/' . $file;
                   
                    echo '<script src="'.$file.'"> </script>';
              
            }
        } else {
       
               // note for other source make sure to include the full path
             if($key == 'Link'){
                 $link = $array['Link'];
//                 echo $link;''
                if(array_key_exists('Files', $array)){
                 foreach ($array['Files'] as $k => $fileArr){
                   $files = $link.$fileArr;
                }
                  
                if(!empty($files)){
                     echo '<script src="'.$files.'"> </script>';
                    } 
                 
               }
                 



             } elseif($key == 'root') {
                   foreach($value as $ky => $file){
//                    if(file_exists($file)){
                       
                    echo '<script src="'.$file.'"> </script>';
//                }
             }
            }
        }
    }
}
?>


<script type="text/javascript">
  <?php echo  $this->runJsFunc; ?>
</script>
     
<!--include javascripts-->

</body>
</html>
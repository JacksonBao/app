<?php

namespace Traits;

use Table\Classes\Users;

trait ComponentsTraits
{



  /**
   * @param subject, content, receiver = '', template, email = '', cc = []
   * @return bolean 
   */


  public function loadComponent(string $template, array $content = [])
  {
    $content = $content;
    $link = 'public/views/components/' . $template;
    if(file_exists($link)){
        ob_start(); // Start output buffer capture.
        include($link); // Include your template.
        $output = ob_get_contents(); 
        // Manipulate $output...
        ob_end_clean(); // Clear the buffer.
        $html = $output;

        foreach ($content as $key => $value) {
        $html = str_replace("{{ $key }}", $value, $html);
        }
        return $html;
    } else {
        return false;
    }
  }

    


  
}

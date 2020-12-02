<?php

namespace App\APP_NAME\Traits;

use App\APP_NAME\Table\Classes\Users;

trait EmailTemplateTraits
{

  /**
   * simple mail
   */

    public function simpleMail(array $content = [])
    {
  

    $content = $content ?: $this->emailTemplate;
    $link = 'public/views/components/emails/simple.email.en.php';
    // parse template
    // parse template
    
    ob_start(); // Start output buffer capture.
    include($link); // Include your template.
    $output = ob_get_contents();
    // Manipulate $output...
    ob_end_clean(); // Clear the buffer.
    $html = $this->compileEmailTemplate($output);
    
    

    foreach ($content as $key => $value) {
      $html = str_replace("{{ $key }}", $value, $html);
    }
    return $html;
      
    }
  /**
   * @param subject, content, receiver = '', template, email = '', cc = []
   * @return bolean 
   */

  public function sendMail(string $subject, array $content, string $receiver = '', string $template = 'defaultEmail',  string $email = '', array $cc = [])
  {
    /// count note
    if (strlen($receiver) > 0) {
      $user = new Users();
      $userData = $user->getUser($receiver);
      $email = $email ?: $userData['details']['email'];
    } else {
      $content['notification'] = 0;
    }
    // check template
    if (!method_exists($this, $template)) {
      $template = 'defaultEmail';
    }

    if(empty($email)){
      error_log('Receive: ' . $receiver, 0);
      return false;
    }

    $content['body'] = wordwrap($this->$template($content), 120);
    // mailer function
    // Always set content-type when sending HTML email
    // $headers = "MIME-Version: 1.0" . "\r\n";
    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // // More headers
    // $headers .= 'From: Njofa Wallet <wallet@njofa.com>'. "\r\n".
    // 'Reply-To: Njofa Citizen <citizen@njofa.com>' . "\r\n";

    
      // More headers
      $headers = 'From: Njofa Wallet <wallet@njofa.com>'. "\r\n".
      'Reply-To: Njofa Citizen <citizen@njofa.com>' . "\r\n";
      $headers .= "Organization: Njofa Wallet\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $headers .= "X-Priority: 3\r\n";
      $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

    if (count($cc) > 0) {
      foreach ($cc as $cc_mail) {
        $headers .= 'cc: $cc_mail' . "\r\n";
      }
    }
    if(ENV == 'PRODUCTION'){
      mail($email, $subject, $content['body'], $headers);
    }

  }

  public function defaultEmail(array $content = [])
  {

    $content = $content ?: $this->emailTemplate;
    $link = 'public/views/components/emails/default.email.en.php';
    // parse template
    // parse template
    
    ob_start(); // Start output buffer capture.
    include($link); // Include your template.
    $output = ob_get_contents();
    // Manipulate $output...
    ob_end_clean(); // Clear the buffer.
    $html = $this->compileEmailTemplate($output);
    
    

    foreach ($content as $key => $value) {
      $html = str_replace("{{ $key }}", $value, $html);
    }
    return $html;
  }


  public function notificationEmail(array $content = [])
  {

    $content = $content ?: $this->emailTemplate;
    $link = 'public/views/components/emails/notification.email.en.php';

    ob_start(); // Start output buffer capture.
    include($link); // Include your template.
    $output = ob_get_contents();
    // Manipulate $output...
    ob_end_clean(); // Clear the buffer.
    $html = $this->compileEmailTemplate($output);
    
    
    // $html = $output;

    foreach ($content as $key => $value) {
      $html = str_replace("{{ $key }}", $value, $html);
    }
    return $html;
  }


  public function verifyEmail(array $content = [])
  {

    $content = $content ?: $this->emailTemplate;
    $link = 'public/views/components/emails/verification.email.en.php';

    ob_start(); // Start output buffer capture.
    include($link); // Include your template.
    $output = ob_get_contents();
    // Manipulate $output...
    ob_end_clean(); // Clear the buffer.
    $html = $this->compileEmailTemplate($output);
    

    foreach ($content as $key => $value) {
      $html = str_replace("{{ $key }}", $value, $html);
    }
    return $html;
  }

  public function  compileEmailTemplate($html)
  {

    $w3CssLink = 'public/css/libraries/w3/w3-css.css';
    $themeLink = 'public/css/app/wallet.theme.css';
    $styleLink = 'public/css/app/style.css';
    $bootLink = 'public/css/libraries/bs/bootstrap.css';

    $style = $this->convertCss($bootLink) ?: [];
    $style = array_replace_recursive($style, $this->convertCss($themeLink)) ?: [];
    $style = array_replace_recursive($style, $this->convertCss($styleLink)) ?: [];
    $style = array_replace_recursive($style, $this->convertCss($w3CssLink)) ?: [];

    $explodeHtml  = explode('class="', $html);
    // $first = $explodeHtml[0];
    foreach ($explodeHtml as $key => $value) {
      $cssExp = explode('"', $value);
      if(count($cssExp) < 2){continue;}
      $cssMain = explode(' ', $cssExp[0]);
      $css = ''; 
      foreach ($cssMain as $keys) {
        $css .= @$style[$keys] ?: '';
      }
      $cssExp[0] = $css;
      $explodeHtml[$key] =  join('"', $cssExp);
    }

    $html =  join('class="', preg_replace( "/\r|\n/", "", $explodeHtml));
    $html = str_replace('class="', 'style="', $html);

    return $html;
  }
}

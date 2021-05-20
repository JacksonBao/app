<?php

namespace Traits;

/**
 * SANITIZE forms
 * @param $cleanStrings string, int, email, url, html
 */
trait ValidateForm
{
  public $validateObject = [];
  public $validateError = [];
  public $validateStatus = false;



  public function cleanString($string)
  {
    return filter_var($string, FILTER_SANITIZE_STRING);
  }
  public function cleanInt($int)
  {
    return (float) preg_replace('#[^0-9e\.]#', '', $int);
  }

  public function cleanEmail(string $email)
  {
    return  filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public function cleanUrl(string $url)
  {
    return filter_var($url, FILTER_VALIDATE_URL);
  }

  public function resetSanitize()
  {
    $this->validateObject = [];
    $this->validateError = [];
    $this->validateStatus = false;
  }

  function sanitizeRequest(array $post)
  {
    $post = count($post) > 0 ? $post : $_POST;
    $function = strtolower(debug_backtrace()[1]['function']);
    if(array_key_exists($function, $this->ERROR_LIST)){
      $this->errors = $this->ERROR_LIST[$function];
    }


    // run check on all items listed
    if (count($this->validateObject) > 0 && count($post) > 0 ) {

      $validated = [];
      foreach ($post as $key => $value) {
        if (array_key_exists($key, $this->validateObject)) {
          $validate = $this->validateObject[$key];
          if(!isset($validate['replace'])){
            $validate['replace'] = [];
          }
          switch ($validate['type']) {
            case 'str':
              $value = is_string($value) ?  $this->cleanString($value) : '';
              break;
            case 'int':
              $value = is_numeric($value) ?  $this->cleanInt($value) : '';
              break;
            case 'mail':
              $value = is_string($value) ?  $this->cleanEmail($value) : '';
              break;
            case 'url':
              $value = is_string($value) ?  $this->cleanUrl($value) : '';
              break;
            case 'html':
              $value = is_string($value) ?  $this->cleanHtml($value) : '';
              break;
          }
      
            $errorAppend = '';
          if (isset($validate['min']) && $validate['min'] > 0 && (($validate['type'] == 'int' && $value < $validate['min']) || ($validate['type'] == 'array' && count($value) < $validate['min']) || strlen($value) < $validate['min'])) {
            $value = '';
            $errorAppend = ucwords($key) . ' must be at least '.$validate['min']. ($validate['type'] != 'int' ? ' character(s). ' : '.');;
          }
          if (!empty($value) && isset($validate['max']) && $validate['max'] > 0 && (($validate['type'] == 'int' && $value > $validate['max']) || ($validate['type'] == 'array' && count($value) > $validate['max']) || strlen($value) > $validate['max'])) {
            $value = '';
            $errorAppend = ucwords($key) . ' must be at most '.$validate['max']. ($validate['type'] != 'int' ? ' character(s). ' : '.');
          }

        if (empty($value)) {
          $error = @$this->errors['invalid_' . strtolower($key)];
          if(isset($validate['replace']) && count($validate['replace']) > 0){
            $titles = array_keys($validate['replace']);
            $title = "{".implode("}, {", $titles) . "}";
            $titles = explode(', ', $title);
            $repVals = array_values($validate['replace']);
            $error = str_replace($titles, $repVals, $error);
          }
          $this->validateError = $this->validateObject[$key];
          $this->validateError['key'] =  $key;
          $this->validateError['message'] =  $error . ' ' . $errorAppend;
          break;
        } else {
          $validated[$key] = $value;
        }

      }

      }

      if (count($this->validateError) == 0) {
        $this->validateStatus = true;
        return $validated;
      }
    } else {
      
      $key = array_keys($this->validateObject)[0];
      $error = @$this->errors['invalid_' . strtolower($key)];
          if(isset($validate['replace']) && count($validate['replace']) > 0){
            $titles = array_keys($validate['replace']);
            $title = "{".implode("}, {", $titles) . "}";
            $titles = explode(', ', $title);
            $repVals = array_values($validate['replace']);
            $error = str_replace($titles, $repVals, $error);
          }

          $this->validateError = $this->validateObject[$key];
          $this->validateError['key'] =  $key;
          $this->validateError['message'] =  $error;
    }

  }



  public function cleanHtml(string $string)
  {
    $patterns = [
      '/<script.*?>(.*)?<\/script>/i',
      '/<form.*?>(.*)?<\/form>/i',
      '/<button.*?>(.*)?<\/button>/i',
      '/<input.*?>(.*)?<\/input>/i',
      '/<textarea.*?>(.*)?<\/textarea>/i',
      '/<checkbox.*?>(.*)?<\/checkbox>/i',
      '/<radio.*?>(.*)?<\/radio>/i',
      '/<select.*?>(.*)?<\/select>/i',
      '/<iframe.*?>(.*)?<\/iframe>/i'
    ];
    return $this->strip_tags(['iframe', 'script', 'form', 'button', 'input', 'textarea', 'checkbox', 'radio', 'select'], $string);
  }

  function strip_tags(array $tags = [], string $string)
  {

    foreach ($tags as $key => $tag) {
      $string =  preg_replace('/<' . $tag . '\b[^>]*>(.*?)<\/' . $tag . '>/is',  '', $string);
      $string = preg_replace("/<" . $tag . "[^>]+\>/i", "", $string);
    }
    return $string;
  }
}

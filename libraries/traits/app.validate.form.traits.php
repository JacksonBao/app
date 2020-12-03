<?php

namespace App\APP_NAME\Traits;

/**
 * SANITIZE forms
 * @param $cleanStrings string, int, email, url, html
 */
trait ValidateForm
{
  public $validateObject = [];
  public $validateErrors = [];

  public $validateFormError = false;
  public $validateFormErrorResponse = ['id' => '', 'message' => ''];
  public $validateFormCheckTypes = ['string' => 'strlen', 'email' => '', 'int' => '', 'array' => 'count', 'float' => ''];



  public function cleanString($string)
  {
    return filter_var($string, FILTER_SANITIZE_STRING);
  }
  public function cleanInt($int)
  {
    return (float) preg_replace('#[^0-9\.]#', '', $int);
  }

  public function cleanEmail(string $email)
  {
    return  filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public function cleanUrl(string $url)
  {
    return filter_var($url, FILTER_VALIDATE_URL);
  }


  public function sanitizeReset()
  {
    $this->validateFormError = false;
    $this->validateFormErrorResponse = ['id' => '', 'message' => ''];
  }

  public function initErrorLang($method = 'main', $lang = lang)
  {
    $errorFile = 'models/app.engine.models/app.engine.errors/validate_errors/error_{{lang}}.php';
    $file =  str_replace('{{lang}}', $lang, $errorFile);

    if (file_exists($file)) {
      $errorObject = require_once $file;
      if (array_key_exists($method, $errorObject)) {
        $this->validateErrors = $errorObject[$method];
      }
    }

    if (count($this->validateErrors) == 0) {
      $file =  str_replace('{{lang}}', 'en', $errorFile);
      $errorObject = require_once $file;
      $this->validateErrors = $errorObject['main'];
    }

    return $this->validateErrors;
  }

  function sanitizePost(array $post = [])
  {
    $this->sanitizeReset();
    $this->initErrorLang();
    $post = count($post) > 0 ? $post : $_POST;

    // run check on all items listed
    if (count($this->sanitize_obj) > 0) {
      foreach ($this->sanitize_obj as $key => $checker) {

        if (array_key_exists('method', $checker)) {
          $method = 'clean' . ucwords($checker['method']);
          if (method_exists($this, $method)) {
            $checker['value'] = $this->$method($checker['value']);
            if ($this->checkCondition($checker) == true) {
              $post[$checker['name']] = $checker['value'];
            } else {
              $this->validateFormError = true;
              $this->validateFormErrorResponse['id'] = $checker['id'];
              $this->validateFormErrorResponse['message'] = $checker['message']. ' '. $this->errorMessage;
              return $this->validateFormErrorResponse;
            }
          }
        }
      }
    }


    return $post;
  }


  public function checkCondition(array $object)
  {
    if (array_key_exists('null', $object) && $object['null'] == false && empty($object['value'])) {
      $this->errorMessage = str_replace('{{field}}', $object['name'], $this->validateErrors['null']);
      return false;
    }

    if (array_key_exists('min', $object) && $object['min'] > 0 && strlen($object['value']) >= $object['min']) {
      $this->errorMessage = str_replace(['{{field}}', '{{min}}'], [$object['name'], $object['min']], $this->validateErrors['min']);
      return false;
    }

    if (array_key_exists('max', $object) && $object['max'] > 0 && strlen($object['value']) >= $object['min']) {
      $this->errorMessage = str_replace(['{{field}}', '{{max}}'], [$object['name'], $object['max']], $this->validateErrors['max']);
      return false;
    }
    return true;
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

<?php
namespace App\Market\Traits;
/**
* SANITIZE forms
*/
trait ValidateForm
{
  public $lang = 'en';
  public $sanitize_obj = [
    'string' => ['string', 'Extension', 'OrgName', 'NwName', 'name', 'type', 'country',
    'country_name', 'country_code', 'state', 'city',
    'region', 'address', 'photosDescription'],
    'int' => ['int', 'code', 'phone', 'Index', 'Size', 'IPv4','latitude','longitude'],
    'email' => ['email'],
    'url' => ['url', 'Url', ],
    'alphanum' => ['alphanum', 'zip_code', 'postal'],
    'html' => ['html', 'Data', 'excerpt', 'description'],
    'array' => []

  ];

  public $validateFormConditions = [];
  public $modelAppLangResponse = [
    'en' => [
      'name' => ['Length' => [/*'min'*/ 0, /*"max"*/ 0], 'nullable' => true, 'message' => '', 'id' => ''],
        'string' => ['ength' => [/*'min'*/ 0, /*"max"*/ 0], 'nullable' => true, 'message' => '', 'id' => ''],
          'country_name' => ['ength' => [/*'min'*/ 0, /*"max"*/ 0], 'nullable' => true, 'message' => '', 'id' => '']
          ]
        ];

        public $validateFormError = false;
        public $validateFormErrorResponse = ['id' => '', 'message' => ''];
        public $validateFormCheckTypes = ['string' => 'strlen', 'int' => '', 'array' => 'count', 'float' => ''];

        public $sanitize_filters = [
          'string' => ['Method' => FILTER_SANITIZE_STRING],
          'int' => ['Method' => FILTER_VALIDATE_INT],
          'email' => ['Method' => FILTER_VALIDATE_EMAIL],
          'url' => ['Method' => FILTER_VALIDATE_URL]
        ];

        public function sanitizeReset()
        {
          $this->validateFormError = false;
          $this->validateFormErrorResponse = ['id' => '', 'message' => ''];
        }

        function sanitizePost(array $post = [])
        {
          $post = count($post) > 0 ? $post : $_POST;

          $checked = true;
          foreach ($post as $name => $value) {
            if($checked == false){ break;}

            foreach ($this->sanitize_obj as $meth => $list) {
              if(!is_array($value)){
                if(in_array($name, $list) && $meth != 'alphanum' && $meth != 'html' && $meth != 'array'){
                  $post[$name] = filter_var($value, $this->sanitize_filters[$meth]['Method']);
                  $checked = $this->checkCondition($name, $post[$name],  $meth);
                  break;
                } elseif(in_array($name, $list) && $meth == 'html') {
                  $post[$name] = $this->sanitizeHTML($value);
                  $checked = $this->checkCondition($name, $post[$name], 'string');
                  break;
                } elseif(in_array($name, $list) && $meth == 'alphanum') {
                  $post[$name] = preg_replace('#[^a-zA-Z0-9\.]#i', '', $value);
                  $checked = $this->checkCondition($name, $post[$name], 'string');
                  break;
                } else {
                  $post[$name] = $value;
                  $checked = $this->checkCondition($name, $post[$name], $meth);
                  break;
                }

              } else { // could not find method ie // mysqlirealescape for string
                // validate EvWatcher
                $checked = $this->checkCondition($name, $value, 'array');
                if($checked == true){
                  foreach ($value as $n => $v) {
                    if(is_array($v)){ $post[$name][$n] = $this->mysqli_real_escape_array($v, $this->dbm);continue;}

                    foreach ($this->sanitize_obj as $m => $l) {
                      if(in_array($n, $l) && $m != 'html' && $m != 'alphanum'){
                        $checked = true;
                        $post[$name][$n] = filter_var($v, $this->sanitize_filters[$m]['Method']);
                        break;
                      } elseif(in_array($n, $l) && $m == 'html') {
                        $checked = true;
                        $post[$name][$n] = $this->sanitizeHTML($v);
                        break;
                      } elseif(in_array($n, $l) && $m == 'alphanum') {
                        $checked = true;
                        $post[$name][$n] = preg_replace('#[^a-zA-Z0-9\.]#i', '', $v);
                        break;
                      } else {
                        $post[$name][$n] = $v;
                        break;
                      }
                    }
                  }
                }

              }

            }
          }

          return $post;
        }


        public function checkCondition( string $key, $data, string $type = '')
        {

          $this->validateFormConditions = @$this->modelAppLangResponse[$this->lang] ?: [];
          if(array_key_exists($key, $this->validateFormConditions)){
            $options = $this->validateFormConditions[$key];
            $nullable = $options['nullable'];
            if($nullable == true){

              return true;
            } else {

              @list($min, $max) = $options['length'] ?: [0,0];
              $checkKeys = array_keys($this->validateFormCheckTypes);
              if(in_array($type, $checkKeys)){
                $function = 'is_'.$type;
                if($function($data)){
                  $checkFunctions = $this->validateFormCheckTypes[$type] ?: 'strlen';
                  $isError = false;
                  if($min > 0 && $checkFunctions($data) < $min ){
                    $isError = true;
                  }
                  if($isError == false && $max > 0 && $checkFunctions($data) > $max ){
                    $isError = true;
                  }

                  if($isError == true){
                    $this->validateFormErrorResponse['id'] = @$options['id'];
                    $this->validateFormErrorResponse['message'] = @$options['message']  ?: 'Error: ' . $type .' must be between '.$min.' and '.$max;
                    $this->validateFormErrorResponse['phase'] = @$options['phase'];
                    $this->validateFormError = true;
                    return false;
                  } else {
                    return true;
                  }
                } else {
                  $this->validateFormErrorResponse['id'] = @$options['id'];
                  $this->validateFormErrorResponse['message'] = @$options['message'] .' Submited ' . gettype($data)  . ' instead of '. $type .' | '. $data .' | '. $key .' | '  ?: 'Error: fill in all the form fields properly.';
                  $this->validateFormErrorResponse['phase'] = @$options['phase'];
                  $this->validateFormError = true;
                  return false;
                }
              } else {
                $this->validateFormError['message'] = 'Unsupported validation type "'.$type.'".';
                $this->validateFormError = true;
                return false;
              }
            }
          } else {
            return true;
          }

        }

        public function sanitizeItem($item, string $method)
        {
          $valid = filter_var($item, $this->sanitize_filters[$method]['Method']);
          return $valid;
        }

        public function sanitizeHTML(string $string)
        {
          $paterns = [
            '/<script.*?>(.*)?<\/script>/im',
            '/<form.*?>(.*)?<\/form>/im',
            '/<button.*?>(.*)?<\/button>/im',
            '/<input.*?>(.*)?<\/input>/im',
            '/<textarea.*?>(.*)?<\/textarea>/im',
            '/<checkbox.*?>(.*)?<\/checkbox>/im',
            '/<radio.*?>(.*)?<\/radio>/im',
            '/<select.*?>(.*)?<\/select>/im',
            '/<iframe.*?>(.*)?<\/iframe>/im'
          ];
          return preg_replace($paterns, ' ', $string);
        }
      }

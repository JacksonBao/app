<?php
namespace App\APP_NAME\Traits;
/**
* SANITIZE forms
*/
trait ValidateForm
{
  public $lang = 'en';
  public $valErrorMain = '';
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
        'string' => ['Length' => [/*'min'*/ 0, /*"max"*/ 0], 'nullable' => true, 'message' => '', 'id' => ''],
          'country_name' => ['Length' => [/*'min'*/ 0, /*"max"*/ 0], 'nullable' => true, 'message' => '', 'id' => '']
          ]
        ];

        public $validateFormError = false;
        public $validateFormErrorResponse = ['id' => '', 'message' => ''];
        public $validateFormCheckTypes = ['string' => 'strlen', 'email' => '', 'int' => '', 'array' => 'count', 'float' => ''];

        public $sanitize_filters = [
          'string' => ['Method' => 'cleanString'],
          'int' => ['Method' => 'cleanInteger'],
          'email' => ['Method' => 'cleanString'],
          'url' => ['Method' => 'cleanUrl']
        ];

        public function cleanString($string)
        {
          return filter_var($string, FILTER_SANITIZE_STRING);
        }
        public function cleanInteger($int)
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

        public function checkRequired($param = [])
        {
          if(is_array($this->modelAppLangResponse[$this->lang])) {
          $requiredObject = $this->modelAppLangResponse[$this->lang] ?: [];
          $paramKeys = array_keys($param);
          $checkArray = [];
          foreach ($requiredObject as $key => $value) {
            if(is_array($value) && array_key_exists('nullable', $value) && $value['nullable'] == false){
              array_push($checkArray, $key);
            }
          }
          $difference = array_diff($checkArray, $paramKeys);
          if(count($difference) > 0){ // dere is an error
            $currentKey = array_keys($difference)[0];
              $options = $requiredObject[$difference[$currentKey]];
              $this->validateFormErrorResponse['id'] = @$options['id'];
              $this->validateFormErrorResponse['message'] = @$options['message']  ?: 'Fill in all required fields.';
              $this->validateFormErrorResponse['phase'] = @$options['phase'];
              $this->validateFormError = true;
              $this->valErrorMain = 'isError 3';
              return false;
          }

        }
          return true;

        }

        function sanitizePost(array $post = [])
        {
          $this->sanitizeReset();
          $post = count($post) > 0 ? $post : $_POST;
          if($this->checkRequired($post) == true){
          $checked = true;
          foreach ($post as $name => $value) {
            if($checked == false){ break;}

            foreach ($this->sanitize_obj as $meth => $list) {
              if(!is_array($value)){
                if(in_array($name, $list) && !is_array($value) && $meth != 'alphanum' && $meth != 'html' && $meth != 'array'){
                  if($meth == 'int') {$value = preg_replace('#[^0-9\.]#', '', $value) ?: 0; $value *= 1; $value = (float) $value;}
                  $method = $this->sanitize_filters[$meth]['Method'];
                  if(is_array($value)){echo $name;}
                  $post[$name] = $this->$method($value);
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
                } elseif(in_array($name, $list)) {
                  $post[$name] = $value;
                  $checked = $this->checkCondition($name, $post[$name], $meth);
                  break;
                }

                continue;

              } else { // could not find method ie // mysqlirealescape for string
                // validate EvWatcher
                $checked = $this->checkCondition($name, $value, 'array');
                if($checked == true){
                  foreach ($value as $n => $v) {
                    if(is_array($v)){ $post[$name][$n] = $this->mysqli_real_escape_array($v, $this->dbm);continue;}
                    // var_dump($post['amount'], 1);
                    foreach ($this->sanitize_obj as $m => $l) {
                      if(in_array($n, $l) && !is_array($v) && $m != 'html' && $m != 'alphanum'){
                        $checked = true;
                        $method = $this->sanitize_filters[$m]['Method'];
                        $post[$name][$n] = $this->$method($v);
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
                $type = ($type == 'email' ? 'string' : $type);
                $type = ($type == 'int' ? 'float' : $type);
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
                    $this->valErrorMain = 'isError 2';
                    return false;
                  } else {
                    return true;
                  }
                } else {
                  $this->validateFormErrorResponse['id'] = @$options['id'];
                  $this->validateFormErrorResponse['message'] = @$options['message'] .' Submitted ' . gettype($data)  . ' instead of '. $type . '|'. $data .'-'.$key    ?: 'Error: fill in all the form fields properly.';
                  $this->validateFormErrorResponse['phase'] = @$options['phase'];
                  $this->validateFormError = true;
                  $this->valErrorMain = 'isError 3';

                  return false;
                }
              } else {
                $this->validateFormErrorResponse['message'] = 'Unsupported validation type "'.$type.'".';
                $this->validateFormError = true;
                    $this->valErrorMain = 'isError 4';
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

        function strip_tags(array $tags = [], string $string) {

          foreach ($tags as $key => $tag) {
          $string =  preg_replace('/<'.$tag.'\b[^>]*>(.*?)<\/'.$tag.'>/is',  '', $string);
          $string = preg_replace("/<".$tag."[^>]+\>/i", "", $string);
          }
          return $string;
        }

        
      }

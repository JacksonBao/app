<?php
 namespace App\Market\Traits;
/**
 *
 */
Trait ModelTables
{
  private $mt_class;
  private $mt_table;
  private $mt_object;

  function generateModelTableTemplate($table) {

    // get table
    // Query to get columns from table
      $this->mt_table = $table;

      $query = $this->in_query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$this->database' AND TABLE_NAME = '$table'");
      while($row = $query->fetch_assoc()){
          $result[] = $row;
      }
      // Array of all column names
      $columnArr = array_column($result, 'COLUMN_NAME');
      // create object
      $this->mt_object = "['".join($columnArr, "' => '', '") ."' => '']";
      $page = str_replace(['_', 'nj.mp.'], ['.', ''], $table);
      $this->mt_class = str_replace(' ', '', ucwords(str_replace('.', ' ', $page)));

      $myfile = fopen("models/db.tables/db.$page.php", "w") or die("Unable to open file!");
      $txt = $this->template();
      fwrite($myfile, $txt);
      fclose($myfile);

      $myfileClass = fopen("models/db.tables.classes/db.class.$page.php", "w") or die("Unable to open file!");
      $txt = $this->templateClasse();
      fwrite($myfileClass, $txt);
      fclose($myfileClass);

// save files include to auto Yaf_Loader
$myfileAutoload = fopen("libraries/int.app.autoloader.in.php", "a+") or die("Unable to open file!");
$txt = "
// INCLUDE $this->mt_class
include_once 'models/db.tables/db.$page.php';
include_once 'models/db.tables.classes/db.class.$page.php';
Use \App\Market\Tables\Db$this->mt_class;
Use \App\Market\Table\Classes\/$this->mt_class;
// END INCLUDE $this->mt_class
";
fwrite($myfileAutoload, $txt);
fclose($myfileAutoload);


  }

  private function templateClasse()
  {
    $mt_class_lower = strtolower($this->mt_class);
    return '<?php
        namespace App\Market\Table\Classes;
        /**
         * GET ALL DATA RELATING TO '.$this->mt_class.' table
         */
        class '.$this->mt_class.' extends \App\Market\Libraries\Models
        {
            private $'.$mt_class_lower.'_id = "";
            public $'.$mt_class_lower.'_data = [];
            public $'.$mt_class_lower.'_table = "'.$this->mt_table.'";

            public function __construct(string $id = "")
            {
                parent::__construct();
                if(!empty($id)){
                  $this->'.$mt_class_lower.'_id = $id;
                } else {
                  $this->'.$mt_class_lower.'_id = $this->'.strtoupper($this->mt_class).'_ID;
                }

              // get page data
              $id = $this->'.$mt_class_lower.'_id;
              $this->page_data = $this->getTableData(\''.$this->mt_table.'\', $id);

            }
        }
';
  }

  private function template()
  {
    return '<?php
    namespace App\Market\Tables;
    /**
     * MANAGE POST, PUT DELETE UPDATE OF TABLE '.$this->mt_class.'
     */
    class Db'.$this->mt_class.' extends \App\Market\Libraries\Models
    {
      public $rows;

      function __construct()
      {
        parent::__construct();
        $this->rows = (object) '.$this->mt_object.';
        $this->table = \''.$this->mt_table.'\';

        // authenticate table permission
        // authenticate table permission
      }

      public function reset()
      {
        $this->rows = (object) '.$this->mt_object.';
      }

      public function create()
      {
        $table = ( array ) $this->rows;
        return $this->structInsert($table);
      }

      public function update(int $id)
      {
        $table = ( array ) $this->rows;
        return $this->structUpdate($table, $id);
      }

      public function delete(int $id)
      {
        return $this->structDelete($id);
      }

      
    }


    ';
  }

}

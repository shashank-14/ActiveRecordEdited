<?php


class collection {
    static public function create() {
      $model = new static::$modelName;
      return $model;
    }
    
    static public function findAll() {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll(PDO::FETCH_ASSOC);
        self::displayTable($recordsSet,$tableName);
        }
        
        public static function displayTable($recordsSet,$tableName){
          $display='';
          $display.='<table border=2>';
          $db1=dbConn::getConnection();
          $sql1 = 'SHOW COLUMNS FROM '.$tableName;
          $stmt1 = $db1->prepare($sql1);
          $stmt1->execute();
          $headers=$stmt1->fetchAll(PDO::FETCH_COLUMN);
        
          foreach($headers as $col){
              $display.="<td>$col</td>";
              }
          foreach( $recordsSet as $row) {
          $display.="<tr>";
          foreach($row as $col){
            $display.="<td>$col</td>";
            }
            $display.="<tr>";
          }    
          $display.='</table>';
          display::printThis($display);
        }
                  
    static public function findOne($id) {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $tableName);
        $recordsSet =  $statement->fetchAll();
        self::displayTable($recordsSet,$tableName);
    }
}

?>
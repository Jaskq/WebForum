<?php

class DbAccess {

  private $host;
  private $user;
  private $password;
  private $database;
  public $db_connection;

  // Set up the Database connection.
  function __construct($host, $user, $password, $database){
     $this->host = $host;
     $this->user = $user;
     $this->password = $password;
     $this->database = $database;
   }

   // Query the Database
   private function queryDB($query){
      $this->connectDB();
      $result = $this->db_connection->query($query);
    	return $result;
      $this->disconnectDB();
    }

    public function selectDB($table, $where = "", $fields = "", $order = ""){
      $fields = ($fields ? implode(', ', $fields) : "*");
      $where = ($where ? 'where '.$where : '');
      $order = ($order ? 'order by '.$order : '');
      $query = sprintf("select %s from %s %s %s;", $fields, $table, $where, $order);
      return $this->queryDB($query);
    }

    public function insertDB($table, $values, $fields = "", $where = "", $order = ""){
      $where = ($where ? 'where '.$where : '');
      $order = ($order ? 'order by '.$order : '');
      $query = sprintf("insert into %s (%s) values (%s) %s %s;", $table, implode(', ', $fields), implode(', ', $values), $where, $order);
      return $this->queryDB($query);
    }

    public function updateDB($table, $values, $fields = "", $where){
      $size = count($fields);
      $query = sprintf("update %s set ", $table);
      for($i = 0; $i < $size; $i++){
        $query .= sprintf("%s = %s", $fields[$i], $values[$i]);
        if($i < $size-1){
          $query .=",";
        }
      }
      $query .= sprintf("where %s;", $where);
      return $this->queryDB($query);
    }

    public function deleteDB($table, $where){
      $query = sprintf("delete from %s where %s;", $table, $where);
      return $this->queryDB($query);
    }

    private function connectDB(){
      $db_connection = new mysqli($this->host, $this->user, $this->password, $this->database);
      if ($db_connection->connect_error) {
        die($this->db_connection->connect_error);
      }
      $this->db_connection = $db_connection;
    }

    private function disconnectDB(){
       $this->$db_connection->close();
     }
}
?>

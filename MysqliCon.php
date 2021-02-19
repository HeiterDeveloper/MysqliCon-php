<?php

class MysqliCon {

  private $host;
  private $user;
  private $pass;
  private $db;
  private $lastError;
  private $con;

  function __construct($host, $user, $pass, $db){

    $this->host = $host;
    $this->pass = $pass;
    $this->user = $user;
    $this->db = $db;
  }

  public function connect(){

    $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    if($this->con){
      return true;
    }
    else{
      return false;
    }
  }

  public function closeConnection(){

    $close = mysqli_close($this->con);
    return $close;
  }

  public function getLastError(){

    return $this->lastError;
  }

  public function select($colunas, $tabelas, $where, $extra=false){

    $cols = implode(", ", $colunas);
    $tabs = implode(", ", $tabelas);
    $wh = implode(" ", $where);
    $strQuery = "SELECT $cols FROM $tabs WHERE $wh $extra";

    $query = mysqli_query($this->con, $strQuery);
    if($query){
      $numRows = mysqli_affected_rows($this->con);
      $resu = null;
      while($r=mysqli_fetch_assoc($query)){
        $resu[] = $r;
      }
      return array("numRows"=>$numRows, "result"=>$resu);
    }
    else{
      $this->lastError = mysqli_error($this->con);
      return false;
    }
  }

  public function insert($tabela, $colunas, $valores){

    $vals;
    foreach($valores as $v){
      $vals[]  = "('" . implode("','", $v) . "')";
    }
    $strVals = implode(",", $vals);

    $strQuery = "INSERT INTO $tabela(" . implode(",", $colunas) . ") VALUES$strVals";
    $query = mysqli_query($this->con, $strQuery);

    if($query){
      return array("rows"=>mysqli_affected_rows($this->con), mysqli_insert_id($this->con));
    }
    else{
      $this->lastError = mysqli_error($this->con);
      return false;
    }
  }

  public function delete($tabela, $where){

    $strQuery = "DELETE FROM $tabela WHERE $where";
    $query = mysqli_query($this->con, $strQuery);
    if($query){
      return array("rows"=>mysqli_affected_rows($this->con));
    }
    else{
      $this->lastError = mysqli_error($this->con);
      return false;
    }
  }

  public function update($tabela, $cols, $vals, $where){
    $colsVals;

    for($x=0; $x < count($cols); $x++){
      $colsVals[] = $cols[$x] . " = '" . $vals[$x] . "'";
    }
    $strColsVals = implode(", ", $colsVals);

    $strQuery = "UPDATE $tabela SET $strColsVals WHERE $where";

    $query = mysqli_query($this->con, $strQuery);
    if($query){
      return array("rows"=>mysqli_affected_rows($this->con), mysqli_insert_id($this->con));
    }
    else{
      $this->lastError = mysqli_error($this->con);
      return false;
    }
  }

  public function customQuery($query){
    $query = mysqli_query($this->con, $query);
    if($query){
      return true;
    }
    else{
      $this->lastError = mysqli_error($this->con);
      return false;
    }
  }
}

?>

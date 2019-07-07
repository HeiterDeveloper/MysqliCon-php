<?php
/**
*@author Heiter Developer <dev@heiterdeveloper.com>
*@link https://github.com/HeiterDeveloper/MysqliCon-php
*@copyright 2018 Heiter Developer
*@license Aapache License 2.0
*@license https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
**/

class MysqliCon{
  public $end = "location database";
  public $user = "user database";
  public $pass = "password database";
  public $db = "name database";
  public $charset = "utf8";

  public function conec(){
    $cn = mysqli_connect($this->end, $this->user, $this->pass, $this->db);
    mysqli_set_charset($cn, $this->charset);
    if($cn){
      return array("con"=>$cn, "status"=>true, "error"=>NULL);
    }
    else{
      return array("con"=>NULL, "status"=>false, "error"=>mysqli_connect_error());
    }
  }

  public function fechaCon($con){
    mysqli_close($con['con']);
  }

  public function query($con, $query){
    if($con['status'] == true){
      $q = mysqli_query($con['con'], mysql_escape_string($query));
      if($q){
        $resu = array();
        $typeQuery = strtoupper(explode(" ", $query)[0]);
        if($typeQuery == "SELECT"){
          while($r=mysqli_fetch_assoc($q)){
            $resu[] = $r;
          }
        }
        return array("result"=>$resu, "rows"=>mysqli_affected_rows($con['con']), "status"=>true);
      }
      else{
        return array("result"=>NULL, "status"=>false, "error"=>mysqli_error($con['con']));
      }
    }
  }
}
?>

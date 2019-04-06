<?php
  class DB_CONNECT{
    function __construct(){
      $this->connect();
    }

    function __destruct(){
      $this->close();
    }

    function connect(){
      include("db_config.php");
      $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
      return $con;
    }


    function close(){
      mysql_close();
    }

  }
 ?>

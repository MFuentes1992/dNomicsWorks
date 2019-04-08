<?php

  $response = array();
  if(!isset($_POST["source"])){
    $_POST = json_decode(file_get_contents('php://input'), true);
  }

  if(isset($_POST['email']) ){
    $email = $_POST['email'];
    include("db_config.php");
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
    $sql = "SELECT * FROM usuario WHERE email = $email";
    $stm = $con->query($sql);
    $result = mysqli_fetch_array($stm);
    $ID = $result['userID'];

    if(count($result) > 0){
      $response = $result;
    }else{
      $response['success'] = false;
      $response['message'] = "User not registered";
    }

  }else{
    $response['success'] = false;
    $response['message'] = "No email provied";
  }

  echo json_encode($response);

 ?>

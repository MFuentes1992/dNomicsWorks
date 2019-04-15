<?php

  $response = array();
  if(!isset($_POST["source"])){
    $_POST = json_decode(file_get_contents('php://input'), true);
  }

  if(isset($_POST['email']) && isset($_POST['user_password'])){
    $email = $_POST['email'];
    $password = $_POST['user_password'];
    include("db_config.php");
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
    $sql = "select userID, first_name, last_name, user_password, user_email, create_date, update_date, img_url, create_source , currency_name, status_name
	   from usuario u, user_status us, currency c
		   where u.statusID = us.statusID and u.currencyID = c.currencyID and u.user_email = '".$email."'
		     AND u.user_password ='". $password."' AND u.create_source <> 'Facebook'";
    $stm = $con->query($sql);
    $result = mysqli_fetch_array($stm);
    $ID = $result['userID'];

    if(count($result) > 0){
      $response['success'] = true;
      $response['new'] = false;
      $response['message'] = "Bienvenido usuario ".$result['user_email'];
      $response['userID'] = $result['userID'];
      $response['first_name'] = $result['first_name'];
      $response['last_name'] = $result['last_name'];
      $response['user_password'] = $result['user_password'];
      $response['user_email'] = $result['user_email'];
      $response['currency_name'] = $result['currencyID'];
      $response['create_date'] = $result['create_date'];
      $response['update_date'] = $result['update_date'];
      $response['img_url'] = $result['img_url'];
      $response['status_name'] = $result['statusID'];
      $response['create_source'] = $result['create_source'];
    }else{
      $response['success'] = false;
      $response['new'] = false;
      $response['userID'] = 0;
      $response['message'] = "Usuario no encontrado - Source Email -";
    }

  }else if(isset($_POST['email'])){
    $email = $_POST['email'];
    include("db_config.php");
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
    $sql = "SELECT * FROM usuario WHERE user_email = '".$email."'";
    $stm = $con->query($sql);
    $result = mysqli_fetch_array($stm);
    $ID = $result['userID'];
    if(intval($ID) > 0){
      $response['success'] = true;
      $response['new'] = false;
      $response['userID'] = $ID;
      $response['message'] = "Usuario encontrado";
    }else {
      $response['success'] = false;
      $response['new'] = true;
      $response['message'] = "Usuario no encontrado - Source Facebook -";
    }
  } else{
    $response['success'] = false;
    $response['message'] = "No email provied";
  }

  echo json_encode($response);

 ?>

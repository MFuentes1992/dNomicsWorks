<?php
  $response = array();
  if(!isset($_POST["source"])){
    $_POST = json_decode(file_get_contents('php://input'), true);
  }

  if(isset($_POST['email']) && isset($_POST["user_password"]) && isset($_POST["create_date"]) && isset($_POST["update_date"]) && isset($_POST["img_data"])
  && isset($_POST["currencyID"]) && isset($_POST["statusID"])){

    $email = $_POST["email"];
    $userPassword = $_POST["user_password"];
    $createDate = $_POST["create_date"];
    $updateDate = $_POST["update_date"];
    $imgData = $_POST["img_data"];
    $ImageName = $_POST["img_name"];
    $currencyID = intval($_POST["currencyID"]);
    $statusID = intval($_POST["statusID"]);



    include("db_config.php");
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);

    $query = "SELECT * FROM usuario WHERE user_email = '".$email."'";
    $stm = $con->query($query);
    $usuario = mysqli_fetch_array($stm);

    if(count($usuario) <= 0){
      $result = mysqli_query($con, "INSERT INTO usuario (user_email, user_password, currencyID, create_date, update_date, img_url,statusID, create_source)
        VALUES ('$email', '$userPassword', '$currencyID', '$createDate', '$updateDate', '$ImageName','$statusID', 'Email')");

       $last_id = mysqli_insert_id($con);
       $ImagePath = "upload/$ImageName.jpg";
    }

    if(isset($result) && $result){
      file_put_contents($ImagePath,base64_decode($imgData));
      $response["success"] = true;
      $response["message"] = "User added successfully";
    }else if(count($usuario) > 0){
      $response["success"] = false;
      $response["message"] = "El email ya esta registrado.";
    } else {
      $response["success"] = false;
      $response["message"] = "cannot add user";
    }
    /*$response['success'] = true;
    $response['message'] = $query;*/


  }else if(isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name'])
    && isset($_POST["create_date"]) && isset($_POST["update_date"]) && isset($_POST["currencyID"]) && isset($_POST["statusID"]) && isset($_POST["Facebook"])){
      $email = $_POST['email'];
      $firstName = $_POST['first_name'];
      $lastName = $_POST['last_name'];
      $createDate = $_POST['create_date'];
      $updateDate = $_POST['update_date'];
      $currencyID = $_POST['currencyID'];
      $statusID = $_POST['statusID'];

      include("db_config.php");
      $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);

      $query = "SELECT * FROM usuario WHERE user_email ='".$email."'";
      $stm = $con->query($query);
      $usuario = mysqli_fetch_array($stm);

      if(count($usuario) <= 0){
        $result = mysqli_query($con, "INSERT INTO usuario (first_name, last_name, user_email, currencyID, create_date, update_date, statusID, create_source)
          VALUES ('$firstName', '$lastName', '$email', '$currencyID', '$createDate', '$updateDate','$statusID', 'Facebook')");

        $last_id = mysqli_insert_id($con);
      }

      if(isset($result) && $result){
        $response["success"] = true;
        $response["message"] = "User added successfully";
      }else if(count($usuario) > 0){
        $response["success"] = false;
        $response["message"] = "El email ya esta registrado.";
      }else{
        $response["success"] = false;
        $response["message"] = "Algo salio mal";
      }

  } else {
    $response["success"] = false;
    $response["message"] = "Missging values";
  }
  echo json_encode($response);
 ?>

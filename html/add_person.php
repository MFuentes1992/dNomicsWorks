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

    $result = mysqli_query($con, "INSERT INTO usuario (user_email, user_password, currencyID, create_date, update_date, img_url,statusID)
      VALUES ('$email', '$userPassword', '$currencyID', '$createDate', '$updateDate', '$ImageName','$statusID')");

     $last_id = mysqli_insert_id($con);
     $ImagePath = "upload/$ImageName".$last_id.".jpg";

    if($result){
      file_put_contents($ImagePath,base64_decode($imgData));
      $response["success"] = true;
      $response["message"] = "User added successfully";
    }else{
      $response["success"] = false;
      $response["message"] = "cannot add user";
    }


  }else{
    $response["success"] = false;
    $response["message"] = "Missging values";
  }
  echo json_encode($response);
 ?>

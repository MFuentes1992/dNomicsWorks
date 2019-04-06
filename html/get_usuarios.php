<?php
  include("db_config.php");
  $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
  $userID = 5;
  $sql = "SELECT * FROM usuario WHERE userID = $userID";
  $stm = $con->query($sql);
  $result = mysqli_fetch_array($stm);
  //echo $result['user_email'];
  //header("Content-type: image/jpeg");
  $image =  $result['img_url'];
  $path = $image.''.$userID.".jpg";
  //echo $image;
  //var_dump($result['img_data']);
  //echo $path;
  echo '<img src="http://192.168.0.14/upload/'.$path.'"/>';

 ?>

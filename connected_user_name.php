<?php
  require 'dbconnect.php';

  // $user_id_query = "SELECT userID FROM user WHERE username = ".$_SESSION['usrname'];
  // $connected_user_id = mysqli_query($conn, $user_id_query);
  $connected_user_id="9/TTPft2JDhUoxeoggc7xkx4am1zMG52dFUwL3cxVy9Na3huYmc9PQ==";

  $connected_user_name_query = sprintf("SELECT name, surname FROM user WHERE userId = '%s'", mysqli_real_escape_string($conn,$connected_user_id));
  $connected_user_name_result = mysqli_query($conn, $connected_user_name_query);
  if(!$connected_user_name_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($connected_user_name_result)) {
    $connected_user_name = sprintf($row['name']." ".$row['surname']);
  }
  echo json_encode(array($connected_user_name));

?>

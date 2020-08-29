<?php
  require 'dbconnect.php';
  session_start();

  $user_id_query = "SELECT userID FROM user WHERE username = '". $_SESSION['username'] . "'";
  $connected_user_id_result = mysqli_query($conn, $user_id_query);
  while ($row = mysqli_fetch_assoc($connected_user_id_result)) {
    $connected_user_id = sprintf($row['userID']);
  }

  $connected_user_name_query = sprintf("SELECT name, surname FROM user WHERE userId = '%s'", $connected_user_id);
  $connected_user_name_result = mysqli_query($conn, $connected_user_name_query);
  if(!$connected_user_name_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($connected_user_name_result)) {
    $connected_user_name = sprintf($row['name']." ".$row['surname']);
  }
  echo json_encode(array($connected_user_name));

?>

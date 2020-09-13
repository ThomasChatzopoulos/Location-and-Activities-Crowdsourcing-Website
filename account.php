<?php
  require 'dbconnect.php';

  $data=array();

  session_start();
  $connected_user_id="";
  $user_id_query = "SELECT userID FROM user WHERE username = '". $_SESSION['username'] . "'";
  $connected_user_id_result = mysqli_query($conn, $user_id_query);
  while ($row = mysqli_fetch_assoc($connected_user_id_result)) {
    $connected_user_id = sprintf($row['userID']);
  }

  $data_query='SELECT name, surname, username, email FROM user WHERE userId="'.$connected_user_id.'"';
  $data_results = mysqli_query($conn, $data_query);

  while ($row = mysqli_fetch_assoc($data_results)) {
      $users_act_array[0]=$row['name'];
      $users_act_array[1]=$row['surname'];
      $users_act_array[2]=$row['username'];
      $users_act_array[3]=$row['email'];
  }

  if(isset($_POST['save']) && $_POST['save']=='true'){
    if($_POST['new_name']!=$users_act_array[0] || $_POST['new_surname']!=$users_act_array[1] ||  $_POST['new_username']!=$users_act_array[2]){
      $user_id_query = "SELECT userID FROM user WHERE username = '". $_SESSION['username'] . "'";
      $connected_user_id_result = mysqli_query($conn, $user_id_query);
      while ($row = mysqli_fetch_assoc($connected_user_id_result)) {
        $connected_user_id = sprintf($row['userID']);
      }

      $sql_update='UPDATE user SET name="'.$_POST['new_name'].'", surname="'.$_POST['new_surname'].'",username="'.$_POST['new_username'].'" WHERE userId ="'.$connected_user_id.'"';
      $update_result = mysqli_query($conn, $sql_update);

      $_SESSION['username'] = $_POST['new_username'];

    }
  }

  echo json_encode($users_act_array);
?>

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

  $error=false;
  if(isset($_POST['save']) && $_POST['save']=='true'){
    if($_POST['new_name']!=$users_act_array[0] || $_POST['new_surname']!=$users_act_array[1] ||  $_POST['new_username']!=$users_act_array[2]){
      $user_id_query = "SELECT userID FROM user WHERE username = '". $_SESSION['username'] . "'";
      $connected_user_id_result = mysqli_query($conn, $user_id_query);
      while ($row = mysqli_fetch_assoc($connected_user_id_result)) {
        $connected_user_id = sprintf($row['userID']);
      }
      $error=0;//υπάρχει αλλαγή
      $duplicate_username_query = "SELECT count(username) FROM user WHERE username = '". $_POST['new_username'] . "'";
      $duplicate_username_result = mysqli_query($conn, $duplicate_username_query);
      while ($number_of_users = mysqli_fetch_row($duplicate_username_result)) {
        $duplicate_username_number = $number_of_users[0];
    }
      if($duplicate_username_number == 0) {
        if($_SESSION['username'] == 'admin') {
          $_POST['new_username'] ='admin';
          $error = 3;
        }
        $sql_update='UPDATE user SET name="'.$_POST['new_name'].'", surname="'.$_POST['new_surname'].'",username="'.$_POST['new_username'].'" WHERE userId ="'.$connected_user_id.'"';
        $update_result = mysqli_query($conn, $sql_update);
        $_SESSION['username'] = $_POST['new_username'];
      }
      else {
        $error=4;
      }
      echo json_encode(array('result1'=>null,'result2'=>array($error)));
    }
    elseif ($_POST['new_name']==$users_act_array[0] && $_POST['new_surname']==$users_act_array[1] &&  $_POST['new_username']==$users_act_array[2]) {
      $error=1;//δεν υπάρχει αλλαγή
      echo json_encode(array('result1'=>null,'result2'=>array($error)));
    }else{
      $error=2;// πρόβλημα
      echo json_encode(array('result1'=>null,'result2'=>array($error)));
    }

  }else{
  echo json_encode(array('result1'=>$users_act_array,'result2'=>null));}
?>

<?php
  require 'dbconnect.php';

  $user_activity = "DELETE FROM user_activity";
  $result_1 = mysqli_query($conn,$user_activity);

  $delete_user_map_data = "DELETE FROM usermapdata";
  $result_2 = mysqli_query($conn,$delete_user_map_data);

  $delete_uploaded_by_user = "DELETE FROM uploaded_by_user";
  $result_3 = mysqli_query($conn,$delete_uploaded_by_user);

  // $delete_user = "DELETE FROM user";
  // $result_4 = mysqli_query($conn,$delete_user);

  if(mysqli_affected_rows($conn)>0){
    echo "Success";
  }
  else{
    echo "Fail";
  }
?>

<?php
  require 'dbconnect.php';
  $sql = "describe user_activity";
  $activity = mysqli_query($conn,$sql);
  $actarray = array();
  $k=0;
  while($row = mysqli_fetch_assoc($activity)){
    if($row['Field'] != 'userMapData_userId' && $row['Field'] != 'userMapData_timestampMs' && $row['Field'] != 'activity_timestamp' && $row['Field'] != 'eco'){
      array_push($actarray, $row['Field']); // row field εχει το activity
      $k++;
    }
  }
  echo json_encode(array($actarray));
?>

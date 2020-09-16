<?php
  require 'dbconnect.php';
  session_start();
  $user_id_query = "SELECT userID FROM user WHERE username = '". $_SESSION['username']."'";
  $connected_user_id_result = mysqli_query($conn, $user_id_query);
  while ($row = mysqli_fetch_assoc($connected_user_id_result)) {
    $connected_user_id = sprintf($row['userID']);
  }

  $nowtime = intval(sprintf('%d000',time()));
  $this_months_sec = time() - strtotime("1-".(date("m-Y",time())));

  $all_user_activities_query = sprintf("SELECT  count(activity_timestamp) FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp)/1000 < $this_months_sec", mysqli_real_escape_string($conn,$connected_user_id));
  $eco_user_activities_query = sprintf("SELECT count(activity_timestamp) FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp)/1000 < $this_months_sec AND eco = 1", mysqli_real_escape_string($conn,$connected_user_id));

  $all_user_activities_result = mysqli_query($conn, $all_user_activities_query);
  if(!$all_user_activities_result){
    exit();
  }
  $eco_user_activities_result = mysqli_query($conn, $eco_user_activities_query);
  if(!$eco_user_activities_result){
    exit();
  }

  while ($row = mysqli_fetch_assoc($all_user_activities_result)) {
    $all_user_activities = ($row['count(activity_timestamp)'])/1000;
  }
  while ($row = mysqli_fetch_assoc($eco_user_activities_result)) {
    $eco_user_activities = ($row['count(activity_timestamp)'])/1000;
  }

  if($all_user_activities != 0){
    $connected_user_score=round(($eco_user_activities/$all_user_activities)*100,2);
  }
  else{
    $connected_user_score = 0;
  }
  $current_month=date('F',time());

  echo json_encode(array($current_month, $connected_user_score));

?>

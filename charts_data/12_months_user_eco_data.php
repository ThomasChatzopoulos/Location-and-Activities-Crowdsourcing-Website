<?php
  require '../dbconnect.php';
  require 'set_colours.php';
  session_start();

  //------------------------------------------------ 1st query - eco user ------------------------------------------------
  $user_id_query = "SELECT userID FROM user WHERE username = '". $_SESSION['username'] . "'";
  $connected_user_id_result = mysqli_query($conn, $user_id_query);
  while ($row = mysqli_fetch_assoc($connected_user_id_result)) {
    $connected_user_id = sprintf($row['userID']);
  }
  $nowtime = intval(sprintf('%d000',time()));

  $previus_months_sec = time() - strtotime("1-".(date("m",time())+1)."-".(date("Y",time())-1)); //sec for (11 months + this month days) before today
  // $previus_months_sec =1576800000;

  $all_user_activities_query = sprintf("SELECT activity_timestamp FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp)/1000 < $previus_months_sec", mysqli_real_escape_string($conn,$connected_user_id));
  $eco_user_activities_query = sprintf("SELECT activity_timestamp FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp)/1000 < $previus_months_sec AND eco = 1", mysqli_real_escape_string($conn,$connected_user_id));

  $all_user_activities_result = mysqli_query($conn, $all_user_activities_query);
  if(!$all_user_activities_result){
    exit();
  }
  $eco_user_activities_result = mysqli_query($conn, $eco_user_activities_query);
  if(!$eco_user_activities_result){
    exit();
  }

  while ($row = mysqli_fetch_assoc($all_user_activities_result)) {
    $all_user_activities_timestamps[] = ($row['activity_timestamp'])/1000;
  }
  while ($row = mysqli_fetch_assoc($eco_user_activities_result)) {
    $eco_user_activities_timestamps[] = ($row['activity_timestamp'])/1000;
  }

  if(isset($all_user_activities_timestamps) && isset($eco_user_activities_timestamps)){
    $months_counter = 0;
    $eco_months_counter = 0;
    foreach ($all_user_activities_timestamps as $key => $value) {
      $month=date("F", $value);
      if(!isset($months[$month])) {
        $months[$month] = 1;
        $months_counter += 1;
      }
      else {
        $months[$month] += 1;
        $months_counter += 1;
      }
    }
    foreach ($eco_user_activities_timestamps as $key => $value) {
      $month=date("F", $value);
      if(!isset($eco_months[$month])) {
        $eco_months[$month] = 1;
        $eco_months_counter += 1;
      }
      else {
        $eco_months[$month] += 1;
        $eco_months_counter += 1;
      }
    }

    foreach ($months as $key => $value) {
      $user_score[$key]=round(($eco_months[$key]/$months[$key])*100,2);
    }
    if(isset($user[date("m",time())])){
      $this_month_score = $user[date("m",time())];
    }
    else{
      $this_month_score = 0;
    }
    arsort($user_score);
    // echo "<br>";
    // print_r($user_score);
    $colours_months = set_Chart_colours($user_score);
  }else{
    $user_score[date("F",time())]=0;
    $colours_months=set_Chart_colours($user_score);
  }

  echo json_encode(array($user_score, $colours_months, $user_score));
?>

<?php
  session_start();

  require 'dbconnect.php';

  //------------------------------------------------ 1st query - eco user ------------------------------------------------
  // $user_id_query = "SELECT userID FROM user WHERE username = ".$_SESSION['usrname'];
  // $connected_user_id = mysqli_query($conn, $user_id_query);
  $connected_user_id="NrUHgXA/37ELuiUT6jgsPHZjNjVuRG1kMjhKZlY5ZFl3bll2NVE9PQ==";

  $nowtime= intval(sprintf('%d03',time()));
  $all_user_activities_query = sprintf("SELECT COUNT(eco) FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp) < 26280000", mysqli_real_escape_string($conn,$connected_user_id));
  $eco_user_activities_query = sprintf("SELECT COUNT(eco) FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp) < 26280000 AND eco = 1", mysqli_real_escape_string($conn,$connected_user_id));

  $all_user_activities_result = mysqli_query($conn, $all_user_activities_query);
  if(!$all_user_activities_result){
    exit();
  }
  $eco_user_activities_result = mysqli_query($conn, $eco_user_activities_query);
  if(!$eco_user_activities_result){
    exit();
  }

  while ($row = mysqli_fetch_assoc($all_user_activities_result)) {
    $all_user_activities=$row['COUNT(eco)'];
  }
  while ($row = mysqli_fetch_assoc($eco_user_activities_result)) {
    $eco_user_activities=$row['COUNT(eco)'];
  }

  $eco_user_score = round($eco_user_activities/$all_user_activities,4);
  echo "Your score: " , $eco_user_score*100, "%<br>";

//------------------------------------------------ 2nd query - record range ------------------------------------------------
  $min_map = sprintf("SELECT MIN(timestampMs) FROM userMapData WHERE userId = '%s'",
  mysqli_real_escape_string($conn, $connected_user_id));

  $min_map_result = mysqli_query($conn, $min_map); // for min date
  if(!$min_map_result){
    echo "SQL error <br>";
    exit();
  }

  while ($row = mysqli_fetch_assoc($min_map_result)) {
    $min_user_timestamp = date("Y.m.d h:i:sa", ($row['MIN(timestampMs)'])/1000);
  }

  $max_map = sprintf("SELECT MAX(timestampMs) FROM userMapData WHERE userId = '%s'",
  mysqli_real_escape_string($conn,$connected_user_id));

  $max_map_result = mysqli_query($conn, $max_map); // for max date
  if(!$max_map_result){
    echo "SQL error <br>";
    exit();
  }
  while ($row = mysqli_fetch_assoc($max_map_result)) {
    $max_user_timestamp = date("Y.m.d h:i:sa", ($row['MAX(timestampMs)'])/1000);
  }

  echo "First record: " , $min_user_timestamp ,"<br>";
  echo "Last record: " , $max_user_timestamp ,"<br>";

//------------------------------------------------ 3rd query - last upload ------------------------------------------------
  $last_upload_date_query = sprintf("SELECT MAX(uploadTime) FROM uploaded_by_user WHERE userId = '%s'", mysqli_real_escape_string($conn, $connected_user_id));
  $last_upload_date_result = mysqli_query($conn, $last_upload_date_query); // for max upload date
  if(!$last_upload_date_result){
    echo "SQL error <br>";
    exit();
  }
  while ($row = mysqli_fetch_assoc($last_upload_date_result)) {
    $last_upload_date=$row['MAX(uploadTime)'];
  }
  echo "Last upload:",$last_upload_date ,"<br>" ;

//------------------------------------------------ 4th query - top 3 for last month ------------------------------------------------
  $number_of_users_act_query = sprintf("SELECT COUNT(eco), userMapData_userId FROM user_activity
  WHERE ($nowtime - activity_timestamp) < 26280000 GROUP BY userMapData_userId");
  $number_of_users_eco_act_query = sprintf("SELECT COUNT(eco) FROM user_activity
  WHERE eco=1 AND ($nowtime - activity_timestamp) < 26280000 GROUP BY userMapData_userId");

  $number_of_users_act_results = mysqli_query($conn, $number_of_users_act_query);
  if(!$number_of_users_act_results){
    echo "SQL error <br>";
    exit();
  }
  $number_of_users_eco_act_result = mysqli_query($conn, $number_of_users_eco_act_query);
  if(!$number_of_users_eco_act_result){
    echo "SQL error <br>";
    exit();
  }

  while ($row = mysqli_fetch_assoc($number_of_users_act_results)) {
      $users_act_array[$row['userMapData_userId']]=$row['COUNT(eco)']; //$users_act_array[]: $key: userId, $value: number of user registrations
  }

  while ($row = mysqli_fetch_assoc($number_of_users_eco_act_result)) {
      $users_eco_act_array[]=$row['COUNT(eco)'];  //$users_eco_act_array[]: $key: increasing numbering, $value: number of eco user registrations
  }

  $counter=0;
  foreach ($users_act_array as $key => $value) {
    $temp_top_users[$key] = $users_eco_act_array[$counter]/$value; // $temp_top_users[]: $key: userId, $value: eco percent
    $counter++;
  }

  arsort($temp_top_users);

  $top_users = array_slice($temp_top_users,0,3);
  $is_in_top = false;
  foreach ($top_users as $key => $value) { // check if user is in top 3
    if($key==$connected_user_id){
      $is_in_top = true;
    }
  }
  if($is_in_top==true){
    $top_users = array_slice($temp_top_users,0,4);
  }
  else if($is_in_top==false){
    $top_users+=[$connected_user_id=>$eco_user_score];
  }

  arsort($top_users);

  foreach ($top_users as $key => $value) { //get name and surname
    $top_users_query = sprintf("SELECT name, surname FROM user WHERE userId = '$key'");
    $top_users_result = mysqli_query($conn, $top_users_query);
    if(!$top_users_result){
      echo "SQL error <br>";
      exit();
    }
    while ($row = mysqli_fetch_assoc($top_users_result)) {
      $user_names[] = sprintf($row['name']." ". substr($row['surname'],0,1));
    }
  }

  echo "Top 3 users and you:<br>";
  $counter=0;
  foreach ($top_users as $key => $value) {
    echo $user_names[$counter]," score: ", round($value*100,2), "%<br>";
    $counter++;
  }
?>

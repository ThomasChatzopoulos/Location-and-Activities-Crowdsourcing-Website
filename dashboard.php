<?php
  require 'dbconnect.php';


//---------------------------------------------------Query 1a ---------------------------------------------------
  $user_activity_table_columns_query = "SHOW COLUMNS FROM user_activity";

  $user_activity_table_columns_result = mysqli_query($conn, $user_activity_table_columns_query);

  if(!$user_activity_table_columns_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($user_activity_table_columns_result)) {
    if($row['Field']!= "userMapData_userId" && $row['Field']!= "userMapData_timestampMs" && $row['Field']!= "activity_timestamp" && $row['Field']!= "eco"){
      $activity_type[$row['Field']] = 0;
    }
  }
$counter = 0;
foreach ($activity_type as $key => $value) {
  $query = sprintf("SELECT COUNT(%s) from user_activity", mysqli_real_escape_string($conn, $key));
  $result = mysqli_query($conn, $query);

  if(!$result){
    exit();
  }
  while ($row = mysqli_fetch_row($result)) {
    $activity_type[$key] = $row[0];
    $counter += $row[0];
  }
}
//distr of all activity types
foreach ($activity_type as $key_1 => $value_1) {
  $activity_type[$key_1] = round(($activity_type[$key_1]/$counter)*100,3);
}
//print_r($activity_type);



// ---------------------------------------------------Query 1b ---------------------------------------------------
  $users_records_query = "SELECT userId, COUNT(userId) FROM userMapData GROUP BY userId";
  $users_records_result = mysqli_query($conn, $users_records_query);

  if(!$users_records_result){
    exit();
  }
  $counter_u = 0;
  while ($row = mysqli_fetch_assoc($users_records_result)) {
    $query = sprintf("SELECT `username` FROM `user` WHERE userId = '%s'",
    mysqli_real_escape_string($conn, $row['userId']));

    $result = mysqli_query($conn, $query);

    while ($row_2 = mysqli_fetch_assoc($result)) {
      $username = $row_2['username'];
    }
    $record_per_user[$username] = $row['COUNT(userId)'];
    $counter_u += $row['COUNT(userId)'];
  }

foreach ($record_per_user as $key => $value) {
  $record_per_user[$key] = round(($record_per_user[$key]/$counter_u)*100,3);
}
//print_r($record_per_user);


// ---------------------------------------------------Query 1c & 1d & 1e & 1f---------------------------------------------------
  $timestamps_user_query = "SELECT timestampMs FROM userMapData";
  $timestamps_user_result = mysqli_query($conn, $timestamps_user_query);

  if(!$timestamps_user_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($timestamps_user_result)) {
    $timestamps[] = ($row['timestampMs'])/1000;
  }
// IF WE DECIDE TO INCLUDE DATA FROM ACTIVITY TAB
  // $timestamps_activity_query = "SELECT userMapData_timestampMs FROM user_activity";
  // $timestamps_activity_result = mysqli_query($conn, $timestamps_activity_query);
  //
  // if(!$timestamps_activity_result){
  //   exit();
  // }
  // while ($row = mysqli_fetch_assoc($timestamps_activity_result)) {
  //   $timestamps[] = ($row['userMapData_timestampMs'])/1000;
  // }

  //print_r($timestamps);

$days_counter = 0;
$hours_counter = 0;
$months_counter = 0;
$years_counter = 0;

    foreach ($timestamps as $key => $value) {
      $hour=date("G",$value);
      $day=date("l", $value);
      $month=date("F", $value);
      $year=date("Y", $value);

//compute distr for days
      if(!isset($days[$day])) {
        $days[$day] = 1;
        $days_counter += 1;
      }
      else {
        $days[$day] += 1;
        $days_counter += 1;
      }
//compute distr for hours

      if(!isset($hours[$hour])) {
        $hours[$hour] = 1;
        $hours_counter += 1;
      }
      else {
        $hours[$hour] += 1;
        $hours_counter += 1;
      }
//compute distr for months

      if(!isset($months[$month])) {
        $months[$month] = 1;
        $months_counter += 1;
      }
      else {
        $months[$month] += 1;
        $months_counter += 1;
      }
//compute distr for months

      if(!isset($years[$year])) {
        $years[$year] = 1;
        $years_counter += 1;
      }
      else {
        $years[$year] += 1;
        $years_counter = 1;
      }
    }
// echo "<br>";
// print_r($days);
// echo "<br>";
// print_r($hours);
// echo "<br>";
// print_r($months);
// echo "<br>";
// print_r($years);

foreach ($days as $key => $value) {
  $days[$key] = round(($days[$key]/$days_counter)*100,3);
}
foreach ($hours as $key => $value) {
  $hours[$key] = round(($hours[$key]/$hours_counter)*100,3);
}
foreach ($months as $key => $value) {
  $months[$key] = round(($months[$key]/$months_counter)*100,3);
}
foreach ($years as $key => $value) {
  $years[$key] = round(($years[$key]/$years_counter)*100,3);
}
// echo "<br>";
// print_r($days);
// echo "<br>";
// print_r($hours);
// echo "<br>";
// print_r($months);
// echo "<br>";
// print_r($years);
 ?>

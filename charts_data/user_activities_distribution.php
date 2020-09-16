<?php
  function analyzeActivitiesPersentage($timestamps){
    require (dirname(dirname(__FILE__)) . '/dbconnect.php');
    require 'set_colours.php';

    session_start();
    $user_id_query = 'SELECT userID FROM user WHERE username = "'.$_SESSION['username'].'"';
    $connected_user_id_r = mysqli_query($conn, $user_id_query);

    while ($row = mysqli_fetch_row($connected_user_id_r)) {
      $connected_user_id=$row[0];
    }

    $activity_type=array();
    $colours_act=array();
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
      for($i=0; $i<count($timestamps); $i+=2){
        $ts1 = $timestamps[$i];
        $ts2 = $timestamps[$i+1];
        $query = sprintf("SELECT count(%s) FROM user_activity WHERE (userMapData_userId='%s') AND (activity_timestamp BETWEEN $ts1 AND $ts2)",mysqli_real_escape_string($conn, $key), mysqli_real_escape_string($conn, $connected_user_id));
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)==0){
        }
        else{
          while ($row = mysqli_fetch_row($result)) {
            $activity_type[$key] += $row[0];
            $counter += $row[0];
          }
        }
      }
    }
    if($counter!=0){
      arsort($activity_type);
      foreach ($activity_type as $key_1 => $value_1) {
        $activity_type[$key_1] = round(($activity_type[$key_1]/$counter)*100,2);//TODO: αν βγαίνει 99,9- ή 100,01+
      }
      $colours_act = set_Chart_colours($activity_type);

      return array($activity_type, $colours_act, $activity_type);
    }else{
      return false;
    }
  }
?>

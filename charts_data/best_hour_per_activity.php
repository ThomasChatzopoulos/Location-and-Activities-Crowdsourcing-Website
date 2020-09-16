<?php
  function findBestHour($timestamps){
    require (dirname(dirname(__FILE__)) . '/dbconnect.php');

    $user_id_query = 'SELECT userID FROM user WHERE username = "'.$_SESSION['username'].'"';
    $connected_user_id_r = mysqli_query($conn, $user_id_query);

    while ($row = mysqli_fetch_row($connected_user_id_r)) {
      $connected_user_id=$row[0];
    }

    $user_activity_table_columns_query = "SHOW COLUMNS FROM user_activity";
    $user_activity_table_columns_result = mysqli_query($conn, $user_activity_table_columns_query);

    if(!$user_activity_table_columns_result){
      exit();
    }
    $result_timestamps=[];
    $activities_table=[];

    while ($row = mysqli_fetch_assoc($user_activity_table_columns_result)) {
      if($row['Field']!= "userMapData_userId" && $row['Field']!= "userMapData_timestampMs" && $row['Field']!= "activity_timestamp" && $row['Field']!= "eco"){
        $activity_type [$row['Field']] = 0;
      }
    }
    foreach ($activity_type as $key => $value) {
      $hours=[];
      for($i=0; $i<count($timestamps); $i+=2){
        $ts1 = $timestamps[$i];
        $ts2 = $timestamps[$i+1];
        $query = sprintf("SELECT activity_timestamp FROM user_activity WHERE (userMapData_userId='%s') AND (activity_timestamp BETWEEN $ts1 AND $ts2) AND $key IS NOT NULL", mysqli_real_escape_string($conn, $connected_user_id));
        $result = mysqli_query($conn, $query);

        if(!$result){
          echo "\nNo results\n";
          exit();
        }

        while ($row = mysqli_fetch_row($result)) {
          $hour=date("H",round(($row[0])/1000));
          if(!isset($hours[$hour])) {
            $hours[$hour] = 1;
          }
          else {
            $hours[$hour] += 1;
          }
        }
        if(!empty($hours)){
          $max= array_search(max($hours),$hours);
          $activity_type[$key]=$max;
        }
        else{
          $activity_type[$key]="-";
        }
      }
    }
    return $activity_type;
  }
?>

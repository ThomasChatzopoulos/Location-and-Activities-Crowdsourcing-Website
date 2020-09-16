<?php
  require 'dbconnect.php';
  require_once("vendor/autoload.php");
  set_time_limit(0);
  ini_set('memory_limit', '-1');

  session_start();
  $user_id_query = 'SELECT userID FROM user WHERE username = "'.$_SESSION['username'].'"';
  $connected_user_id_r = mysqli_query($conn, $user_id_query);

  while ($row = mysqli_fetch_row($connected_user_id_r)) {
    $userId=$row[0];
  }

  $duplicate_data = false;
  include 'ray_casting_algo.php';
  $lat1=38.230462;
  $lng1=21.753150;
  $distance = 10;
  $mysql_timestamp = date ("Y-m-d H:i:s");
  $filename = "files_for_upload/".$_POST['last_uploaded_file_name'];

  $query = sprintf("INSERT INTO `uploaded_by_user` (jsonFIleName, uploadTime, userId) VALUES ('%s', '%s', '%s')",
  mysqli_real_escape_string($conn, $filename), mysqli_real_escape_string($conn, $mysql_timestamp), mysqli_real_escape_string($conn, $userId));

  $result = mysqli_query($conn, $query);
  if (!$result) {
      $message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
      $message .= 'Whole query: ' . $query;
      die($message);
  }
  //$data = file_get_contents($filename); //Read the JSON file in PHP
  //$json_obj = json_decode($data, true); //Convert JSON String into PHP Array
  $json_obj = \JsonMachine\JsonMachine::fromFile($filename);

  foreach ($json_obj as $key1 => $value1) {
    $locations = $value1;
    foreach ($locations as $key2 => $value2) {
      $lat2 = $value2["latitudeE7"]/10**7;
      $lng2 = $value2["longitudeE7"]/10**7;
      $timestampMS = $value2["timestampMs"];

      $f_distance = distance($lat1, $lng1, $lat2, $lng2);

      $coordinates_array = json_decode(stripslashes($_POST['coordinates_string']));
      $sensitive = false;
      $coordinates_array = json_decode(json_encode($coordinates_array), true);
      if(!empty($coordinates_array)) {
        foreach ($coordinates_array as $array_1 => $bounds) {
          if(contains($bounds, $lat2, $lng2)) {
            $sensitive = true;
            break;
          }
        }
      }
      //if the coordinates are in the 10km circle and not in the sensitive data
      if($f_distance <= $distance && !$sensitive){
        $lat2 = $value2["latitudeE7"];
        $lng2 = $value2["longitudeE7"];
        $accuracy = $value2["accuracy"];
        $velocity = 'NULL';
        $heading = 'NULL';
        $altitude = 'NULL';
        $vertical_accuracy = 'NULL';
        if(array_key_exists("altitude",$value2)){
          $altitude = $value2["altitude"];
        }
        if(array_key_exists("heading",$value2)){
          $heading = $value2["heading"];
        }
        if(array_key_exists("velocity",$value2)){
          $velocity = $value2["velocity"];
        }
        if(array_key_exists("verticalAccuracy",$value2)){
          $vertical_accuracy = $value2["verticalAccuracy"];
        }
        insert_location($userId, $timestampMS, $lat2, $lng2, $accuracy, $velocity, $heading, $altitude, $vertical_accuracy, $conn);

        if(array_key_exists("activity",$value2)){  //check if there is an activity specified
          $activity_type_string = '';
          $activity_confidence_string = '';
          $activity = $value2["activity"];
          foreach ($activity as $key3) {
            $activity_timestamp = $key3["timestampMs"];
            foreach ($key3["activity"] as $key4) {
              $activity_type = $key4["type"];
              $confidence = $key4["confidence"];
              if(empty($activity_type_string)){
                $activity_type_string = $activity_type;
                $activity_confidence_string = $confidence;
              }
              else {
                $activity_type_string = $activity_type_string . ", ". $activity_type;
                $activity_confidence_string = $activity_confidence_string . ", ". $confidence;
              }
            }
                insert_activity($userId, $activity_type_string, $timestampMS, $activity_timestamp, $activity_confidence_string, $conn);
                $activity_type_string = '';
                $activity_confidence_string = '';
            }
          }
        }
      }
    }
    unset($json_obj);
    unlink($filename);
    echo json_encode($GLOBALS['duplicate_data']);


  function insert_location($userId, $timestampMS, $latitude, $longtitude, $accuracy, $velocity, $heading, $altitude, $vertical_accuracy, $conn){
    $query_il = sprintf("INSERT INTO `usermapdata` (userId, timestampMs, latitude, longitude, accuracy, velocity, heading, altitude, verticalAccuracy)
    VALUES ('%s', '%s', '%s', '%s', '%s', %s, %s, %s, %s)",
    mysqli_real_escape_string($conn, $userId),mysqli_real_escape_string($conn, $timestampMS), mysqli_real_escape_string($conn, $latitude), mysqli_real_escape_string($conn, $longtitude),
    mysqli_real_escape_string($conn, $accuracy),mysqli_real_escape_string($conn, $velocity), mysqli_real_escape_string($conn, $heading), mysqli_real_escape_string($conn, $altitude),
    mysqli_real_escape_string($conn, $vertical_accuracy));
    //echo "<br>";
    $result_i = mysqli_query($conn, $query_il);
    if(!$result_i && ! $GLOBALS['duplicate_data']) {
      $GLOBALS['duplicate_data'] = true;
    }
  }

  // inseret activity in the user_activity table
  function insert_activity($userId, $activity_type_string, $timestampMS, $activity_timestamp, $activity_confidence_string, $conn) {
    $activity_array = preg_split("/\, /", $activity_type_string);
    foreach ($activity_array as $activity_type) {
      $check_if_column_exists = mysqli_query($conn, "SHOW COLUMNS FROM user_activity LIKE '$activity_type'");
      $column_exists = (mysqli_num_rows($check_if_column_exists))?TRUE:FALSE;
      if($column_exists != 1){
        $alter_query = "ALTER TABLE `user_activity` ADD `$activity_type` INT(11) NULL DEFAULT NULL";

        $result = mysqli_query($conn, $alter_query);

        if(!$result && ! $GLOBALS['duplicate_data']) {
          $GLOBALS['duplicate_data'] = true;
        }
      }
    }
    $query_i = sprintf("INSERT INTO `user_activity` (userMapData_userId, userMapData_timestampMs, activity_timestamp, %s) VALUES ('%s', '%s', '%s', %s)",
    mysqli_real_escape_string($conn, $activity_type_string),mysqli_real_escape_string($conn, $userId), mysqli_real_escape_string($conn, $timestampMS), mysqli_real_escape_string($conn, $activity_timestamp),
    mysqli_real_escape_string($conn, $activity_confidence_string));

    $result_i = mysqli_query($conn, $query_i); 

    if(!$result_i && !$GLOBALS['duplicate_data']) {
      $GLOBALS['duplicate_data'] = true;
    }
  }

  function distance($lat1, $lng1, $lat2, $lng2) {
      // convert latitude/longitude degrees for both coordinates
      // to radians: radian = degree * π / 180
      $lat1 = deg2rad($lat1);
      $lng1 = deg2rad($lng1);
      $lat2 = deg2rad($lat2);
      $lng2 = deg2rad($lng2);

      // calculate great-circle distance
      $distance = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lng1 - $lng2));

      // distance in human-readable format:
      // earth's radius in km = ~6371
      return 6371 * $distance;
  }
?>

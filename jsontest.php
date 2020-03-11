<?php
require 'dbconnect.php';
require_once("vendor/autoload.php");

$lat1=38.230462;
$lng1=21.753150;
$distance = 10;
$mysql_timestamp = date ("Y-m-d H:i:s");
//file name from starting page
$filename = "data.json";
$userId = "WmdUlzEQH197+N7AWPy4VmlsOUVTaHBvdTVpbGNxVXZUdG9XS3c9PQ==";
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
//print_r($json_obj);
foreach ($json_obj as $key1 => $value1) {
  $locations = $value1;
  foreach ($locations as $key2 => $value2) {
    $lat2 = $value2["latitudeE7"]/10**7;
    $lng2 = $value2["longitudeE7"]/10**7;
    $timestampMS = $value2["timestampMs"];

    $f_distance = distance($lat1, $lng1, $lat2, $lng2);
    //if coordinates are in the 10km circle
    if($f_distance <= $distance){
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

    //print_r($json_obj[$key1][$key2]);

function insert_location($userId, $timestampMS, $latitude, $longtitude, $accuracy, $velocity, $heading, $altitude, $vertical_accuracy, $conn){
  $query_il = sprintf("INSERT INTO `usermapdata` (userId, timestampMs, latitude, longitude, accuracy, velocity, heading, altitude, verticalAccuracy)
  VALUES ('%s', '%s', '%s', '%s', '%s', %s, %s, %s, %s)",
  mysqli_real_escape_string($conn, $userId),mysqli_real_escape_string($conn, $timestampMS), mysqli_real_escape_string($conn, $latitude), mysqli_real_escape_string($conn, $longtitude),
  mysqli_real_escape_string($conn, $accuracy),mysqli_real_escape_string($conn, $velocity), mysqli_real_escape_string($conn, $heading), mysqli_real_escape_string($conn, $altitude),
  mysqli_real_escape_string($conn, $vertical_accuracy));
  //echo "<br>";
  $result_i = mysqli_query($conn, $query_il)or die(mysqli_error($conn));

}

// inseret activity in the user_activity table
function insert_activity($userId, $activity_type_string, $timestampMS, $activity_timestamp, $activity_confidence_string, $conn) {
  $activity_array = preg_split("/\, /", $activity_type_string);
  foreach ($activity_array as $activity_type) {
    $check_if_column_exists = mysqli_query($conn, "SHOW COLUMNS FROM user_activity LIKE '$activity_type'"); //if column exists => $check_if_column_exists=1
    $column_exists = (mysqli_num_rows($check_if_column_exists))?TRUE:FALSE;
    if($column_exists != 1){
      $alter_query = "ALTER TABLE `user_activity` ADD `$activity_type` INT(11) NULL DEFAULT NULL";
      //echo $alter_query;
      //echo "<br>";
      $result = mysqli_query($conn, $alter_query) or die(mysqli_error($conn));
    }
  }
  $query_i = sprintf("INSERT INTO `user_activity` (userMapData_userId, userMapData_timestampMs, activity_timestamp, %s) VALUES ('%s', '%s', '%s', %s)",
  mysqli_real_escape_string($conn, $activity_type_string),mysqli_real_escape_string($conn, $userId), mysqli_real_escape_string($conn, $timestampMS), mysqli_real_escape_string($conn, $activity_timestamp),
  mysqli_real_escape_string($conn, $activity_confidence_string));
  //echo $query_i;
  //echo "<br>";
  //echo "<br>";
  $result_i = mysqli_query($conn, $query_i)or die(mysqli_error($conn));
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

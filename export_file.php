<?php
require 'dbconnect.php';

$start_time = 1463808157177;
$end_time = 1575968451755;

$query = sprintf("SELECT heading, velocity, accuracy, longitude, latitude, altitude, timestampMs, userId FROM `usermapdata`
WHERE timestampMs BETWEEN '%s' AND '%s'", mysqli_real_escape_string($conn, $start_time),
mysqli_real_escape_string($conn, $end_time));

 $result = mysqli_query($conn, $query);
 if (!$result) {
     $message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
     $message .= 'Whole query: ' . $query;
     die($message);
 }
 if (mysqli_num_rows($result) == 0) {
    exit;
}
$export_array = array();
while ($row = mysqli_fetch_assoc($result)) {
  $userId = $row['userId'];
  unset($row['userId']);
  $row = add_activity_info($row, $conn);
  $row['userId'] = $userId;
  array_push($export_array, $row);
}
$export_type = 'xml';

switch ($export_type) {
  case 'json':
    $json_file = json_encode($export_array);
    $fp = fopen('json_data.json', 'w');
    fwrite($fp, $json_file);
    fclose($fp);
    break;
  case 'xml':
    $xml = arrayToXml($export_array);
    print $xml->asXML('xml_data.xml');
    break;
  case 'csv':
  $fp = fopen('file.csv', 'w');
  foreach ($export_array as $fields) {
    fputcsv($fp, $fields);
  }
  fclose($fp);
  break;
}


function add_activity_info($row, $conn) {
  $query_2 = sprintf("SELECT * FROM `user_activity` WHERE userMapData_timestampMs = '%s'",
  mysqli_real_escape_string($conn, $row["timestampMs"]));
  $result_2 = mysqli_query($conn, $query_2);

  if (mysqli_num_rows($result_2) == 0) {
    return $row;
  }

  while ($row_2 = mysqli_fetch_assoc($result_2)) {
    foreach ($row_2 as $key => $value) {
      if($key == 'userMapData_timestampMs' || $key == 'userMapData_userId'){
        unset($row_2[$key]);
      }
    }
    //$row_2 += $userId;
    $final_array=array_merge($row, $row_2);
    return $final_array;
  }
}

function arrayToXml($array, $rootElement = null, $xml = null) {
    $_xml = $xml;

    // If there is no Root Element then insert root
    if ($_xml === null) {
        $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
    }

    // Visit all key value pair
    foreach ($array as $k => $v) {

        // If there is nested array then
        if (is_array($v)) {

            // Call function for nested array
            arrayToXml($v, $k, $_xml->addChild($k));
            }

        else {

            // Simply add child element.
            $_xml->addChild($k, $v);
        }
    }

    return $_xml;
}
?>

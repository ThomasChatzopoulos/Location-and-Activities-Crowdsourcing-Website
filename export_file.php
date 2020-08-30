<?php
require 'dbconnect.php';

function export_data($export_array, $export_type) {
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
  return "SUCCESS";
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

<?php
function heatmapdata($timestamps)
{

  require 'dbconnect.php';
  $data_array = array();
  for($i=0; $i<count($timestamps); $i+=2){
    $start_time = $timestamps[$i];
    $end_time = $timestamps[$i+1];

    $query = sprintf("SELECT timestampMs, latitude, longitude from usermapdata
    WHERE timestampMs BETWEEN '%s' AND '%s'", mysqli_real_escape_string($conn, $start_time),
    mysqli_real_escape_string($conn, $end_time));
    $result = mysqli_query($conn, $query);
    if (!$result) {
        $message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
    if (mysqli_num_rows($result) == 0) {
       continue;
   }

   while ($row = mysqli_fetch_assoc($result)) {
     $timestamp = $row["timestampMs"];
     $row = array_map('intval', $row);
     $row["latitude"] = $row["latitude"]/10**7;
     $row["longitude"] = $row["longitude"]/10**7;
     $query_act = "SELECT count(*) FROM user_activity WHERE userMapData_timestampMs = $timestamp GROUP BY userMapData_timestampMs";
     $result_act = mysqli_query($conn, $query_act);
     if (!$result_act) {
         $message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
         $message .= 'Whole query: ' . $query_act;
         die($message);
     }
     unset($row["timestampMs"]); //remove timestamp cause we dont need it for heatmap dataPoints
     if (!mysqli_num_rows($result_act) == 0) {
       $counter = mysqli_fetch_assoc($result_act);
       foreach ($counter as $key => $value) {
         $row["count"] = $value + 2;
       }
       array_push($data_array, $row);
     }
     else {
       $row["count"] = 1;
       array_push($data_array, $row);
     }
   }
 }
  $data_points = array('max' => 3, 'data' => $data_array);
  return $data_points;
}
 ?>

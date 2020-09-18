<?php
function heatmapdata($timestamps, $activities){
  require 'dbconnect.php';
  $activities_check="";
  $data_array = array();
  $activities_check = "AND "."(";
  for ($i=0; $i < count($activities) ; $i++) {
    $activities_check.= "(".$activities[$i]. " IS NOT NULL) ";
    if($i != count($activities) -1) {
      $activities_check.="OR ";
    }
  }
  $activities_check.=")";

  $where="";
  for($i=0; $i<count($timestamps); $i+=2){
    $ts1 = $timestamps[$i];
    $ts2 = $timestamps[$i+1];
    $where.= " (timestampMs BETWEEN ". $ts1. " AND ". $ts2.") ";
    if($i<(count($timestamps)-2)){
      $where.= "OR";
    }
  }

  $query = "SELECT timestampMs, latitude, longitude from usermapdata WHERE $where";
  $result = mysqli_query($conn, $query);

  if (!$result) {
     return;
 }
  else {
   while ($row = mysqli_fetch_assoc($result)) {
     $timestamp = $row["timestampMs"];
     unset($row["timestampMs"]); //remove timestamp cause we dont need it for heatmap dataPoints
     $row = array_map('intval', $row);
     $row["latitude"] = $row["latitude"]/10**7;
     $row["longitude"] = $row["longitude"]/10**7;
     $query_act = "SELECT count(*) FROM user_activity WHERE (userMapData_timestampMs = $timestamp) $activities_check GROUP BY userMapData_timestampMs";
     $result_act = mysqli_query($conn, $query_act);

     if (mysqli_num_rows($result_act) == 0) {
     }
     else {
       $counter = mysqli_fetch_assoc($result_act);
       if (is_array($counter) || is_object($counter))
       {
         foreach ($counter as $value) {
           $row["count"] = $value + 2;
         }
       }
       array_push($data_array, $row);
     }
   }
 }

  $data_points = array('max' => 5, 'data' => $data_array);
  return $data_points;
}
 ?>

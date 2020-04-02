<?php
  require '../dbconnect.php';
  require 'set_colours.php';

  $timestamps_user_query = "SELECT timestampMs FROM userMapData";
  $timestamps_user_result = mysqli_query($conn, $timestamps_user_query);

  if(!$timestamps_user_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($timestamps_user_result)) {
    $timestamps[] = ($row['timestampMs'])/1000;
  }
  $hours_counter = 0;

    foreach ($timestamps as $key => $value) {
      $hour=date("G",$value);

  //compute distr for hours
      if(!isset($hours[$hour])) {
        $hours[$hour] = 1;
        $hours_counter += 1;
      }
      else {
        $hours[$hour] += 1;
        $hours_counter += 1;
      }
    }
  $hours_table = $hours;

  foreach ($hours as $key => $value) {
  $hours[$key] = round(($hours[$key]/$hours_counter)*100,3);
  }


  arsort($hours);
  arsort($hours_table);

  $colours_hours = set_Chart_colours($hours);

  echo json_encode(array($hours, $colours_hours, $hours_table));
?>

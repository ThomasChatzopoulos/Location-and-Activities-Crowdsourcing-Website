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
  $days_counter = 0;

    foreach ($timestamps as $key => $value) {
      $day=date("l", $value);

  //compute distr for days
      if(!isset($days[$day])) {
        $days[$day] = 1;
        $days_counter += 1;
      }
      else {
        $days[$day] += 1;
        $days_counter += 1;
      }
    }
  $days_table = $days;

  foreach ($days as $key => $value) {
  $days[$key] = round(($days[$key]/$days_counter)*100,3);
  }


  arsort($days);
  arsort($days_table);

  $colours_days = set_Chart_colours($days);

  echo json_encode(array($days, $colours_days, $days_table));
?>

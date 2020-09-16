<?php
  require '../dbconnect.php';
  require 'set_colours.php';

  $timestamps_user_query = "SELECT timestampMs FROM userMapData";
  $timestamps_user_result = mysqli_query($conn, $timestamps_user_query);

  if(mysqli_num_rows($timestamps_user_result)==0){
    exit();
  }
  else {
    while ($row = mysqli_fetch_assoc($timestamps_user_result)) {
      $timestamps[] = ($row['timestampMs'])/1000;
    }
    $months_counter = 0;

      foreach ($timestamps as $key => $value) {
        $month=date("F", $value);

    //compute distr for months
        if(!isset($months[$month])) {
          $months[$month] = 1;
          $months_counter += 1;
        }
        else {
          $months[$month] += 1;
          $months_counter += 1;
        }
      }
    $months_table = $months;

    foreach ($months as $key => $value) {
    $months[$key] = round(($months[$key]/$months_counter)*100,3);
    }


    arsort($months);
    arsort($months_table);

    $colours_months = set_Chart_colours($months);
    echo json_encode(array($months, $colours_months, $months_table));
  }
?>

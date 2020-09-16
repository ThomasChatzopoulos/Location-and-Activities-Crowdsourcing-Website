<?php
  require '../dbconnect.php';
  require 'set_colours.php';

  $timestamps_user_query = "SELECT timestampMs FROM userMapData";
  $timestamps_user_result = mysqli_query($conn, $timestamps_user_query);

  if(mysqli_num_rows($timestamps_user_result)==0){
    exit();
  }
  while ($row = mysqli_fetch_assoc($timestamps_user_result)) {
    $timestamps[] = ($row['timestampMs'])/1000;
  }
  $years_counter = 0;

    foreach ($timestamps as $key => $value) {
      $year=date("Y", $value);

  //compute distr for years
      if(!isset($years[$year])) {
        $years[$year] = 1;
        $years_counter += 1;
      }
      else {
        $years[$year] += 1;
        $years_counter += 1;
      }
    }
  $years_table = $years;

  foreach ($years as $key => $value) {
  $years[$key] = round(($years[$key]/$years_counter)*100,3);
  }


  arsort($years);
  arsort($years_table);

  $colours_years = set_Chart_colours($years);

  echo json_encode(array($years, $colours_years, $years_table));
?>

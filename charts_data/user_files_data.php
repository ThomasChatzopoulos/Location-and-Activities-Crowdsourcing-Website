<?php
  require '../dbconnect.php';
  require 'set_colours.php';

$users_records_query = "SELECT userId, COUNT(userId) FROM userMapData GROUP BY userId";
$users_records_result = mysqli_query($conn, $users_records_query);

if(mysqli_num_rows($users_records_result)==0){
  exit();
}
else {
  $counter_u = 0;
  while ($row = mysqli_fetch_assoc($users_records_result)) {
    $query = sprintf("SELECT `username` FROM `user` WHERE userId = '%s'",
    mysqli_real_escape_string($conn, $row['userId']));

    $result = mysqli_query($conn, $query);
    if(!$result) {
      exit();
    }
    while ($row_2 = mysqli_fetch_assoc($result)) {
      $username = $row_2['username'];
      $record_per_user[$username] = $row['COUNT(userId)'];
      $counter_u += $row['COUNT(userId)'];
    }
  }
  $record_per_user_table = $record_per_user;
  foreach ($record_per_user as $key => $value) {
    $record_per_user[$key] = round(($record_per_user[$key]/$counter_u)*100,3);
  }
  arsort($record_per_user);
  arsort($record_per_user_table);
  //colours for chart
  $colours_rec = set_Chart_colours($record_per_user);
  echo json_encode(array($record_per_user, $colours_rec, $record_per_user_table));
}
?>

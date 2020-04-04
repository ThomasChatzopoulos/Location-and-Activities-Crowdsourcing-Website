<?php
  require '../dbconnect.php';

  // $user_id_query = "SELECT userID FROM user WHERE username = ".$_SESSION['usrname'];
  // $connected_user_id = mysqli_query($conn, $user_id_query);
  $connected_user_id="9/TTPft2JDhUoxeoggc7xkx4am1zMG52dFUwL3cxVy9Na3huYmc9PQ==";
//------------------------------------------------ 2nd query - record range ------------------------------------------------
  $min_map = sprintf("SELECT MIN(timestampMs) FROM userMapData WHERE userId = '%s'",
  mysqli_real_escape_string($conn, $connected_user_id));

  $min_map_result = mysqli_query($conn, $min_map); // for min date
  if(!$min_map_result){
    echo "SQL error <br>";
    exit();
  }

  while ($row = mysqli_fetch_assoc($min_map_result)) {
    $first_record = date("d-m-Y h:i:s", ($row['MIN(timestampMs)'])/1000);
  }

  $max_map = sprintf("SELECT MAX(timestampMs) FROM userMapData WHERE userId = '%s'",
  mysqli_real_escape_string($conn,$connected_user_id));

  $max_map_result = mysqli_query($conn, $max_map); // for max date
  if(!$max_map_result){
    echo "SQL error <br>";
    exit();
  }
  while ($row = mysqli_fetch_assoc($max_map_result)) {
    $last_record = date("d-m-Y h:i:s", ($row['MAX(timestampMs)'])/1000);
  }

  // echo "<br>First record: " , $first_record ,"<br>";
  // echo "Last record: " , $last_record ,"<br>";

//------------------------------------------------ 3rd query - last upload ------------------------------------------------
  $last_upload_date_query = sprintf("SELECT MAX(uploadTime) FROM uploaded_by_user WHERE userId = '%s'", mysqli_real_escape_string($conn, $connected_user_id));
  $last_upload_date_result = mysqli_query($conn, $last_upload_date_query); // for max upload date
  if(!$last_upload_date_result){
    echo "SQL error <br>";
    exit();
  }
  while ($row = mysqli_fetch_assoc($last_upload_date_result)) {
    $last_upload_date=date("d-m-Y h:i:s", strtotime($row['MAX(uploadTime)']));
  }
  // echo "Last upload:",$last_upload_date ,"<br>" ;

  $file_table["First record"]=$first_record;
  $file_table["Last record"]=$last_record;
  $file_table["Last file upload"]=$last_upload_date;

  echo json_encode(array($file_table));

?>

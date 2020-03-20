<?php
  require 'dbconnect.php';

//Query 1a ------------------------------------------------------------------------------------------------------

  // $count_activities_query = sprintf("SELECT COUNT(*) FROM user_activity");
  // $count_activities_result = mysqli_query($conn, $count_activities_query);
  // if(!$count_activities_result){
  //   exit();
  // }
  // while ($row = mysqli_fetch_assoc($count_activities_result)) {
  //   $all_activities = $row['COUNT(*)'];
  // }

  $user_activity_table_columns_query = sprintf("SHOW COLUMNS FROM user_activity");
  // echo $user_activity_table_columns_query, "<br>";
  $user_activity_table_columns_result = mysqli_query($conn, $user_activity_table_columns_query);

  if(!$user_activity_table_columns_result){
    exit();
  }
  $counter=0;
  while ($row = mysqli_fetch_assoc($user_activity_table_columns_result)) {
    if($row['Field']!= "userMapData_userId" && $row['Field']!= "userMapData_timestampMs" && $row['Field']!= "activity_timestamp" && $row['Field']!= "eco"){
      $activity_table_columns[$counter][0] = $row['Field'];
      $counter++;
    }
  }

  for($x = 0; $x <= count($activity_table_columns)-1; $x++) {
    $column = $activity_table_columns[$x][0];
    $query = sprintf("SELECT COUNT($column) from user_activity");
    // echo $query,"<br>";
    $result = mysqli_query($conn, $query);

    if(!$result){
      exit();
    }
    while ($row = mysqli_fetch_assoc($result)) {
      $activity_table_columns[$x][1] = $row['COUNT('. $column .')'];
    }
  }

  $mount_of_activities=0;

  for ($x = 0; $x <= count($activity_table_columns)-1; $x++) {
    $mount_of_activities = $mount_of_activities+$activity_table_columns[$x][1];
  }

  for ($x = 0; $x <= count($activity_table_columns)-1; $x++) {
    $activity_table_columns[$x][1] = round(($activity_table_columns[$x][1]/$mount_of_activities)*100,3);
  }

  for ($x = 0; $x <= count($activity_table_columns)-1; $x++) {
    echo $activity_table_columns[$x][0], ": ";
    echo $activity_table_columns[$x][1], "<br>";
  }

// Query 1b ------------------------------------------------------------------------------------------------------
  $users_records_query = sprintf("SELECT userId, COUNT(userId) FROM userMapData GROUP BY userId");
  $users_records_result = mysqli_query($conn, $users_records_query);

  if(!$users_records_result){
    exit();
  }
  $counter=0;
  while ($row = mysqli_fetch_assoc($users_records_result)) {
    $record_per_user[$counter][0] = $row['userId'];
    $record_per_user[$counter][1] = $row['COUNT(userId)'];
    $counter++;
  }
  // for ($x = 0; $x <= count($record_per_user)-1; $x++) {
  //   echo $record_per_user[$x][0], ": value: ";
  //   echo $record_per_user[$x][1], "<br>";
  // }
  $users_activity_records_query = sprintf("SELECT userMapData_userId, COUNT(userMapData_userId) FROM user_activity GROUP BY userMapData_userId");
  $users_activity_records_result = mysqli_query($conn, $users_activity_records_query);

  if(!$users_activity_records_result){
    exit();
  }

  while ($row = mysqli_fetch_assoc($users_activity_records_result)) {
    for($x = 0; $x <= count($record_per_user)-1; $x++){
      if($record_per_user[$x][0] == $row['userMapData_userId']){
        $record_per_user[$x][1] = $record_per_user[$x][1] + $row['COUNT(userMapData_userId)'];
      }
    }
  }

  $mount_of_records = 0;
  for ($x = 0; $x <= count($record_per_user)-1; $x++) {
    $mount_of_records = $mount_of_records + $record_per_user[$x][1];
  }
  // echo "mount_of_records:", $mount_of_records,"<br>";
  for ($x = 0; $x <= count($record_per_user)-1; $x++) {
    $record_per_user[$x][1] = round(($record_per_user[$x][1]/$mount_of_records)*100,3);
  }

  for ($x = 0; $x <= count($record_per_user)-1; $x++) {
    echo $record_per_user[$x][0], " ";
    echo $record_per_user[$x][1], "<br>";
  }

//Query 1c & 1d & 1e & 1f------------------------------------------------------------------------------------------------
  $timestamps_user_query = sprintf("SELECT timestampMs FROM userMapData");
  $timestamps_user_result = mysqli_query($conn, $timestamps_user_query);

  if(!$timestamps_user_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($timestamps_user_result)) {
    $timestamps[] = ($row['timestampMs'])/1000;
  }

  $timestamps_activity_query = sprintf("SELECT userMapData_timestampMs FROM user_activity");
  $timestamps_activity_result = mysqli_query($conn, $timestamps_activity_query);

  if(!$timestamps_activity_result){
    exit();
  }
  while ($row = mysqli_fetch_assoc($timestamps_activity_result)) {
    $timestamps[] = ($row['userMapData_timestampMs'])/1000;
  }

  for($x = 0; $x <= 11; $x++){
    $hours[$x]=0;
  }

  for($x = 0; $x <= 6; $x++){
    $days[$x]=0;
  }

  for($x = 0; $x <= 11; $x++){
    $months[$x]=0;
  }

  $years[0][0]=date("Y", $timestamps[0]);
  $years[0][1]=0;

  for($x = 0; $x <= count($timestamps)-1; $x++){
    $hour=date("G",$timestamps[$x]);
    $day=date("l", $timestamps[$x]);
    $month=date("n", $timestamps[$x]);
    $year=date("Y", $timestamps[$x]);

    if($hour==0){$hours[0]++;}
    if($hour==1){$hours[1]++;}
    if($hour==2){$hours[2]++;}
    if($hour==3){$hours[3]++;}
    if($hour==4){$hours[4]++;}
    if($hour==5){$hours[5]++;}
    if($hour==6){$hours[6]++;}
    if($hour==7){$hours[7]++;}
    if($hour==8){$hours[8]++;}
    if($hour==9){$hours[9]++;}
    if($hour==10){$hours[10]++;}
    if($hour==11){$hours[11]++;}
    if($hour==12){$hours[12]++;}
    if($hour==13){$hours[13]++;}
    if($hour==14){$hours[14]++;}
    if($hour==15){$hours[15]++;}
    if($hour==16){$hours[16]++;}
    if($hour==17){$hours[17]++;}
    if($hour==18){$hours[18]++;}
    if($hour==19){$hours[19]++;}
    if($hour==20){$hours[20]++;}
    if($hour==21){$hours[21]++;}
    if($hour==22){$hours[22]++;}
    if($hour==23){$hours[23]++;}

    if($day == "Sunday"){$days[0]++;}
    if($day == "Monday"){$days[1]++;}
    if($day == "Tuesday"){$days[2]++;}
    if($day == "Wednesday"){$days[3]++;}
    if($day == "Thursday"){$days[4]++;}
    if($day == "Friday"){$days[5]++;}
    if($day == "Saturday"){$days[6]++;}

    if($month==1){$months[0]++;}
    if($month==2){$months[1]++;}
    if($month==3){$months[2]++;}
    if($month==4){$months[3]++;}
    if($month==5){$months[4]++;}
    if($month==6){$months[5]++;}
    if($month==7){$months[6]++;}
    if($month==8){$months[7]++;}
    if($month==9){$months[8]++;}
    if($month==10){$months[9]++;}
    if($month==11){$months[10]++;}
    if($month==12){$months[11]++;}

    for($y = 0; $y <= count($years)-1; $y++){
      if($year==$years[$y][0]){
        $years[$y][1]++;
        // echo $years[$y][0]," - ";
        // echo $years[$y][1],"<br>";
      }
      else{
        $years[$y][0]=$year;
        $years[$y][1]=1;
        // echo $years[$y][0]," - ";
        // echo $years[$y][1],"<br>";
      }
    }
  }

  $mount_of_timestamps = count($timestamps);

  echo "hours: <br>";
  for($x = 0; $x <= count($hours)-1; $x++){
    $hours[$x]=round(($hours[$x]/$mount_of_timestamps)*100,3);
    echo $hours[$x],"<br>";
  }

  echo "days: <br>";
  for($x = 0; $x <= count($days)-1; $x++){
    $days[$x]=round(($days[$x]/$mount_of_timestamps)*100,3);
    echo $days[$x],"<br>";
  }

  echo "months: <br>";
  for($x = 0; $x <= count($months)-1; $x++){
    $months[$x]=round(($months[$x]/$mount_of_timestamps)*100,3);
    echo $months[$x],"<br>";
  }

  echo "years: <br>";
  for($x = 0; $x <= count($years)-1; $x++){
    $years[$x][1]=round(($years[$x][1]/$mount_of_timestamps)*100,3);
    echo $years[$x][0]," - ";
    echo $years[$x][1],"<br>";
  }

?>

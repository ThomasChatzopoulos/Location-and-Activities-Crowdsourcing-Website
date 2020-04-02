<?php
  require 'dbconnect.php';

  //------------------------------------------------ 1st query - eco user ------------------------------------------------
  // $user_id_query = "SELECT userID FROM user WHERE username = ".$_SESSION['usrname'];
  // $connected_user_id = mysqli_query($conn, $user_id_query);
  $connected_user_id="9/TTPft2JDhUoxeoggc7xkx4am1zMG52dFUwL3cxVy9Na3huYmc9PQ==";

  $nowtime = intval(sprintf('%d000',time()));

  // $previus_months_sec = time() - strtotime("1-".(date("m",time())+1)."-".(date("Y",time())-1)); //sec for (11 months + this month days) before today
  $previus_months_sec =1576800000; // 6 months

  $all_user_activities_query = sprintf("SELECT activity_timestamp FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp)/1000 < $previus_months_sec", mysqli_real_escape_string($conn,$connected_user_id));
  $eco_user_activities_query = sprintf("SELECT activity_timestamp FROM user_activity WHERE userMapData_userId = '%s'
  AND ($nowtime - activity_timestamp)/1000 < $previus_months_sec AND eco = 1", mysqli_real_escape_string($conn,$connected_user_id));

  $all_user_activities_result = mysqli_query($conn, $all_user_activities_query);
  if(!$all_user_activities_result){
    exit();
  }
  $eco_user_activities_result = mysqli_query($conn, $eco_user_activities_query);
  if(!$eco_user_activities_result){
    exit();
  }

  while ($row = mysqli_fetch_assoc($all_user_activities_result)) {
    $all_user_activities_timestamps[] = ($row['activity_timestamp'])/1000;
  }
  while ($row = mysqli_fetch_assoc($eco_user_activities_result)) {
    $eco_user_activities_timestamps[] = ($row['activity_timestamp'])/1000;
  }

  $months_counter = 0;
  $eco_months_counter = 0;
  foreach ($all_user_activities_timestamps as $key => $value) {
    $month=date("F", $value);
    if(!isset($months[$month])) {
      $months[$month] = 1;
      $months_counter += 1;
    }
    else {
      $months[$month] += 1;
      $months_counter += 1;
    }
  }
  foreach ($eco_user_activities_timestamps as $key => $value) {
    $month=date("F", $value);
    if(!isset($eco_months[$month])) {
      $eco_months[$month] = 1;
      $eco_months_counter += 1;
    }
    else {
      $eco_months[$month] += 1;
      $eco_months_counter += 1;
    }
  }

  foreach ($months as $key => $value) {
    $user_score[$key]=round(($eco_months[$key]/$months[$key])*100,2);
  }
  if(isset($user[date("m",time())])){
    $this_month_score = $user[date("m",time())];
  }
  else{
    $this_month_score = 0;
  }
  arsort($user_score);
  // echo "<br>";
  // print_r($user_score);
  $colours_months = set_Chart_colours($user_score);
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

//------------------------------------------------ 4th query - top 3 for last month ------------------------------------------------
  //$this_months_sec = time() - strtotime("1-".(date("m-Y",time()))); //sec for (11 months + this month days) before today
  $this_months_sec = 15768000; // 6 months
  $number_of_users_act_query = sprintf("SELECT COUNT(eco), userMapData_userId FROM user_activity
  WHERE ($nowtime - activity_timestamp)/1000 < $this_months_sec GROUP BY userMapData_userId");
  $number_of_users_eco_act_query = sprintf("SELECT COUNT(eco) FROM user_activity
  WHERE eco=1 AND ($nowtime - activity_timestamp)/1000 < $this_months_sec GROUP BY userMapData_userId");
  // echo $number_of_users_act_query,"<br>";
  // echo $number_of_users_eco_act_query;

  $number_of_users_act_results = mysqli_query($conn, $number_of_users_act_query);
  if(!$number_of_users_act_results){
    echo "SQL error <br>";
    exit();
  }
  $number_of_users_eco_act_result = mysqli_query($conn, $number_of_users_eco_act_query);
  if(!$number_of_users_eco_act_result){
    echo "SQL error <br>";
    exit();
  }

  while ($row = mysqli_fetch_assoc($number_of_users_act_results)) {
      $users_act_array[$row['userMapData_userId']]=$row['COUNT(eco)']; //$users_act_array[]: $key: userId, $value: number of user registrations
  }

  while ($row = mysqli_fetch_assoc($number_of_users_eco_act_result)) {
      $users_eco_act_array[]=$row['COUNT(eco)'];  //$users_eco_act_array[]: $key: increasing numbering, $value: number of eco user registrations
  }

  $counter=0;
  foreach ($users_act_array as $key => $value) {
    $temp_top_users[$key] = $users_eco_act_array[$counter]/$value; // $temp_top_users[]: $key: userId, $value: eco percent
    $counter++;
  }

  arsort($temp_top_users);

  $top_rank_users = array_slice($temp_top_users,0,3);
  $is_in_top = false;
  foreach ($top_rank_users as $key => $value) { // check if user is in top 3
    if($key==$connected_user_id){
      $is_in_top = true;
    }
  }
  if($is_in_top==true){
    $top_rank_users = array_slice($temp_top_users,0,4);
  }
  else if($is_in_top==false){
    $top_rank_users+=[$connected_user_id=>$eco_user_score];
  }

  arsort($top_rank_users);

  foreach ($top_rank_users as $key => $value) { //get name and surname
    $user_names_query = sprintf("SELECT name, surname FROM user WHERE userId = '$key'");
    $user_names_result = mysqli_query($conn, $user_names_query);
    if(!$user_names_result){
      echo "SQL error <br>";
      exit();
    }
    while ($row = mysqli_fetch_assoc($user_names_result)) {
      $user_names[] = sprintf($row['name']." ". substr($row['surname'],0,1));
    }
  }

  $counter=0;
  foreach ($top_rank_users as $key => $value) {
    $top_users[$user_names[$counter]]=round($value*100,2);
    $counter++;
  }
  //
  // echo "Top 3 users and you:<br>";
  // print_r($top_users);

//------------------------------------------------ function ------------------------------------------------
  function set_Chart_colours($distinct_keys)
  {
    $colours_vec = ['BLUE','AQUA','TEAL','OLIVE','GREEN','LIME','YELLOW','ORANGE','RED','MAROON','FUCHSIA','PURPLE','GRAY','SILVER'] ;
    $colours = array();
      if (sizeof($colours_vec) > sizeof($distinct_keys)) {
      for ($j=0; $j < sizeof($distinct_keys); $j++) {
        $colours[$j] = $colours_vec[$j];
      }
    }
    elseif (sizeof($colours) < sizeof($distinct_keys)) {
      $colours = $colours_vec;
      for ($i= sizeof($colours); $i < sizeof($distinct_keys) ; $i++) {
        $r= rand(0, 255);
        $g= rand(0, 255);
        $b= rand(0, 255);
        $colour_rand = "rgb($r, $g, $b)";
        array_push($colours, $colour_rand);
      }
    }
    else{
      $colours = $colours_act;
    }
    return $colours;
  }
?>

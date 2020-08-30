<?php
if ($_POST['submit'] || $_POST['exp_submit']) {  //submit button
  $erroryear = false;
  $errormonth = false;
  $errorday = false;
  $errorhour = false;
  $erroractivity = false;

  require 'dbconnect.php';

  if(isset($_POST['allYearsCheckBox']) && $_POST['allYearsCheckBox'] == 'Yes') { //all years selected
    $startYear = "1980";
    $endYear = "2020";
  }else {
    $startYear = $_POST['startyear'];
    $endYear = $_POST['endyear'];
    if ($startYear > $endYear) {
      $erroryear = true;
    }
  }

  if(isset($_POST['allMonthsCheckBox']) && $_POST['allMonthsCheckBox'] == 'Yes') {
    $startmonth = "01";
    $endmonth = "12";
  }else {
    $startmonth = $_POST['startmonth'];
    $endmonth = $_POST['endmonth'];
    if ($startmonth > $endmonth) {
      $errormonth = true;
    }
  }

  if(isset($_POST['allDaysCheckBox']) && $_POST['allDaysCheckBox'] == 'Yes') {
    $startday = "1";
    $endday = "7";
  }else {
    $startday = $_POST['startday'];
    $endday = $_POST['endday'];
    if ($startday > $endday) {
      $errorday = true;
    }
  }

  if(isset($_POST['allHoursCheckBox']) && $_POST['allHoursCheckBox'] == 'Yes') {
    $starthour = "00";
    $endhour = "23";
  }else {
    $starthour = $_POST['starthour'];
    $endhour = $_POST['endhour'];
    if ($starthour > $endhour) {
      $errorhour = true;
    }
  }

  $sql = "describe user_activity";
  $activity = mysqli_query($conn,$sql);

  if(!$activity){
    $erroractivity = true;
  }
  $actarray = array();
  $k=0;
  while($row = mysqli_fetch_assoc($activity)){
    if($row['Field'] != 'userMapData_userId' && $row['Field'] != 'userMapData_timestampMs' && $row['Field'] != 'activity_timestamp' && $row['Field'] != 'eco'){
      array_push($actarray, $row['Field']);
      $k++;
    }
  }
  //actarray εχει τις δραστηριότητες που επέλεξε ο χρήστης
  $activities = array();
  if(isset($_POST['allActivitiesCheckBox']) && $_POST['allActivitiesCheckBox'] == 'Yes'){ //all activities selected
    for ($i=0; $i < count($actarray) ; $i++) {
      array_push($activities,$actarray[$i]);
    }
  }else {
    for ($i = 0; $i < count($actarray); $i++) {
      if(isset($_POST[$actarray[$i]]) && $_POST[$actarray[$i]] == 'Yes') {
        array_push($activities,$actarray[$i]);
      }
    }


  }
$connected_user_id ="W2Pk6MvmP+hYj7xsiWawek9xS3d2N3lnZzdva29wRVZidWlGOVdPbEtOejN6S0tlVkttTFZEQ1d5ZUU9"; //user in my database

$currentyear = $startYear;
$datetimes = array();
while($currentyear <= $endYear){ // για κάθε χρόνο στο range
  $currentmonth = $startmonth;
  while($currentmonth <= $endmonth){ //για κάθε μήνα στο range
    $currentday = $startday;
    while($currentday <= $endday)
    {

      $starttemp = "$currentyear-$currentmonth-01";
      $sql = "select dayofweek('$starttemp') as Day";
      $dayofweek = mysqli_query($conn,$sql);
      if(!$dayofweek){
        exit();
      }
      $difference = 0;
      while($row = mysqli_fetch_assoc($dayofweek)){ //βρες μέρα της βδομάδας για την 1η μέρα του τρέχοντα μήνα
        $difference = $currentday - $row['Day'];
      }
      if($difference < 0 ){ //
        $difference += 7;
      }

      //βρες συνολικές μέρες του τρέχοντα μήνα
      $totalmonthdays = 0;
      if($currentmonth == '01' || $currentmonth=='03' || $currentmonth=='05' || $currentmonth=='07' || $currentmonth=='08' || $currentmonth=='10' || $currentmonth=='12'){
        $totalmonthdays = 31;
      }elseif($currentmonth == '02'){ //February
        if($currentyear%4 == 0){ //δισεκτο ετος
          $totalmonthdays = 29;
        }else {
          $totalmonthdays = 28;
        }
      }else {
        $totalmonthdays = 30;
      }

      //προσθέτω το difference έτσι ώστε να βρω την πρώτη τρίτη του μήνα (αν εχω επιλέξει τρίτη κλπ) και μετά με βήμα 7 θα βρει όλες τις τρίτες του μήνα
      for($i=1+$difference; $i<=$totalmonthdays; $i+=7){
        array_push($datetimes, "$currentyear-$currentmonth-$i $starthour:00:00"); //αποθηκεύω στο array ανα 2 για τα timesamps
        array_push($datetimes, "$currentyear-$currentmonth-$i $endhour:59:59");
      }
      $currentday++;
    }
    $currentmonth++;
  }
  $currentyear++;
}

//datetime to timestampms conversion
$timestamps = array();
for($i=0; $i<count($datetimes); $i++){
  $sql = "select unix_timestamp('$datetimes[$i]') as timestamp";
  $timestamp_result = mysqli_query($conn,$sql);

  if(!$timestamp_result){
    exit();
  }

  while ($row = mysqli_fetch_assoc($timestamp_result)) {
      array_push($timestamps,( $row['timestamp'] * 1000 ) ); //*1000 για να είναι σε ms
  }
}

  if($_POST['submit'] == 'true') {      // TODO: CHECK FOR EASIER WAY
    echo("potato");
  }
  elseif ($_POST['exp_submit'] == 'true') {
    include 'export_file.php';
    $export_array = array();
    for($i=0; $i<count($timestamps); $i+=2){
      $ts1 = $timestamps[$i];
      $ts2 = $timestamps[$i+1];
      $sql = "SELECT heading, velocity, accuracy, longitude, latitude, altitude, timestampMs, userId FROM `usermapdata` WHERE timestampMs BETWEEN $ts1 AND $ts2";
      $select_result = mysqli_query($conn,$sql);

      if(!$select_result){
        exit();
      }
      else {
        while ($row = mysqli_fetch_assoc($select_result)) {
          $userId = $row['userId'];
          unset($row['userId']);
          $row = add_activity_info($row, $conn);
          $row['userId'] = $userId;
          array_push($export_array, $row);
        }
      }
    }
    echo($_POST['exp_type']);
    echo(export_data($export_array, $_POST['exp_type']));
  }
  echo json_encode(array($erroryear, $errormonth, $errorday, $errorhour, $erroractivity));
}
?>

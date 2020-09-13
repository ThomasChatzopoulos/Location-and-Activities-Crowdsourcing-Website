<?php
if ($_POST['submit'] || $_POST['exp_submit']) {  //submit button
  $erroryear = false;
  $errormonth = false;
  $errorday = false;
  $errorhour = false;
  $erroractivity = false;

  require 'dbconnect.php';

  if($_POST['select_allyears']=='true') { //all years selected
    $startYear = "2000";
    $endYear = "2020";
  }else {
    $startYear = $_POST['startyear'];
    $endYear = $_POST['endyear'];
    if ($startYear > $endYear) {
      $erroryear = true;
    }
  }
  if($_POST['select_allmonths']=='true') {
    $startmonth = "January";
    $endmonth = "December";
  }else {
    $startmonth = $_POST['startmonth'];
    $endmonth = $_POST['endmonth'];
    // if ($startmonth > $endmonth) {
    //   $errormonth = true;
    // }
  }
  if($_POST['select_alldays']=='true') {
    $startday = "Sunday";
    $endday = "Saturday";
  }else {
    $startday = $_POST['startday'];
    $endday = $_POST['endday'];
    // if ($startday > $endday) {
    //   $errorday = true;
    // }
  }
  if($_POST['select_allhours']=='true') {
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
  if($_POST['select_all_activities']=='true') { //all activities selected
    for ($i=0; $i < count($actarray) ; $i++) {
      array_push($activities,$actarray[$i]);
    }
  }
  else {
    for ($i = 0; $i < count($actarray); $i++) {
      if(isset($_POST[$actarray[$i]]) && $_POST[$actarray[$i]] == 'Yes') {
        array_push($activities,$actarray[$i]);
      }
    }
  }

  $timestamps = array();
  $year = $startYear;
  $counter=0;

  for($i=1;$i<=($endYear-$startYear+1)*2;$i++){ //(διαφορά χρόνων+1)*(2μήνες)
    if($i%2==1){//αν είναι ο μήνας εκκίνησης
      for($day=strtotime("first $startday of $startmonth $year");$day<=strtotime("last $startday of $startmonth $year");$day+=604800){//κάθε μέρα εκκίνησης
        $d=date('d',$day);
        array_push($timestamps, strtotime("$starthour:00 $d $startmonth $year")*1000); //ώρα εκκίνησης
        array_push($timestamps, strtotime("$endhour:59:59 $d $startmonth $year")*1000); //ώρα λήξης
      }
      for($day=strtotime("first $endday of $startmonth $year");$day<=strtotime("last $endday of $startmonth $year");$day+=604800){//κάθε μέρα λήξης
        $d=date('d',$day);
        array_push($timestamps, strtotime("$starthour:00 $d $startmonth $year")*1000); //ώρα εκκίνησης
        array_push($timestamps, strtotime("$endhour:59:59 $d $startmonth $year")*1000); //ώρα λήξης
      }
      $counter++;
    }
    elseif($i%2==0) {//αν είναι ο μήνας λήξης
      for($day=strtotime("first $startday of $endmonth $year");$day<=strtotime("last $startday of $endmonth $year");$day+=604800){//κάθε μέρα εκκίνησης
        $d=date('d',$day);
        array_push($timestamps, strtotime("$starthour:00 $d $endmonth $year")*1000); //ώρα εκκίνησης
        array_push($timestamps, strtotime("$endhour:59:59 $d $endmonth $year")*1000); //ώρα λήξης
      }
      for($day=strtotime("first $endday of $endmonth $year");$day<=strtotime("last $endday of $endmonth $year");$day+=604800){//κάθε μέρα λήξης
        $d=date('d',$day);
        array_push($timestamps, strtotime("$starthour:00 $d $endmonth $year")*1000); //ώρα εκκίνησης
        array_push($timestamps, strtotime("$endhour:59:59 $d $endmonth $year")*1000); //ώρα λήξης
      }
      $counter++;
    }
    if($counter==2){
      $year++;
      $counter=0;
    }
  }

  if(!$erroryear && !$errormonth && !$errorday && !$errorhour && !$erroractivity)
  {
    if($_POST['submit'] == 'true') {      // TODO: CHECK FOR EASIER WAY
      include 'heatmap_data.php';
      $datapoints = heatmapdata($timestamps);
      echo json_encode(array('result1'=>array($erroryear, $errormonth, $errorday, $errorhour, $erroractivity), 'result2'=>$datapoints, 'result3'=>null));
    }
    elseif ($_POST['exp_submit'] == 'true') {
      include 'export_file.php';
      $export_array = array();
      for($i=0; $i<count($timestamps); $i+=2){
        $ts1 = $timestamps[$i];
        $ts2 = $timestamps[$i+1];
        $sql = "SELECT heading, velocity, accuracy, longitude, latitude, altitude, timestampMs, userId FROM `usermapdata` WHERE timestampMs BETWEEN $ts1 AND $ts2";
        $select_result = mysqli_query($conn,$sql);
        // echo $sql,";\n";

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
      $result_r=export_data($export_array, $_POST['exp_type']);
      $export_results=array($result_r);
      echo json_encode(array('result1'=>array($erroryear, $errormonth, $errorday, $errorhour, $erroractivity), 'result2'=>null,'result3'=>$export_results));
      // $path=("export_files/$result_r");
    }
  }
  else {
    echo json_encode(array('result1'=>array($erroryear, $errormonth, $errorday, $errorhour, $erroractivity), 'result2'=>null, 'result3'=>null));
  }
}
?>

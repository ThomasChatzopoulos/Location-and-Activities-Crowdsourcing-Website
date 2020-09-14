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
    $startmonth = "01";
    $endmonth = "12";
  }else {
    $startmonth = $_POST['startmonth'];
    $endmonth = $_POST['endmonth'];
  }

  if($_POST['select_alldays']=='true') {
    $startday = "0";
    $endday = "6";
  }else {
    $startday = $_POST['startday'];
    $endday = $_POST['endday'];
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
 $actarray_test=json_decode($_POST['actarray']);
  $activities = array();
  print_r($actarray_test);
  if($_POST['select_all_activities']=='true') { //all activities selected
    for ($i=0; $i < count($actarray) ; $i++) {
      array_push($activities,$actarray[$i]);
    }
  }
  else {
    for ($i = 0; $i < count($actarray); $i++) {
      if(isset($_POST[$actarray[$i]])) {
        array_push($activities,$actarray[$i]);
      }
    }
  }

  $timestamps = array();
  $counter=0;

  if($endmonth>=$startmonth){
    $months=$endmonth-$startmonth;
  }
  elseif($endmonth<$startmonth){
    $months= 12+$endmonth;
  }

  if($endday>=$startday){
    $days=$endday-$startday;
  }
  elseif($endday<$startday){
    $days=7+$endday;
  }

  for($currentYear=$startYear;$currentYear<=$endYear;$currentYear++){
    for($forMonth=$startmonth;$forMonth<=$startmonth+$months;$forMonth++){
      $currentMonth=date('F', mktime(0, 0, 0, ($forMonth-1)%12+1, 10));
      for($forday=$startday;$forday<=$startday+$days;$forday++){
        $currentDay=jddayofweek(($forday-1)%7,1);
        for($day=strtotime("first $currentDay of $currentMonth $currentYear");$day<=strtotime("last $currentDay of $currentMonth $currentYear");$day+=604800){//κάθε μέρα εκκίνησης
          $d=date('d',$day);
          array_push($timestamps, strtotime("$starthour:00 $d $currentMonth $currentYear")*1000); //ώρα εκκίνησης
          array_push($timestamps, strtotime("$endhour:59:59 $d $currentMonth $currentYear")*1000+999); //ώρα λήξης
        }
      }
    }
  }

  asort($timestamps);
  // print_r($timestamps);

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
      $where="";
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
      $result_r=export_data($export_array, $_POST['exp_type']);
      $export_results=array($result_r);
      echo json_encode(array('result1'=>array($erroryear, $errormonth, $errorday, $errorhour, $erroractivity), 'result2'=>null,'result3'=>$export_results));
    }
  }
  else {
    echo json_encode(array('result1'=>array($erroryear, $errormonth, $errorday, $errorhour, $erroractivity), 'result2'=>null, 'result3'=>null));
  }
}
?>

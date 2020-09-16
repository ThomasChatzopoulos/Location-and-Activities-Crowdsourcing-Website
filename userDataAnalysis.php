<?php
  if ($_POST['submit']) {
    $erroryear = false;
    $errormonth = false;
    $errorday = false;
    $errorhour = false;
    $erroractivity = false;

    require "dbconnect.php";

    if($_POST['select_allyears_u']=='true') {
      $startYear = "2000";
      $endYear="2020";
    }else{
      $startYear = $_POST['startyear'];
      $endYear = $_POST['endyear'];
      if ($startYear > $endYear) {
        $erroryear = true;
      }
    }

    if($_POST['select_allmonths_u'] == 'true') {
      $startmonth = "January";
      $endmonth = "December";
    }else{
      $startmonth = $_POST['startmonth'];
      $endmonth = $_POST['endmonth'];
      if ($startmonth > $endmonth) {
        $errormonth = true;
      }
    }
    $timestamps = array();
    $year = $startYear;
    $counter=0;

    for($i=1;$i<=($endYear-$startYear)*2+2;$i++){
      if($i%2==1){
        array_push($timestamps, strtotime("$startmonth $year")*1000);
        $counter++;
      }
      elseif($i%2==0) {
        $month = date('F', mktime(0, 0, 0,date("m",strtotime($endmonth))+1,10));//end month +1
        if(date("m",strtotime($endmonth))==12){
          $year++;
          array_push($timestamps, (strtotime("$month $year")-1)*1000+999);
          $year--;
          $counter++;
        }
        else{
          array_push($timestamps, (strtotime("$month $year")-1)*1000+999);
          $counter++;
        }
      }
      if($counter==2){
        $year++;
        $counter=0;
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

    $activities = array();
    for ($i=0; $i < count($actarray) ; $i++) {
      array_push($activities,$actarray[$i]);
    }

    include 'heatmap_data.php';
    $datapoints = heatmapdata($timestamps, $activities);

    include 'charts_data/user_activities_distribution.php';
    $persentage_results = analyzeActivitiesPersentage($timestamps);

    include 'charts_data/best_hour_per_activity.php';
    $hour_results=findBestHour($timestamps);

    include 'charts_data/best_day_per_activity.php';
    $day_results=findBestDay($timestamps);

    echo json_encode(array('result1'=>array($erroryear, $errormonth),'result2'=>$persentage_results,'result3'=> $hour_results, 'result4'=>$day_results, 'result5'=>$datapoints));
  }
?>

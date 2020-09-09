<?php
  if ($_POST['submit']) {
    $erroryear = false;
    $errormonth = false;
    $errorday = false;
    $errorhour = false;
    $erroractivity = false;

    require "dbconnect.php";

    if($_POST['select_allyears']=='true')) {
      $startYear = "2000";
      $endYear = "2020";
    }else{
      $startYear = $_POST['startyear'];
      $endYear = $_POST['endyear'];
      if ($startYear > $endYear) {
        $erroryear = true;
      }
    }

    if($_POST['select_allmonths'] == 'true') {
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
        if($endmonth==01){
          $year++;
          array_push($timestamps, (strtotime("$endmonth $year")-1)*1000);
          $year--;
          $counter++;
        }
        else{
          array_push($timestamps, (strtotime("$endmonth $year")-1)*1000);
          $counter++;
        }
      }
      if($counter==2){
        $year++;
        $counter=0;
      }
    }
    // print_r($timestamps);
    include 'heatmap_data.php';
    $datapoints = heatmapdata($timestamps);

    include 'charts_data/user_activities_distribution.php';
    $persentage_results = analyzeActivitiesPersentage($timestamps);

    include 'charts_data/best_hour_per_activity.php';
    $hour_results=findBestHour($timestamps);

    include 'charts_data/best_day_per_activity.php';
    $day_results=findBestDay($timestamps);

    // echo json_encode(array('result1'=>array($erroryear, $errormonth),'result2'=>$persentage_results,'result3'=> $hour_results));

    echo json_encode(array('result1'=>array($erroryear, $errormonth),'result2'=>$persentage_results,'result3'=> $hour_results, 'result4'=>$day_results, 'result5'=>$datapoints));
  }
?>

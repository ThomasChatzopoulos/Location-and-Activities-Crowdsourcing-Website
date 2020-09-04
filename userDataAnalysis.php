<?php
  if ($_POST['submit']) {
    $erroryear = false;
    $errormonth = false;
    $errorday = false;
    $errorhour = false;
    $erroractivity = false;

    require "dbconnect.php";

    if(isset($_POST['allYearsCheckBox']) && $_POST['allYearsCheckBox'] == 'Yes') {
      $startYear = "1980";
      $endYear = "2020";
    }else{
      $startYear = $_POST['startyear'];
      $endYear = $_POST['endyear'];
      if ($startYear > $endYear) {
        $erroryear = true;
      }
    }

    if(isset($_POST['allMonthsCheckBox']) && $_POST['allMonthsCheckBox'] == 'Yes') {
      $startmonth = "01";
      $endmonth = "12";
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
        $month = date('F', mktime(0, 0, 0, $startmonth, 10));
        array_push($timestamps, strtotime("$month $year")*1000);
        // echo strtotime("$month $year")*1000, "\n";
        $counter++;
      }
      elseif($i%2==0) {
        if($endmonth==01){
          $month = date('F', mktime(0, 0, 0, $endmonth, 10));
          $year++;
          array_push($timestamps, (strtotime("$month $year")-1)*1000);
          $year--;
          $counter++;
        }
        else{
          $month = date('F', mktime(0, 0, 0, $endmonth, 10));
          array_push($timestamps, (strtotime("$month $year")-1)*1000);
          $counter++;
        }
      }
      if($counter==2){
        $year++;
        $counter=0;
      }
    }
    // print_r($timestamps);

    include 'charts_data/user_activities_distribution.php';
    $persentage_results = analyzeActivitiesPersentage($timestamps);

    // include 'best_hour_per_activity.php';
    // $hour_results=findBestHour($timestamps);
    // include 'best_day_per_activity.php';
    // $day_results=findBestDay($timestamps);

    echo json_encode(array('result1'=>array($erroryear, $errormonth),'result2'=>$persentage_results));

    // echo json_encode(array('result1'=>array($erroryear, $errormonth),'result2'=>$persentage_results,'result3'=> $hour_results, 'result4'=>$day_results));

  }
?>

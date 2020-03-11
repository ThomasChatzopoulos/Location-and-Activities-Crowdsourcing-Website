<?php
session_start();
?>

<?php
if (isset($_POST['heatmap_button'])) {
  require 'dbconnect.php';

  $years = $_POST['yearBox'];
  $months = $_POST['monthBox'];
  $days = $_POST['dayBox'];
  $hours = $_POST['hourBox'];
  $activities = $_POST['activityBox'];

  $nyears = count($years);
  $nmonths = count($months);
  $ndays = count($days);
  $nhours = count($hours);
  $nactivities = count($activities);

  if($nyears>2  || $nmonths>2 || $ndays>2 || $nhours>2){
    header("Location: adminPage.php?selected_more_than_2");
    exit();
  }



}else {
  header("Location: adminPage.php?patates");
}


?>

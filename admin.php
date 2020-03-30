<?php
session_start();
?>

<?php
if (isset($_POST['dates_button'])) {  //submit button
  require 'dbconnect.php';

  if(isset($_POST['allYearsCheckBox']) && $_POST['allYearsCheckBox'] == 'Yes') { //all years selected
    $startYear = "1980";
    $endYear = "2020";
    echo("Start year = $startYear <br>" );
    echo("End year = $endYear <br>");
  }else {
    $startYear = $_POST['startyearBox'];
    $endYear = $_POST['endyearBox'];

    if ($startYear > $endYear) {
      header("Location: adminPage.php?error=startmonth>endmonth");
    }

    echo("Start year = $startYear <br>" );
    echo("End year = $endYear <br>");
  }

  if(isset($_POST['allMonthsCheckBox']) && $_POST['allMonthsCheckBox'] == 'Yes') {
    $startmonth = "01";
    $endmonth = "12";
    echo("Start month = $startmonth <br>" );
    echo("End month = $endmonth <br>");
  }else {
    $startmonth = $_POST['startmonthBox'];
    $endmonth = $_POST['endmonthBox'];

    if ($startmonth > $endmonth) {
      header("Location: adminPage.php?error=startmonth>endmonth");
    }
    echo"TROLL";
    echo("Start month = $startmonth <br>" );
    echo("End month = $endmonth <br>");
  }

  if(isset($_POST['allDaysCheckBox']) && $_POST['allDaysCheckBox'] == 'Yes') {
    $startday = "1";
    $endday = "7";
    echo ("Start day = $startday <br>");
    echo ("End day = $endday <br>");
  }else {
    $startday = $_POST['startdayBox'];
    $endday = $_POST['enddayBox'];

    if ($startday > $endday) {
      header("Location: adminPage.php?error=startday>endday");
    }

    echo ("Start day = $startday <br>");
    echo ("End day = $endday <br>");
  }

  if(isset($_POST['allHoursCheckBox']) && $_POST['allHoursCheckBox'] == 'Yes') {
    $starthour = "00";
    $endhour = "23";
    echo("Start Hour = $starthour <br>");
    echo("End Hour = $endhour <br>");
  }else {
    $starthour = $_POST['starthourBox'];
    $endhour = $_POST['endhourBox'];

    if ($startYear > $endYear) {
      header("Location: adminPage.php?error=starthour>endhour");
    }

    echo("Start Hour = $starthour <br>");
    echo("End Hour = $endhour <br>");
  }

  $sql = "describe user_activity";
  $activity = mysqli_query($conn,$sql);

  if(!$activity){
    echo "hello";
    exit();
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
  if(isset($_POST['allActivitiesCheckBox']) && $_POST['allActivitiesCheckBox'] == 'Yes'){ //all activities selected
    echo("All activities selected <br>");
    for ($i=0; $i < count($actarray) ; $i++) {
      array_push($activities,$actarray[$i]);
      echo(" $activities[$i] ,");
    }
  }else {
    for ($i = 0; $i < count($actarray); $i++) {
      if(isset($_POST[$actarray[$i]]) && $_POST[$actarray[$i]] == 'Yes') {
        array_push($activities,$actarray[$i]);
        echo("$actarray[$i] ,");
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
        echo "hello";
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
    echo "hello";
    exit();
  }

  while ($row = mysqli_fetch_assoc($timestamp_result)) {
      array_push($timestamps,( $row['timestamp'] * 1000 ) ); //*1000 για να είναι σε ms
  }
}

//Mysql selection from usermapdata
$finaltimestamps = array();
for($i=0; $i<count($timestamps); $i+=2){
  $ts1 = $timestamps[$i];
  $ts2 = $timestamps[$i+1];
  $sql = "select userMapData_timestampMs as time from user_activity where userMapData_timestampMs > $ts1 and userMapData_timestampMs  < $ts2";
  $select_result = mysqli_query($conn,$sql);

  if(!$select_result){
    echo "hello";
    exit();
  }

  while($row = mysqli_fetch_assoc($select_result)){
    array_push($finaltimestamps,$row['time']);
  }
}

echo("<br><br>");
for($i=0; $i<count($finaltimestamps); $i++){
  echo ("$finaltimestamps[$i] <br> ");
}


}elseif (isset($_POST['delete_button'])) { //delete database button
  ?>
    <h1>Are you sure you want to erase the entire database?</h1>
    <form class="" action="erase.php" method="post">
      <button type="submit" name="yes_button">YES</button>
      <button type="submit" name="no_button">NO</button>
    </form>
  <?php
} elseif (isset($_POST['export_button'])) { //export data button
  $datatype = $_POST['exportselectBox'];
  // TODO: δεν ξέρω αν χρειάζεται κάτι άλλο
}else {
  header("Location: adminPage.php?patates");
}


?>

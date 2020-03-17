<?php
session_start();
?>

<?php
if (isset($_POST['dates_button'])) {  //submit button
  require 'dbconnect.php';

  if( !isset($_POST['allYearsCheckBox']) && ( $_POST['startyearBox'] == '' || $_POST['endyearBox'] == '' ) ) //if no year has been picked and checkbox is not used
  {
    header("Location: adminPage.php?error=noYearpicked");
  }else {
    if(isset($_POST['allYearsCheckBox']) && $_POST['allYearsCheckBox'] == 'Yes'){ //selected all years
      $startYear = 1980;
      $endYear = 2020;
      echo ("Start year = $startYear <br>" );
      echo ("End year = $endYear <br>");
    }else{
      $startYear = $_POST['startyearBox'];
      $endYear = $_POST['endyearBox'];

      if ($startYear > $endYear) {
        header("Location: adminPage.php?error=startyear>endyear");
      }

      echo ("Start year = $startYear <br>");
      echo ("End year = $endYear <br>");
    }
  }


  if( !isset($_POST['allMonthsCheckBox']) && ( $_POST['startmonthBox'] == '' || $_POST['endmonthBox'] == '' ) )
  {
    header("Location: adminPage.php?error=noMonthpicked");
  }else {
    if(isset($_POST['allMonthsCheckBox']) && $_POST['allMonthsCheckBox'] == 'Yes'){ //selected all months
      $startmonth = "01";
      $endmonth = "12";
      echo("Start month = $startmonth <br>" );
      echo("End month = $endmonth <br>");
    }else {
      $startmonth = $_POST['startmonthBox'];
      $endmonth = $_POST['endmonthBox'];

      if ($startmonth > $endmonth) {
        header("Location: adminPage.php?error=startmont>endmonth");
      }

      echo ("Start month = $startmonth <br>");
      echo("End month = $endmonth <br>");
    }
  }

  if(!isset($_POST['allDaysCheckBox']) && ( $_POST['startdayBox'] == '' || $_POST['enddayBox'] == '' ) ){
    header("Location: adminPage.php?error=noDaypicked");
  }else {
    if(isset($_POST['allDaysCheckBox']) && $_POST['allDaysCheckBox'] == 'Yes'){ //selected all days
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
  }

  if(!isset($_POST['allHoursCheckBox']) && ( $_POST['starthourBox'] == '' || $_POST['endhourBox'] == '' ) ){
    header("Location: adminPage.php?error=noHourpicked");
  }else {
    if(isset($_POST['allHoursCheckBox']) && $_POST['allHoursCheckBox'] == 'Yes'){ //selected all hours
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
  }

  if(!isset($_POST['allActivitiesCheckBox']) && !isset($_POST['activityBox']) ){
    header("Location: adminPage.php?error=noActivitypicked");
  }else {
    if(isset($_POST['allActivitiesCheckBox']) && $_POST['allActivitiesCheckBox'] == 'Yes'){ // selected all activities
      echo("All activities selected <br>");
      $activities = array( "IN_VEHICLE", "ON_BICYCLE", "ON_FOOT", "RUNNING", "STILL", "TILTING", "UNKNOWN", "WALKING" , "IN_ROAD_VEHICLE" ,"IN_RAIL_VEHICLE" , "IN_FOUR_WHEELER_VEHICLE" , "IN_CAR"  );
      $nactivities = count($activities);
      echo("selected $nactivities activities :");
      for ($i=0; $i < $nactivities ; $i++) {
        echo(" $activities[$i] ,");
      }
    }else {
      $activities = $_POST['activityBox'];
      $nactivities = count($activities);
      echo("selected $nactivities activities :");
      for ($i=0; $i < $nactivities ; $i++) {
        echo(" $activities[$i] ,");
      }
    }
  }
  //now all variables are set we begin SQL
$connected_user_id ="W2Pk6MvmP+hYj7xsiWawek9xS3d2N3lnZzdva29wRVZidWlGOVdPbEtOejN6S0tlVkttTFZEQ1d5ZUU9"; //user in my database

echo("<br> $startYear - $endYear / $startmonth - $endmonth / $startday - $endday / $starthour - $endhour : " );
for ($i=0; $i < $nactivities ; $i++) {
  echo(" $activities[$i] ,");
}

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
        array_push($datetimes, "$currentyear-$currentmonth-$i $endhour:00:00");
      }
      $currentday++;
    }
    $currentmonth++;
  }
  $currentyear++;
}

echo("<br><br>");
for($i=0; $i<count($datetimes); $i++){
  echo("$datetimes[$i] <br>");
}

// TODO: convert date me wra se timestamp (exei etoimes entoles i MYSQL)
// TODO: na valw ta select stin MYSQL gia na pairnei ta swsta timestamps (8a einai tosa timesamps oses kai oi trites tou mina px an exw epileksei triti)



}elseif (isset($_POST['delete_button'])) { //delete database button
  ?>
    <h1>Are you sure you want to erase the entire database?</h1>
    <form class="" action="erase.php" method="post">
      <button type="submit" name="yes_button">YES</button>
      <button type="submit" name="no_button">NO</button>
    </form>
  <?php
} // TODO: leipei to export koumpi
else {
  header("Location: adminPage.php?patates");
}


?>

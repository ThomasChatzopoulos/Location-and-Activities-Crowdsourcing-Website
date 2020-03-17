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
echo "<br><br>";


echo("first day of start month : $startYear-$startmonth-01<br><br>");

$starttemp = "$startYear-$startmonth-01";
$sql = "select dayofweek('$starttemp') as Day";
$dayofweek = mysqli_query($conn,$sql);
if(!$dayofweek){
  echo "hello";
  exit();
}
$day ="";
$difference = 0;
while($row = mysqli_fetch_assoc($dayofweek)){ //to get day of the week 1st day of the start month
  switch ("$row[Day]") {
    case 1:
      $day = "Sunday";
      break;
    case 2:
      $day = "Monday";
      break;
    case 3:
      $day = "Tuesday";
      break;
    case 4:
      $day = "Wednesday";
      break;
    case 5:
      $day = "Thursday";
      break;
    case 6:
      $day = "Friday";
      break;
    case 7:
      $day = "Saturday";
      break;
    default:
      echo "failed";
      break;
  }
  echo("day of the week at $starttemp is : $day<br>");
  $difference = $startday - $row['Day'];
}
switch ($startday) {
  case '1':
    $day = "Sunday";
    break;
  case '2':
    $day = "Monday";
    break;
  case '3':
    $day = "Tuesday";
    break;
  case '4':
    $day = "Wednesday";
    break;
  case '5':
    $day = "Thursday";
    break;
  case '6':
    $day = "Friday";
    break;
  case '7':
    $day = "Saturday";
    break;
  default:
    echo "failed";
    break;
  }

echo("your day is: $day<br>");
if($difference < 0 ){
  $difference += 7;
}

echo("You need to add $difference day(s) to get to the start day you selected <br>");

$totalmonthdays = 0;
if($startmonth == '01' || $startmonth=='03' || $startmonth=='05' || $startmonth=='07' || $startmonth=='08' || $startmonth=='10' || $startmonth=='12'){
  echo("start month has 31 days <br>");
  $totalmonthdays = 31;
}elseif($startmonth == '02'){ //February
  if($startYear%4 == 0){ //disekto etos
    echo("Start month has 29 days <br>");
    $totalmonthdays = 29;
  }else {
    echo("start month has 28 days <br>");
    $totalmonthdays = 28;
  }
}else {
  echo("start month has 30 days <br>");
  $totalmonthdays = 30;
}

$k =0;
$startdates = array();
$startdatetimes = array();
for($i=1+$difference; $i<=$totalmonthdays; $i+=7){ //pare oles tis trites tou mina px an exw epileksei triti
  $k++;
  array_push($startdates, $i);
}
echo("start month has $k $day s<br>");
echo("dates of $day : <br>");
for($i=0; $i<count($startdates); $i++){
  echo("$startYear-$startmonth-$startdates[$i] <br>");
}
for ($i=0; $i < count($startdates) ; $i++) {
  array_push($startdatetimes ,"$startYear-$startmonth-$startdates[$i] $starthour:00");
}
echo("start datetime for selected days: <br>");
for($i=0; $i<count($startdates); $i++){
  echo("$startdatetimes[$i] <br>");
}

echo("<br><br>");

echo("first day of end month : $endYear-$endmonth-01<br><br>");

$endtemp = "$endYear-$endmonth-01";
$sql = "select dayofweek('$endtemp') as Day";
$dayofweek = mysqli_query($conn,$sql);
if(!$dayofweek){
  echo "hello";
  exit();
}
$day ="";
$difference = 0;
while($row = mysqli_fetch_assoc($dayofweek)){ //to get day of the week 1st day of the start month
  switch ("$row[Day]") {
    case 1:
      $day = "Sunday";
      break;
    case 2:
      $day = "Monday";
      break;
    case 3:
      $day = "Tuesday";
      break;
    case 4:
      $day = "Wednesday";
      break;
    case 5:
      $day = "Thursday";
      break;
    case 6:
      $day = "Friday";
      break;
    case 7:
      $day = "Saturday";
      break;
    default:
      echo "failed";
      break;
  }
  echo("day of the week at $endtemp is : $day<br>");
  $difference = $endday - $row['Day'];
}
switch ($endday) {
  case '1':
    $day = "Sunday";
    break;
  case '2':
    $day = "Monday";
    break;
  case '3':
    $day = "Tuesday";
    break;
  case '4':
    $day = "Wednesday";
    break;
  case '5':
    $day = "Thursday";
    break;
  case '6':
    $day = "Friday";
    break;
  case '7':
    $day = "Saturday";
    break;
  default:
    echo "failed";
    break;
  }

echo("your day is: $day<br>");
if($difference < 0 ){
  $difference += 7;
}

echo("You need to add $difference day(s) to get to the end day you selected <br>");

$totalmonthdays = 0;
if($endmonth == '01' || $endmonth=='03' || $endmonth=='05' || $endmonth=='07' || $endmonth=='08' || $endmonth=='10' || $endmonth=='12'){
  echo("end month has 31 days <br>");
  $totalmonthdays = 31;
}elseif($endmonth == '02'){ //February
  if($endYear%4 == 0){ //disekto etos
    echo("end month has 29 days <br>");
    $totalmonthdays = 29;
  }else {
    echo("end month has 28 days <br>");
    $totalmonthdays = 28;
  }
}else {
  echo("end month has 30 days <br>");
  $totalmonthdays = 30;
}

$k =0;
$enddates = array();
$enddatetimes = array();
for($i=1+$difference; $i<=$totalmonthdays; $i+=7){ //pare oles tis trites tou mina px an exw epileksei triti
  $k++;
  array_push($enddates, $i);
}
echo("end month has $k $day s<br>");
echo("dates of $day : <br>");
for($i=0; $i<count($enddates); $i++){
  echo("$endYear-$endmonth-$enddates[$i] <br>");
}
for ($i=0; $i < count($enddates); $i++) {
  array_push($enddatetimes ,"$endYear-$endmonth-$enddates[$i] $endhour:00");
}
echo("end datetime for selected days: <br>");
for ($i=0; $i < count($enddatetimes) ; $i++) {
  echo("$enddatetimes[$i] <br>");
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

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>adminPage</title>
    <script type="text/javascript" src="disable_function.js"></script>
  </head>
  <body>
    <h1>hello</h1>

<form action="admin.php" method="POST">
<label for="startyearBox">Start year:</label>
<select id="startyearBox" required>
<option value=""></option>
<?php
  for ($i=1980; $i <=2020; $i++) {
    ?>
      <option value = <?=$i?>> <?=$i?> </option>
    <?php
  }
  ?>
</select>

<label for="endyearBox">End year:</label>
<select id="endyearBox" required>
<option value=""></option>
<?php
  for ($i=1980; $i <=2020; $i++) {
    ?>
      <option value = <?=$i?>> <?=$i?> </option>
    <?php
  }
?>
</select>

<br>Check to select All years: <input type="checkbox" id="allYearsCheckBox" value="Yes" onclick="disable('startyearBox', 'endyearBox')">

<br> <br>
<label for="startmonthBox">Start month:</label>
<select id = "startmonthBox" >
  <option value=""></option>
  <option value = "01"> January</option>
  <option value = "02"> February</option>
  <option value = "03"> March</option>
  <option value = "04"> April</option>
  <option value = "05"> May</option>
  <option value = "06"> June</option>
  <option value = "07"> July</option>
  <option value = "08"> August</option>
  <option value = "09"> September</option>
  <option value = "10"> October</option>
  <option value = "11"> November</option>
  <option value = "12"> December</option>
</select>

<label for="endmonthBox">End month:</label>
<select id = "endmonthBox" enddayBox>
  <option value=""></option>
  <option value = "01"> January</option>
  <option value = "02"> February</option>
  <option value = "03"> March</option>
  <option value = "04"> April</option>
  <option value = "05"> May</option>
  <option value = "06"> June</option>
  <option value = "07"> July</option>
  <option value = "08"> August</option>
  <option value = "09"> September</option>
  <option value = "10"> October</option>
  <option value = "11"> November</option>
  <option value = "12"> December</option>
</select>

<br>Check to select all months: <input type="checkbox" name="allMonthsCheckBox" value="Yes" onclick="disable('startmonthBox', 'endmonthBox')">

<br> <br>
<label for="startdayBox">Start Day:</label>
<select id="startdayBox" required>
  <option value=""></option>
  <option value ="2"> Monday  </option>
  <option value ="3"> Tuesday </option>
  <option value ="4"> Wednesday </option>
  <option value ="5"> Thursday </option>
  <option value ="6"> Friday </option>
  <option value ="7"> Saturday </option>
  <option value ="1"> Sunday </option>
</select>

<label for="enddayBox">End Day:</label>
<select id="enddayBox" required>
  <option value=""></option>
  <option value ="2"> Monday  </option>
  <option value ="3"> Tuesday </option>
  <option value ="4"> Wednesday </option>
  <option value ="5"> Thursday </option>
  <option value ="6"> Friday </option>
  <option value ="7"> Saturday </option>
  <option value ="1"> Sunday </option>
</select>

<br>Check to select all Days: <input type="checkbox" name="allDaysCheckBox" value="Yes" onclick="disable('startdayBox', 'enddayBox')">

<br> <br>
<label for="starthourBox">Start hour:</label>
<select  id="starthourBox">
  <option value=""></option>
<?php
  for ($i=0; $i <=23; $i++) {
    ?>
      <option> <?=$i?> </option>
    <?php
  }
?>
</select>

<label for="endhourBox">End hour:</label>
<select  id="endhourBox">
<option value=""></option>
<?php
  for ($i=0; $i <=23; $i++) {
    ?>
      <option> <?=$i?> </option>
    <?php
  }
?>
</select>


<br>Check to select all hours <input type="checkbox" name="allHoursCheckBox" value="Yes" onclick="disable('starthourBox', 'endhourBox')">

<br><br>
<label for="activityBox[]">Select one or more activities</label>
<select multiple = "multiple" name = "activityBox[]" >
  <option value = "IN_VEHICLE"> In Vehicle </option>
  <option value = "ON_BICYCLE"> On Bicycle </option>
  <option value = "ON_FOOT"> On foot </option>
  <option value = "RUNNING"> Running </option>
  <option value = "STILL"> Still </option>
  <option value = "TILTING"> Tilting </option>
  <option value = "UNKNOWN"> Unknown </option>
  <option value = "WALKING"> Walking </option>
  <option value = "IN_ROAD_VEHICLE"> In Road Vehicle </option>
  <option value = "IN_RAIL_VEHICLE"> In Rail Vehicle </option>
  <option value = "IN_FOUR_WHEELER_VEHICLE"> In Four-wheeler Vehicle</option>
  <option value = "IN_CAR"> In Car </option>
</select>

<br>Check to select all Activities: <input type="checkbox" name="allActivitiesCheckBox" value="Yes">

<br> <br>
<button type="submit" name = "dates_button">Submit</button>
</form>


<form action = "admin.php" method="post">
<button type="submit" name="delete_button">Erase Database</button>
</form>

<?php // TODO: HANDLE THE BUTTON ?>
<form action="admin.php" method="post">
  <button type="submit" name="export_button" >Export Data</button>
</form>

<button type="button" name="button2" style="display:none">ERASE</button>


</body>
</html>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin2-3Page</title>
  </head>
  <body>
    <h1>hello</h1>

If you want to select a range for any of the values (Year, Month, Day, Hour) please select 2 options from the boxes <br>
Hold down the Ctrl (Windows) or Command (Mac) button to select multiple options <br> <br>

<form action="admin.php" method="POST">
<label for="yearBox[]">Select a year</label>


  <input type="checkbox" name="yearsCheckBox" value="Yes" onclick="MyFunction();">



<select multiple = "multiple" name="yearBox[]" required>
<?php
  for ($i=1950; $i <=2025; $i++) {
    ?>
      <option value = "<?=$i?>"> <?=$i?> </option>
    <?php
  }
?>
<option value ="all"> All </option>
</select>
<br>
<label for="monthBox[]">Select a month</label>
<select multiple = "multiple" name = "monthBox[]" required>
  <option value = "1"> January</option>
  <option value = "2"> February</option>
  <option value = "3"> March</option>
  <option value = "4"> April</option>
  <option value = "5"> May</option>
  <option value = "6"> June</option>
  <option value = "7"> July</option>
  <option value = "8"> August</option>
  <option value = "9"> September</option>
  <option value = "10"> October</option>
  <option value = "11"> November</option>
  <option value = "12"> December</option>
  <option value ="all"> All </option>
</select>
<br>
<label for="dayBox[]">Select a Day</label>
<select multiple = "multiple" name="dayBox[]" required>
  <option value ="1"> Monday  </option>
  <option value ="2"> Tuesday </option>
  <option value ="3"> Wednesday </option>
  <option value ="4"> Thursday </option>
  <option value ="5"> Friday </option>
  <option value ="6"> Saturday </option>
  <option value ="7"> Sunday </option>
  <option value ="all"> All </option>
</select>
<br>
<label for="hourBox[]">Select an hour</label>
<select multiple = "multiple" name="hourBox[]" required>
<?php
  for ($i=0; $i <=23; $i++) {
    ?>
      <option> <?=$i?> </option>
    <?php
  }
?>
<option value ="all"> All </option>
</select>
<br>
<label for="activityBox[]">Select an activity:</label>
<select multiple = "multiple" name = "activityBox[]" required>
  <option value = "Vehicle"> In Vehicle </option>
  <option value = "Bicycle"> On Bicycle </option>
  <option value = "Onfoot"> On foot </option>
  <option value = "Running"> Running </option>
  <option value = "Still"> Still </option>
  <option value = "Tilting"> Tilting </option>
  <option value = "Unknown"> Unknown </option>
  <option value = "Walking"> Walking </option>
  <option value ="all"> All </option>
</select>

<br> <br>
<button type="submit" name = "heatmap_button">Submit</button>
</form>

<form>
<button type="submit" name="delete_button">Erase Database</button>
</form>




  </body>
</html>

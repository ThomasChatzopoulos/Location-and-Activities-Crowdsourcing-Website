<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"> </script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <title>My chart </title>
</head>
<body>
  <input type="button" value="Click Me" style="float: left;">
  <div class="container">
    <canvas id="activity_chart"> </canvas>
    <canvas id="files_per_user"> </canvas>
    <canvas id="days_chart"> </canvas>
    <canvas id="months_chart"> </canvas>
    <canvas id="hours_chart"> </canvas>
    <canvas id="years_chart"> </canvas>
  </div>
  <?php require 'dashboard.php' ?>
  <script>
   var activities = '<?php echo json_encode($activity_type) ?>';
   activities_obj = JSON.parse(activities);
  </script>
  <script>
   var records = '<?php echo json_encode($record_per_user) ?>';
   records_obj = JSON.parse(records);
  </script>
  <script>
   var days = '<?php echo json_encode($days) ?>';
   days_obj = JSON.parse(days);
  </script>
  <script>
   var months = '<?php echo json_encode($months) ?>';
   months_obj = JSON.parse(months);
  </script>
  <script>
   var hours = '<?php echo json_encode($hours) ?>';
   hours_obj = JSON.parse(hours);
  </script>
  <script>
   var years = '<?php echo json_encode($years) ?>';
   years_obj = JSON.parse(years);
  </script>
  <script src="activity_type_dChart.js"></script>
  <script src="user_files_Chart.js"></script>
  <script src="days_Chart.js"></script>
  <script src="months_Chart.js"></script>
  <script src="hours_Chart.js"></script>
  <script src="years_Chart.js"></script>
</body>
</html>

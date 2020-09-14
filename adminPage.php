<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <!-- https://fonts.google.com/specimen/Roboto -->
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="css/templatemo-style.css">
    <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"> </script> <?php // TODO: MAYBE DELETE ?>
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  </head>


  <body>

    <body id="reportsPage">
        <div class="" id="home">
            <nav class="navbar navbar-expand-xl">
                <div class="container h-100">
                    <a class="navbar-brand" href="admin_page.php">
                        <h1 class="tm-site-title mb-0">Admin</h1>
                    </a>
                    <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars tm-nav-icon"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto h-100">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active"  href="admin_page.php">
                                <i class="far fa-chart-bar"></i>
                                Data analysis
                                <span class="sr-only">(current)</span>
                              </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="accounts.html">
                                    <i class="far fa-user"></i>
                                    Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </a>
                            </li>
                    </div>
                </div>
            </nav>
          </div>
        <div class="container tm-mt-big tm-mb-big martop">
            <div class="row tm-content-row">
                <div class="tm-block-col tm-col-small-selec">
                  <div class="tm-bg-primary-dark cust-tm-block">
                    <div class="text-center">
                      <h2 class="tm-block-title">Year Selection</h2>
                      <label for="startyearBox">Start year:</label>
                        <select class="custom-select" id="startyearBox" name="startyearBox" required>
                          <option value=""></option>
                          <?php for ($i = 20; $i >=0 ; $i--)
                          {
                              $date = date("Y") - $i;
                              echo "<option value='$date'>" . $date . "</option>";
                          }
                          ?>
                        </select>
                        <label for="endyearBox">End year:</label>
                        <select class="custom-select" id="endyearBox" name="endyearBox" required>
                          <option value=""></option>
                          <?php for ($i = 20; $i >=0 ; $i--)
                          {
                              $date = date("Y") - $i;
                              echo "<option value='$date'>" . $date . "</option>";
                          }
                          ?>
                        </select>
                        <br><br>
                        <label for="allYearsCheckBox"><label>Check to select all years</label>
                        <input type="checkbox" name="allYearsCheckBox" id="allYearsCheckBox" onclick="disableFunction('allYearsCheckBox', 'startyearBox', 'endyearBox')"/>
                      </div>
                    </div>
                </div>

                <div class="tm-block-col tm-col-small-selec">
                  <div class="tm-bg-primary-dark cust-tm-block">
                    <div class="text-center">
                      <h2 class="tm-block-title">Month Selection</h2>
                        <label for="startmonthBox">Start month:</label>
                        <select class="custom-select "id = "startmonthBox" name = "startmonthBox" required>
                          <option value=""></option>
                          <?php for ($i = 1; $i <=12 ; $i++)
                          {
                              $month = date('F', mktime(0, 0, 0, $i, 10));
                              echo "<option value='$i'>" . $month . "</option>";
                          }
                          ?>
                        </select>
                        <label for="endmonthBox">End month:</label>
                        <select class="custom-select" id = "endmonthBox" name= "endmonthBox" required>
                          <option value=""></option>
                          <?php for ($i = 1; $i <=12 ; $i++)
                          {
                              $month = date('F', mktime(0, 0, 0, $i, 10));
                              echo "<option value='$i'>" . $month . "</option>";
                          }
                          ?>
                        </select>
                        <br><br> <label for="allMonthsCheckBox"> Check to select all months:</label>
                          <input type="checkbox" name="allMonthsCheckBox" id="allMonthsCheckBox" onclick="disableFunction('allMonthsCheckBox', 'startmonthBox', 'endmonthBox')">
                      </div>
                    </div>
                </div>

                <div class="tm-block-col tm-col-small-selec">
                  <div class="tm-bg-primary-dark cust-tm-block">
                    <div class="text-center">
                      <h2 class="tm-block-title">Day Selection</h2>
                        <label for="startdayBox">Start day:</label>
                        <select class="custom-select" id="startdayBox" name ="startdayBox" required>
                          <option value=""></option>
                          <option value ="0"> Sunday  </option>
                          <option value ="1"> Monday </option>
                          <option value ="2"> Tuesday </option>
                          <option value ="3"> Wednesday </option>
                          <option value ="4"> Thursday </option>
                          <option value ="5"> Friday </option>
                          <option value ="6"> Saturday </option>
                        </select>

                        <label for="enddayBox">End day:</label>
                        <select class="custom-select" id="enddayBox" name = "enddayBox" required>
                          <option value=""></option>
                          <option value ="0"> Sunday  </option>
                          <option value ="1"> Monday </option>
                          <option value ="2"> Tuesday </option>
                          <option value ="3"> Wednesday </option>
                          <option value ="4"> Thursday </option>
                          <option value ="5"> Friday </option>
                          <option value ="6"> Saturday </option>
                        </select>

                        <br><br> <label for="allDaysCheckBox"> Check to select all days:</label>
                        <input type="checkbox" name="allDaysCheckBox" id="allDaysCheckBox" onclick="disableFunction('allDaysCheckBox', 'startdayBox', 'enddayBox')">
                      </div>
                    </div>
                </div>

                <div class="tm-block-col tm-col-small-selec">
                  <div class="tm-bg-primary-dark cust-tm-block">
                    <div class="text-center">
                      <h2 class="tm-block-title">Hour Selection</h2>
                      <label for="starthourBox">Start hour:</label>
                      <select class="custom-select" id="starthourBox" name = "starthourBox" required>
                        <option value=""></option>
                        <?php for ($i = 0; $i <= 23; $i++)
                        {
                          echo "<option value='$i'>" . sprintf("%02d", $i) . "</option>";
                        }
                        ?>
                      </select>
                      <label for="endhourBox">End hour:</label>
                      <select class="custom-select" id="endhourBox" name = "endhourBox" required>
                        <option value=""></option>
                        <?php for ($i = 0; $i <= 23; $i++)
                        {
                          echo "<option value='$i'>" . sprintf("%02d", $i) . "</option>";
                        }
                        ?>
                      </select>
                      <br><br> <label for="allHoursCheckBox"> Check to select all hours:</label>
                      <input type="checkbox" name="allHoursCheckBox" id="allHoursCheckBox" onclick="disableFunction('allHoursCheckBox', 'starthourBox', 'endhourBox')">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row tm-content-row">
                <div class="tm-block-col">
                  <div class="tm-bg-primary-dark cust2-tm-block tm-block-scroll">
                    <div class="text-center">
                      <h2 class="tm-block-title">Activity Selection</h2>
                      <table class="table" id="act_table">  </table>
                      <br>  Check to select all Activities: <input type="checkbox" name="allActivitiesCheckBox" id="allActivitiesCheckBox" onclick = "disableActivities('allActivitiesCheckBox')">
                    </div>
                  </div>
                </div>
                <div class="tm-block-col">
                  <div class="mapstyle" id="mapid"></div>
                </div>
                 <script src="heatmap.js"></script>
              </div>
              <div class="row tm-content-row">
                <p align = "center">
                  <button class="btn-primary" type="submit" id = "dates_button" name="dates_button" onclick="date_ranges('true', 'false')">Submit date range</button>
                </p>
              </div>
            <div class="row tm-content-row">
              <div class="tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                  <div class="text-center">
                    <h2 class="tm-block-title"> Export Data </h2>
                      <label for="exportselectBox">What type do you want the data to be?</label>
                      <br> <select class ="custom-select" name="exportselectBox" id="exportselectBox" required>
                        <option value="json">json</option>
                        <option value="xml">xml</option>
                        <option value="csv">csv</option>
                      </select>
                      <br><br> <button class="btn-primary" type="submit" name="export_button" id="export_button" onclick="date_ranges('false', 'true')">Export Data</button>
                      <div class="output">
                        <h3 id="download" hidden></h3>
                      </div>
                    </div>
                </div>
              </div>

              <div class="tm-col-small">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                  <div class="text-center">
                    <h2 class="tm-block-title"> Erase Database </h2>
                    <form action = "admin.php" method="post">
                      <p align ="center">
                        If you press this button you will erase the database <br><br>
                        <button class="btn-primary" type="submit" onclick="return confirm('Are you sure to delete?')" id = "erase_database" name="delete_button">Erase Database</button>
                      </p>
                    </form>
                </div>
              </div>
          </div>
        </div>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/activities_from_db.js"></script>
        <script src="js/erase_database.js"></script>
        <script src="js/disable_function.js"></script>
        <!-- <script src="js/admin_years_loop.js"></script>
        <script src="js/admin_hours_loop.js"></script> -->
        <script src="js/ajax_admin.js"></script>
  </body>
</html>

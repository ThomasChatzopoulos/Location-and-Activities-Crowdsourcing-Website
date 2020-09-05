<!DOCTYPE html>

<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>user Page</title>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"> </script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
  </head>

  <body id="reportsPage">
    <div class="" id="home">
      <nav class="navbar navbar-expand-xl">
        <div class="container h-100">
          <a class="navbar-brand" href="userDashboard.php">
            <h1 class="tm-site-title mb-0" id = 'user_name'></h1>
          </a>
          <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars tm-nav-icon"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto h-100">
              <li class="nav-item">
                <a class="nav-link active" href="userDashboard.php">
                  <i class="fas fa-tachometer-alt"></i>
                  Dashboard
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="userDataAnalysisPage.php">
                  <i class="far fa-chart-bar"></i>
                  Data analysis
                  <span class="sr-only">(current)</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="file_upload_page.php">
                  <i class="fas fa-upload"></i>
                  File upload
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="accounts.php">
                  <i class="far fa-user"></i>
                  Account
                </a>
              </li>
            </ul>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link d-block" href="login.html">
                  <b>Logout</b>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="container">
        <div class="row tm-content-row">
        <!-- <form action="userDataAnalysis.php" method="POST"> -->
        <div class="tm-block-col tm-col-small">
          <div class="tm-bg-primary-dark tm-block">
            <div class="text-center">
              <h2 class="tm-block-title">Year Selection</h2>
              <label for="startyearBox">Start year:</label>
                <select class="custom-select" id="startyearBox" name="startyearBox"  required>
                  <option value=""></option>
                  <?php for ($i = 0; $i <= 20; $i++)
                  {
                      $date = date("Y") - $i;
                      echo "<option value='$date'>" . $date . "</option>";
                  }
                  ?>
                </select>
                <label for="endyearBox">End year:</label>
                <select class="custom-select" id="endyearBox" name="endyearBox" required>
                  <option value=""></option>
                  <?php for ($i = 0; $i <= 20; $i++)
                  {
                      $date = date("Y") - $i;
                      echo "<option value='$date'>" . $date . "</option>";
                  }
                  ?>
                </select>
                <br><br> <label for="allYearsCheckBox"> Check to select all years:</label>
                <input type="checkbox" name="allYearsCheckBox" id="allYearsCheckBox" value="Yes" onclick="disableFunction('allYearsCheckBox','startyearBox', 'endyearBox')">
              </div>
            </div>
          </div>

          <div class="tm-block-col tm-col-small">
            <div class="tm-bg-primary-dark tm-block">
              <div class="text-center">
                <h2 class="tm-block-title">Month Selection</h2>
                  <label for="startmonthBox">Start month:</label>
                  <select class="custom-select "id = "startmonthBox" name = "startmonthBox" required>
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
                  <select class="custom-select" id = "endmonthBox" name= "endmonthBox" required>
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
                  <br><br> <label for="allMonthsCheckBox"> Check to select all months:</label>
                  <input type="checkbox" name="allMonthsCheckBox" id="allMonthsCheckBox" value="Yes" onclick="disableFunction('allMonthsCheckBox','startmonthBox', 'endmonthBox')">
                </div>
              </div>
            </div>
            <!-- </form> -->
          </div>

          <div class="row tm-content-row">
            <p align = "center">
              <button class="btn-primary" type="submit" id = "dates_button" name="dates_button" onclick="chart_date_range('true')">Go!</button>
            </p>
          </div>


          <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
              <div class="tm-bg-primary-dark tm-block">
                <h2 class="tm-block-title">Activity types chart</h2>
                <canvas id="activity_chart"></canvas>
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
              <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <h2 class="tm-block-title">Activity type distribution</h2>
                <table class="table" id="act_table">
                  <thead>
                    <tr>
                      <th style='text-align:center;' scope="col">ACTIVITY TYPE</th>
                      <th style='text-align:center;' scope="col">COLOR</th>
                      <th style='text-align:center;' scope="col">RECORDS NO.</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>

          <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
              <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
              <h2 class="tm-block-title">Best <b>hour</b> for each activity</h2>
                <table class="table" id="activities_per_hour_table">
                  <thead>
                    <tr>
                      <th style='text-align:center;' scope="col">Activity</th>
                      <th style='text-align:center;' scope="col">Hour</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
              <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <h2 class="tm-block-title">Best <b>day</b> for each activity</h2>
                <table class="table" id="activities_per_day_table">
                  <thead>
                    <tr>
                      <th style='text-align:center;' scope="col">Activity</th>
                      <th style='text-align:center;' scope="col">Day</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>

    <script>
      Chart.defaults.global.defaultFontColor = 'white';
    </script>

  <!-- <script src="js/user_months_Chart.js"></script> -->
  <script src="js/connected_user_name.js"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <!-- https://jquery.com/download/ -->
  <script src="js/moment.min.js"></script>
  <script src="js/disable_function.js"></script>
  <script src="js/dataAnalysis.js"></script>

  <!-- https://momentjs.com/ -->
  <!-- <script src="js/Chart.min.js"></script> -->
  <!-- http://www.chartjs.org/docs/latest/ -->
  <script src="js/bootstrap.min.js"></script>
  <!-- https://getbootstrap.com/ -->

</body>
</html>

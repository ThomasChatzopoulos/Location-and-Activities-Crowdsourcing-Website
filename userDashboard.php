<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>

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
                  <a class="nav-link active" href="#">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                    <span class="sr-only">(current)</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="userDataAnalysisPage.php">
                    <i class="far fa-chart-bar"></i>
                    Data analysis
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="file_upload_page.php">
                    <i class="fas fa-upload"></i>
                    File upload
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="accountPage.php">
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
              </ul>
            </div>
          </div>
        </nav>

        <div class="container">

          <br /><br />
          <h1 style='color:white; text-align:center;'  id = 'user_score'></h1>
          <br /><br />

          <div class="row tm-content-row">

          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block">
              <h2 class="tm-block-title">Month Distribution Chart</h2>
              <canvas id="user_months_chart"></canvas>
            </div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
            <h2 class="tm-block-title">Score for 12 last months</h2>
              <table class="table" id="score_table">
              <thead>
                <tr>
                  <th style='text-align:center;' scope="col">MONTH</th>
                  <th style='text-align:center;' scope="col">COLOR</th>
                  <th style='text-align:center;' scope="col">SCORE</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
            <h2 class="tm-block-title">Files details</h2>
            <table class="table" id="file_table"></table>
          </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
          <h2 class="tm-block-title">Top 3 user and you for the current month</h2>
            <table class="table" id ="top_users_table">
              <thead>
                <tr>
                  <th style='text-align:center;' scope="col">Rank</th>
                  <th style='text-align:center;' scope="col">User</th>
                  <th style='text-align:center;' scope="col">Eco percent</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script>
      Chart.defaults.global.defaultFontColor = 'white';
    </script>

  <script src="js/user_months_Chart.js"></script>
  <script src="js/top_3_users.js"></script>
  <script src="js/user_file_data.js"></script>
  <script src="js/user_score.js"></script>
  <script src="js/connected_user_name.js"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>

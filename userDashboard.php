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
    <?php require 'userData.php' ?>
      <div class="" id="home">
          <nav class="navbar navbar-expand-xl">
              <div class="container h-100">
                  <a class="navbar-brand" href="userDashboard.php">
                      <h1 class="tm-site-title mb-0">User</h1>
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
                              <a class="nav-link" href="products.html">
                                  <i class="fas fa-shopping-cart"></i>
                                  Report
                              </a>
                          </li>

                          <li class="nav-item">
                              <a class="nav-link" href="products.html">
                                  <i class="fas fa-shopping-cart"></i>
                                  Products
                              </a>
                          </li>

                          <li class="nav-item">
                              <a class="nav-link" href="accounts.html">
                                  <i class="far fa-user"></i>
                                  Accounts
                              </a>
                          </li>
                      </ul>
                      <ul class="navbar-nav">
                          <li class="nav-item">
                              <a class="nav-link d-block" href="login.html">
                                  User, <b>Logout</b>
                              </a>
                          </li>
                      </ul>
                  </div>
              </div>

          </nav>
          <div class="container">
              <div class="row">
                  <div class="col">
                      <p class="text-white mt-5 mb-5">Welcome back, <b>User</b></p>
                  </div>
              </div>
              <!-- row -->

              <h1 style="color:white; text-align:center;">Your score for <?php echo date('F',time())?> : <?php echo $this_month_score?>%</h1>

              <div class="row tm-content-row">

                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Month Distribution Chart</h2>
                        <canvas id="user_months_chart"></canvas>
                    </div>
                </div>
                <script>
                var colours_months = '<?php echo json_encode($colours_months) ?>';
                colours_obj_months = JSON.parse(colours_months);
                var months = '<?php echo json_encode($user_score) ?>';
                months_obj = JSON.parse(months);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Score for 12 last months</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style='text-align:center;' scope="col">MONTH</th>
                                    <th style='text-align:center;' scope="col">COLOR</th>
                                    <th style='text-align:center;' scope="col">SCORE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($user_score as $key => $value) {
                                  echo "<tr>";
                                  echo "<th style='text-align:center;'scope='row'><b>{$key}</b></th>";
                                  echo "<td style='text-align:center; background-color:$colours_months[$counter]'></td>";
                                  echo "<td style='text-align:center;'><b>{$value}</b>%</td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Files</h2>
                        <table class="table">
                            <tbody>
                                <?php
                                  echo "<tr>";
                                  echo "<th>First record<b></b></th>";
                                  echo "<th scope='row'><b>$first_record</b></th>";
                                  echo "</tr>";
                                  echo "<tr>";
                                  echo "<th>Last record<b></b></th>";
                                  echo "<th scope='row'><b>$last_record</b></th>";
                                  echo "</tr>";
                                  echo "<tr>";
                                  echo "<th>Last file upload<b></b></th>";
                                  echo "<th scope='row'><b>$last_upload_date</b></th>";
                                  echo "</tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Top 3 user and you</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style='text-align:center;' scope="col">Rank</th>
                                    <th style='text-align:center;' scope="col">User</th>
                                    <th style='text-align:center;' scope="col">Eco percent</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                                $user_names_query = sprintf("SELECT name, surname FROM user WHERE userId = '%s'", mysqli_real_escape_string($conn,$connected_user_id));
                                $user_names_result = mysqli_query($conn, $user_names_query);
                                if(!$user_names_result){
                                  echo "SQL error <br>";
                                  exit();
                                }
                                while ($row = mysqli_fetch_assoc($user_names_result)) {
                                  $user_name = sprintf($row['name']." ". substr($row['surname'],0,1));
                                }
                                $counter = 1;
                                foreach ($top_users as $key => $value) {
                                  if($key != $user_name){
                                    echo "<tr>";
                                    echo "<th style='text-align:center;'><b>{$counter}</b></th>";
                                    echo "<th scope='row'; style='text-align:center;'><b>{$key}</b></th>";
                                    echo "<td style='text-align:center;'><b>{$value}%</b></td>";
                                    echo "</tr>";
                                  }
                                  else{
                                    echo "<tr>";
                                    echo "<th bgcolor='#51A77E'; style='text-align:center;'><b>{$counter}</b></th>";
                                    echo "<th bgcolor='#51A77E'; scope='row'; style='text-align:center;'><b>{$key}</b></th>";
                                    echo "<td bgcolor='#51A77E'; style='text-align:center;'><b>{$value}%</b></td>";
                                    echo "</tr>";
                                  }
                                  $counter += 1;
                                }
                              ?>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
              
      <script src="user_months_Chart.js"></script>


      <script src="js/jquery-3.3.1.min.js"></script>
      <!-- https://jquery.com/download/ -->
      <script src="js/moment.min.js"></script>
      <!-- https://momentjs.com/ -->
      <!-- <script src="js/Chart.min.js"></script> -->
      <!-- http://www.chartjs.org/docs/latest/ -->
      <script src="js/bootstrap.min.js"></script>
      <!-- https://getbootstrap.com/ -->

  </body>

</html>

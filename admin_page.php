<!DOCTYPE html>
<html lang="en">

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
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                <span>
                                    Settings <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Billing</a>
                                <a class="dropdown-item" href="#">Customize</a>
                            </div>
                        </li>
                    </ul> -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link d-block" href="login.html">
                                Admin, <b>Logout</b>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-white mt-5 mb-5">Welcome back, <b>Admin</b></p>
                </div>
            </div>
            <!-- row -->
            <div class="row tm-content-row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Activity types chart</h2>
                        <canvas id="activity_chart"></canvas>
                    </div>
                </div>
                <?php require 'dashboard.php' ?>
                <script>
                var colours_act = '<?php echo json_encode($colours_act) ?>';
                colours_obj_act = JSON.parse(colours_act);
                 var activities = '<?php echo json_encode($activity_type) ?>';
                 activities_obj = JSON.parse(activities);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Activity type distribution</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ACTIVITY TYPE</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($activity_type_table as $key => $value) {
                                  echo "<tr>";
                                  echo "<th scope='row'><b>{$key}</b></th>";
                                  echo "<td style='background-color:$colours_act[$counter]'></td>";
                                  echo "<td><b>{$value}</b></td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Record number chart</h2>
                        <canvas id="files_per_user"></canvas>
                    </div>
                </div>
                <script>
                var colours_rec = '<?php echo json_encode($colours_rec) ?>';
                colours_obj_rec = JSON.parse(colours_rec);
                var records = '<?php echo json_encode($record_per_user) ?>';
                records_obj = JSON.parse(records);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Files per User</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">USERNAME</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($record_per_user_table as $key => $value) {
                                  echo "<tr>";
                                  echo "<th scope='row'><b>{$key}</b></th>";
                                  echo "<td style='background-color:$colours_rec[$counter]'></td>";
                                  echo "<td><b>{$value}</b></td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Hour Distribution Chart</h2>
                        <canvas id="hours_chart"></canvas>
                    </div>
                </div>
                <script>
                var colours_hours = '<?php echo json_encode($colours_hours) ?>';
                colours_obj_hours = JSON.parse(colours_hours);
                var hours = '<?php echo json_encode($hours) ?>';
                hours_obj = JSON.parse(hours);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Hour</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">HOUR</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($hours_table as $key => $value) {
                                  echo "<tr>";
                                  echo "<th scope='row'><b>{$key}</b></th>";
                                  echo "<td style='background-color:$colours_hours[$counter]'></td>";
                                  echo "<td><b>{$value}</b></td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Hour Distribution Chart</h2>
                        <canvas id="months_chart"></canvas>
                    </div>
                </div>
                <script>
                var colours_months = '<?php echo json_encode($colours_months) ?>';
                colours_obj_months = JSON.parse(colours_months);
                var months = '<?php echo json_encode($months) ?>';
                months_obj = JSON.parse(months);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Month</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">MONTH</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($months_table as $key => $value) {
                                  echo "<tr>";
                                  echo "<th scope='row'><b>{$key}</b></th>";
                                  echo "<td style='background-color:$colours_months[$counter]'></td>";
                                  echo "<td><b>{$value}</b></td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Year Distribution Chart</h2>
                        <canvas id="years_chart"></canvas>
                    </div>
                </div>
                <script>
                var colours_years = '<?php echo json_encode($colours_years) ?>';
                colours_obj_years = JSON.parse(colours_years);
                var years = '<?php echo json_encode($years) ?>';
                years_obj = JSON.parse(years);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Year</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">YEAR</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($years_table as $key => $value) {
                                  echo "<tr>";
                                  echo "<th scope='row'><b>{$key}</b></th>";
                                  echo "<td style='background-color:$colours_years[$counter]'></td>";
                                  echo "<td><b>{$value}</b></td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Days Distribution Chart</h2>
                        <canvas id="days_chart"></canvas>
                    </div>
                </div>
                <script>
                var colours_days = '<?php echo json_encode($colours_days) ?>';
                colours_obj_days = JSON.parse(colours_days);
                var days = '<?php echo json_encode($days) ?>';
                days_obj = JSON.parse(days);
                </script>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Day</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">DAY</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter =0 ;
                                foreach ($days_table as $key => $value) {
                                  echo "<tr>";
                                  echo "<th scope='row'><b>{$key}</b></th>";
                                  echo "<td style='background-color:$colours_days[$counter]'></td>";
                                  echo "<td><b>{$value}</b></td>";
                                  echo "</tr>";
                                  $counter += 1;
                                }
                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>

    <script src="activity_type_dChart.js"></script>
    <script src="user_files_Chart.js"></script>
    <script src="hours_Chart.js"></script>
    <script src="months_Chart.js"></script>
    <script src="years_Chart.js"></script>
    <script src="days_Chart.js"></script>

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

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
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Activity type distribution</h2>
                        <table class="table" id="act_table">
                            <thead>
                                <tr>
                                    <th scope="col">ACTIVITY TYPE</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Record number chart</h2>
                        <canvas id="files_per_user"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Files per User</h2>
                        <table class="table" id="files_table">
                            <thead>
                                <tr>
                                    <th scope="col">USERNAME</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Hour Distribution Chart</h2>
                        <canvas id="hours_chart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Hour</h2>
                        <table class="table" id="hours_table">
                            <thead>
                                <tr>
                                    <th scope="col">HOUR</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Month Distribution Chart</h2>
                        <canvas id="months_chart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Month</h2>
                        <table class="table" id="months_table">
                            <thead>
                                <tr>
                                    <th scope="col">MONTH</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Year Distribution Chart</h2>
                        <canvas id="years_chart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Year</h2>
                        <table class="table" id="years_table">
                            <thead>
                                <tr>
                                    <th scope="col">YEAR</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Days Distribution Chart</h2>
                        <canvas id="days_chart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Records per Day</h2>
                        <table class="table" id="days_table">
                            <thead>
                                <tr>
                                    <th scope="col">DAY</th>
                                    <th scope="col">COLOR</th>
                                    <th scope="col">RECORDS NO.</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
    </div>

    <script>
      Chart.defaults.global.defaultFontColor = 'white';
    </script>
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
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->

</body>

</html>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"> </script>
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
        <div class="container tm-mt-big tm-mb-big">
            <div class="row">
                <div class="col">
                    <p class="text-white mt-5 mb-5 text-center">Welcome back, <b>Admin</b></p>
                </div>
            </div>
          <form action="admin.php" method="POST">
            <div class="row tm-content-row">
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
                        <br><br>
                        <label for="allYearsCheckBox"><label>Check to select all years</label>
                        <input type="checkbox" name="allYearsCheckBox" id="allYearsCheckBox" value="Yes" onclick="disableFunction('allYearsCheckBox', 'startyearBox', 'endyearBox')"/>
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
                          <input type="checkbox" name="allMonthsCheckBox" id="allMonthsCheckBox" value="Yes" onclick="disableFunction('allMonthsCheckBox', 'startmonthBox', 'endmonthBox')">
                      </div>
                    </div>
                </div>

                <div class="tm-block-col tm-col-small">
                  <div class="tm-bg-primary-dark tm-block">
                    <div class="text-center">
                      <h2 class="tm-block-title">Day Selection</h2>
                        <label for="startdayBox">Start day:</label>
                        <select class="custom-select" id="startdayBox" name ="startdayBox" required>
                          <option value=""></option>
                          <option value ="2"> Monday  </option>
                          <option value ="3"> Tuesday </option>
                          <option value ="4"> Wednesday </option>
                          <option value ="5"> Thursday </option>
                          <option value ="6"> Friday </option>
                          <option value ="7"> Saturday </option>
                          <option value ="1"> Sunday </option>
                        </select>

                        <label for="enddayBox">End day:</label>
                        <select class="custom-select" id="enddayBox" name = "enddayBox" required>
                          <option value=""></option>
                          <option value ="2"> Monday  </option>
                          <option value ="3"> Tuesday </option>
                          <option value ="4"> Wednesday </option>
                          <option value ="5"> Thursday </option>
                          <option value ="6"> Friday </option>
                          <option value ="7"> Saturday </option>
                          <option value ="1"> Sunday </option>
                        </select>

                        <br><br> <label for="allYearsCheckBox"> Check to select all days:</label>
                        <input type="checkbox" name="allDaysCheckBox" id="allDaysCheckBox" value="Yes" onclick="disableFunction('allDaysCheckBox', 'startdayBox', 'enddayBox')">
                      </div>
                    </div>
                </div>

                <div class="tm-block-col tm-col-small">
                  <div class="tm-bg-primary-dark tm-block">
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
                      <input type="checkbox" name="allHoursCheckBox" id="allHoursCheckBox" value="Yes" onclick="disableFunction('allHoursCheckBox', 'starthourBox', 'endhourBox')">
                    </div>
                  </div>
                </div>
              </div>
                <div class="tm-block-col">
                  <div class="tm-bg-primary-dark tm-block tm-block-scroll">
                    <div class="text-center">
                      <h2 class="tm-block-title">Activity Selection</h2>
                      <table class="table" id="act_table">  </table>
                      <br>  Check to select all Activities: <input type="checkbox" name="allActivitiesCheckBox" id="allActivitiesCheckBox"
                      value="Yes" onclick = "disableActivities('allActivitiesCheckBox')">
                    </div>
                  </div>
                </div>
                <p align = "center">
                  <button class="btn-primary" type="submit" id = "dates_button" name="dates_button">Submit date range</button>
                </p>
          </form>

            <div class="row tm-content-row">
              <div class="tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                  <div class="text-center">
                    <h2 class="tm-block-title"> Export Data </h2>
                    <form action="admin.php" method="post">
                      <label for="exportselectBox">What type do you want the data to be?</label>
                      <br> <select class ="custom-select" name="exportselectBox" required>
                        <option value=""></option>
                        <option value="json">json</option>
                        <option value="xml">xml</option>
                        <option value="csv">csv</option>
                      </select>
                      <br><br> <button class="btn-primary" type="submit" name="export_button" >Export Data</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="tm-col-small">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                  <div class="text-center">
                    <h2 class="tm-block-title"> Erase Database </h2>
                    <form action = "admin.php" method="post">
                      <p align ="center">
                        If you press this button you will erase the database <br><br>
                        <button class="btn-primary" type="submit" name="delete_button">Erase Database</button>
                      </p>
                    </form>
                </div>
              </div>
          </div>
        </div>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/activities_from_db.js"></script>
        <script src="js/disable_function.js"></script>
        <!-- <script src="js/admin_years_loop.js"></script>
        <script src="js/admin_hours_loop.js"></script> -->
        <script src="js/ajax_admin.js"></script>
  </body>
</html>

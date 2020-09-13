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
      <title>File upload</title>

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
      <!-- https://fonts.google.com/specimen/Roboto -->
      <link rel="stylesheet" href="css/fontawesome.min.css">
      <!-- https://fontawesome.com/ -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- https://getbootstrap.com/ -->
      <link rel="stylesheet" href="css/templatemo-style.css">

      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
      <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

      <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
      </script>
  </head>

  <body id="reportsPage">
    <div class="" id="home">
      <nav class="navbar navbar-expand-xl">
        <div class="container h-100">
          <a class="navbar-brand" href="file_upload_page.php">
            <h1 class="tm-site-title mb-0" id = 'user_name'></h1>
          </a>
          <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars tm-nav-icon"></i>
          </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mx-auto h-100">
                <li class="nav-item">
                  <a class="nav-link" href="userDashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="adminPage.php">
                    <i class="far fa-chart-bar"></i>
                    Data analysis
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link active" href="#">
                    <i class="fas fa-upload"></i>
                    File upload
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
              </ul>
            </div>
          </div>
        </nav>

        <div class="container">
          <div class="colored-box custom-block-color ">
            <h4 style='color:white; text-align:left;'> Steps to upload file: </h4>
            <h5 style='color:white; text-align:left;'> <i class="far fa-check-square"></i> Draw any rectangles in the map to hide places with sensitive data!</h5>
            <h5 style='color:white; text-align:left;'> <i class="far fa-check-square"></i> To upload a new file click the button "Choose File"</h5>
          </div>
          <br />
          <div class="row">
            <div class="mapstyle2" id="mapid2"></div>
          </div>
          <script src="polygon.js"></script>
          <div class="row tm-content-row">
            <div class="center">
              <p id="msg"></p>
              <form id="file_form" enctype="multipart/form-data">
                <input style='color:white;' type="file" id="file" name="file" />
                <button class="btn-primary" id="upload">Upload</button>
              </form>
            </div>
          </div>
        </div>

  <script src="js/file_upload.js"></script>
  <script src="js/connected_user_name.js"></script>
  <script src="js/user_last_upload.js"></script>


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

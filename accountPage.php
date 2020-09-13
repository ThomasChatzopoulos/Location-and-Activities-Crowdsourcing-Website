<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Account Information</title>
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:400,700"
  />
  <!-- https://fonts.google.com/specimen/Open+Sans -->
  <link rel="stylesheet" href="css/fontawesome.min.css" />
  <!-- https://fontawesome.com/ -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="css/templatemo-style.css">
</head>

<body>
  <nav class="navbar navbar-expand-xl">
    <div class="container h-100">
      <a class="navbar-brand" href="accountPage.php">
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
              <a class="nav-link active" href="accountPage.php">
                <i class="far fa-user"></i>
                Account
                <span class="sr-only">(current)</span>
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
  <div class="container tm-mt-big tm-mb-big">
    <div class="row">
      <div class="col-12 mx-auto tm-login-col">
        <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
          <div class="row">
            <div class="col-12 text-center">
              <h2 class="tm-block-title mb-4">Account Information</h2>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <form action="account.php" method = "POST" class="tm-login-form center">
                <label for="name_label" style="color:white;" >First name</label><br>
                <input type="text" id="name_label" name="name_label" value=""></input>

                <br><label for="last_label" style="color:white;">Last name</label><br>
                <input type="text" id="last_label" name="last_label" value=""></input>

                <br><label for="username_label" style="color:white;">Username</label><br>
                <input type="text" id="username_label" name="username_label" value=""></input>

                <br><label for="email_label" style="color:white;">e-mail</label><br>
                <input type="email" id="email_label" name="email_label" value="" disabled></input>
              </form>

              <p align ="center">
                <br><button class="btn-primary" type="submit" onclick="change_data()" id = "change_data" name="change_button">Change data</button>
                <button class="btn-primary" type="submit" onclick="save_data()" id = "save_data" name="Save_button">Save</button>
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/account.js"></script>

</body>
</html>

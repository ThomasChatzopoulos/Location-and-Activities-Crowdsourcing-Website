<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sign Up</title>
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
  <div class="container tm-mt-big tm-mb-big">
    <div class="row">
      <div class="col-12 mx-auto tm-login-col">
        <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
          <div class="row">
            <div class="col-12 text-center">
              <h2 class="tm-block-title mb-4">Sign Up to Heat</h2>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <form action="signUp.php" method = "POST" class="tm-login-form">
                <div class="form-group">
                <label for="username">Username</label>
                <input name="username" type="text" class="form-control validate" id="_username_" required />
              </div>
              <div class="form-group mt-3">
                <label for="password">Password</label>
                <input name="password" type="password" class="form-control validate" id="_password_" required />
              </div>
              <div class="form-group mt-3">
                <label for="password2">Repeat Password</label>
                <input name="password2" type="password" class="form-control validate" id="_Rpassword_" required />
              </div>
              <div class="form-group mt-3">
                <label for="fname">First Name</label>
                <input name="fname" type="text" class="form-control validate" id="_fname_" required />
              </div>
              <div class="form-group mt-3">
                <label for="lname">Last Name</label>
                <input name="lname" type="text" class="form-control validate" id="_lname_" required />
              </div>
              <div class="form-group mt-3">
                <label for="email">Email</label>
                <input name="email" type="email" class="form-control validate" id="_email_" required />
              </div>
                <div class="form-group mt-4">
                  <button type="submit" name = "sign_button" class="btn btn-primary btn-block text-uppercase" id="_sign-but_">Sign Up</button>
                </div>
                <p class="form-message center"></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="ajax_signup.js"></script>
</body>
</html>

<?php
session_start();
?>

<!DOCTYPE hmtl>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SignUpPage</title>
</head>
<body>
  <h2>Sign Up</h2>
  <p>Please fill in this form to create an account.</p>
  <form action="signUp.php" method = "POST">
    Username: <input type="text" name="username" placeholder="Enter username" required><br>
    Password: <input type="password" name="psw" placeholder="Enter Password" required><br>
    Repeat Password: <input type="password" name="psw_repeat" placeholder="Repeat Password" required><br>
    First Name: <input type="text" name="fname" placeholder="Enter First Name" required><br>
    Last Name: <input type="text" name="lname" placeholder="Enter Last Name" required><br>
    Email: <input type="email" name="email" placeholder="Enter your email" required><br>
    <button type="submit" name = "signup_button">Sign Up</button>
  </form>
</body>
</html>

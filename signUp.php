<?php
session_start();
?>

<?php
if(isset($_POST['signup_button'])){
  require 'dbconnect.php';

  $username = $_POST['username'];
  $password = $_POST['psw'];
  $Rpassword = $_POST['psw_repeat'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];

if($password != $Rpassword){
  header("Location: SignUpPage.php?error_password&username =".$username."&email=".$email);
  exit();
}
else{
  $sql = "SELECT userId from `user` where userId =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: SignUpPage.php?error=sqlerror");
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
    if($resultCheck > 0){
      header("Location: SignUpPage.php?error=usertaken&email=".$email);
      exit();
    }
    else{
      $sql = "INSERT INTO `user` (userId, name, surname, username, password, email) values (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: SignUpPage.php?error=sqlerror");
        exit();
      }
      else{
        mysqli_stmt_prepare($stmt, $sql);
        $userid = "4";
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, 'isssss', $userid, $fname, $lname, $username, $password, $email);
        if(!mysqli_stmt_execute($stmt)){
            die(mysqli_error($conn));
        }
        header("Location: SignUpPage.php?signup=success");
        exit();
      }
    }
}
mysqli_stmt_close($stmt);
mysqli_stmt_close($conn);
}
}
else{
  header("Location: SignUpPage.php?patates");
}
?>

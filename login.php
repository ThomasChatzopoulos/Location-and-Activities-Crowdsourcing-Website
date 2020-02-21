<?php
session_start();
?>

<?php
if(isset($_POST['login_button'])){
  require 'dbconnect.php';

  $username = $_POST['username'];
  $password = $_POST['psw'];

  $sql = "SELECT userId,password from `user` where userId =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: index.php?error=sqlerror");
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt, "ss", $username, $Hashpass);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
    if($resultCheck != 1){
      header("Location: SignUpPage.php?error=user_doesnt_exist");
      exit();
    }
  }
  $PassCheck = password_verify($password, $Hashpass);
  if($PassCheck == false){
    header("Location: index.php?error=wrong_pass");
    exit();
  }
  else{
    session_start();
    $_SESSION['usrname'] = $username;
    header("Location: modulepage.php?message=login");
    exit();
  }
}
else{
  header("Location: index.php?patates");

}
?>

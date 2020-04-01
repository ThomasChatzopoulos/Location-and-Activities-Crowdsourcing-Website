<?php
if(isset($_POST['submit'])){
  require 'dbconnect.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  $errorU = false;
  $errorP = false;

  $sql = "SELECT password from `user` where username =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    //echo "<span>Error in Sql. Check username and password!</span>";
    $errorU = true;
    $errorP = true;
  }
  else{
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) !=1){
      $errorU = true;
    }
  }
  mysqli_stmt_bind_result($stmt, $Hashpass);
  mysqli_stmt_fetch($stmt);

  $PassCheck = password_verify($password, $Hashpass);
  if($PassCheck == false){
    $errorP = true;
  }

  else{
    session_start();
    $_SESSION['usrname'] = $username;
  }
}
echo json_encode(array($errorU, $errorP));
?>

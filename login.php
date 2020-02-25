<?php
session_start();
?>

<?php
if(isset($_POST['login_button'])){
  require 'dbconnect.php';

  $username = $_POST['username'];
  $password = $_POST['psw'];

  $sql = "SELECT password from `user` where username =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: index.php?error=sqlerror");
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) !=1){
      printf("Number of rows: %d.\n", mysqli_stmt_num_rows($stmt));
      //   header("Location: index.php?error=user_doesnt_exist");
      exit();
    }
  }
  mysqli_stmt_bind_result($stmt, $Hashpass);
  mysqli_stmt_fetch($stmt);

  $PassCheck = password_verify($password, $Hashpass);
  if($PassCheck == false){
    header("Location: index.php?error=wrong_pass");
    exit();
  }
  else{
    session_start();
    $_SESSION['usrname'] = $username;
    header("Location: modulepage.php?login=success");
    exit();
  }
}
else{
  header("Location: index.php?patates");

}
?>

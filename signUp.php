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
  $pattern ="/^.*(?=.{8,})(?=.*\d)(?=.*[a-zA-Z])(?=.*[#$*&@!]+).*$/" ;

if($password != $Rpassword){
  header("Location: SignUpPage.php?error_password&username =".$username."&email=".$email);
  exit();
}
elseif (!preg_match($pattern,$password)) {
  header("Location: SignUpPage.php?".$password."error_password=not_valid");
  exit();
}
else{
  $sql = "SELECT userId from `user` where userId =?";   //Admin$1aaaa
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
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        //2 way encrypted userID
        $cipher = "aes-128-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $userId = base64_encode($iv. openssl_encrypt($email, $cipher, $password, 0, $iv));
        //
        // $c = base64_decode($userId);
        // $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        // $iv = substr($c, 0, $ivlen);
        // $hmac = substr($c, $ivlen);
        //
        mysqli_stmt_bind_param($stmt, 'ssssss', $userId, $fname, $lname, $username, $hashedPwd, $email);
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

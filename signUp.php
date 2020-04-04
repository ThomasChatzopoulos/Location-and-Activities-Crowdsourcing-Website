<?php
$errU = false;
if(isset($_POST['submit_'])){
  require 'dbconnect.php';

  $username = $_POST['username'];
  $password = $_POST['password'];
  $Rpassword = $_POST['rpassword'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pattern ="/^.*(?=.{8,})(?=.*\d)(?=.*[a-zA-Z])(?=.*[#$*&@!]+).*$/" ;

$error_rep_pass = false;
$error_inv_pass = false;
$error_username_taken = false;

if($password != $Rpassword){
  $error_rep_pass = true;
}
if (!preg_match($pattern,$password)) {
  $error_inv_pass = true;
}
if (!$error_rep_pass && !$error_inv_pass){
  $sql = "SELECT userId from `user` where userId =?";   //Admin$1aaaa
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    $errU = true;
  }
  else{
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck = mysqli_stmt_num_rows($stmt);
    if($resultCheck > 0){
      $error_username_taken = false;
    }
    else{
      $sql = "INSERT INTO `user` (userId, name, surname, username, password, email) values (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
        $errU = true;
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
        session_start();
        $_SESSION['username'] = $username;
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
}
}
}
else{
  $errU = true;
}
echo json_encode(array($errU, $error_rep_pass, $error_inv_pass, $error_username_taken));
?>

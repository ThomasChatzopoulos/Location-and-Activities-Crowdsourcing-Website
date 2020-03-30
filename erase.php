<?php
  session_start();
?>

<?php
if(isset($_POST['yes_button'])){
  require 'dbconnect.php';


  $sql = 'DROP DATABASE if exists web_db';
  if (mysqli_query($conn, $sql)) {
      echo "Database web_db was successfully dropped <br>";
  } else {
      echo 'Error dropping database: ';
  }

}elseif (isset($_POST['no_button'])) {
  header("Location: adminPage.php?not_deleted");
}else{
  header("Location: erase.php?fatal_error_major_kappa");
}


?>

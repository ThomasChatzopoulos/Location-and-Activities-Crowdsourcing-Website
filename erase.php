<?php
  session_start();
?>


<?php
if(isset($_POST['yes_button'])){
  // TODO: code to delete database
  require 'dbconnect.php';


  $sql = 'DROP DATABASE if exists web_db';
  if (mysqli_query($conn, $sql)) {
      echo "Database web_db was successfully dropped\n";
  } else {
      echo 'Error dropping database: ' . mysql_error() . "\n";
  }

}elseif (isset($_POST['no_button'])) {
  header("Location: adminPage.php?not_deleted");
}else{
  header("Location: erase.php?fatal_error_major_kappa");
}

?>

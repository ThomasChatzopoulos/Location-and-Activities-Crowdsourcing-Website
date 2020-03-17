<?php
  session_start();
?>


<?php
if(isset($_POST['yes_button'])){
  // TODO: code to delete database
}elseif (isset($_POST['no_button'])) {
  header("Location: adminPage.php?not_deleted");
}else{
  header("Location: erase.php?fatal_error_major_kappa");
}

?>

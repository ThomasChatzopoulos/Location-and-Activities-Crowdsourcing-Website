<?php
  // ini_set​(​'​file_uploads​'​, ​'​1​'​);​
  // ​ini_set​(​'​max_input_vars​'​, ​'​1000000​'​);​
  // ​ini_set​(​'​post_max_size​'​, ​'​6000M​'​);​
  // ​ini_set​(​'​upload_max_filesize​'​, ​'​6000M​'​);​

  $error_file_upload=false;
  $error_file_exists=false;
  $error_no_file=false;
  $error_no_json=false;
  if (isset($_FILES['file']['name'])) {
    $file_name=$_FILES['file']['name'];
    $allowed_extension = array('json');
    $jsonFileType = pathinfo('files_for_upload/' . $_FILES['file']['name'],PATHINFO_EXTENSION);

    if (0 < $_FILES['file']['error']) {
      $error_file_upload =true;
    }
    else {
      if (file_exists('files_for_upload/' . $_FILES['file']['name'])) {
        $error_file_exists =true;
      }
      else {
        if(in_array(strtolower($jsonFileType),$allowed_extension)) {
          $last_uploaded_file_name = rand(100,999).'-'.$_FILES['file']['name'];
          move_uploaded_file($_FILES['file']['tmp_name'], 'files_for_upload/' . $last_uploaded_file_name);
          session_start();
          $_SESSION['last_uploaded_file_name'] = $last_uploaded_file_name;
        }
        else{
          $error_no_json=true;
        }
      }
    }
  }
  else {
    $file_name='';
    $error_no_file=true;
  }
  echo json_encode(array($error_file_upload, $error_file_exists, $error_no_file, $error_no_json,$file_name))
?>

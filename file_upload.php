<?php
  $error_file_upload=false;
  $error_file_exists=false;
  $error_no_file=false;
  $error_no_json=false;
  $last_uploaded_file_name ="";
  if (isset($_FILES['file']['tmp_name'])) {
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
  echo json_encode(array($error_file_upload, $error_file_exists, $error_no_file, $error_no_json,$file_name, $last_uploaded_file_name))
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
</head>
<body>
  <div class="JSON_to_db">
    <h3 align="center">Import JSON File Data into Mysql Database in PHP</h3><br />
      <?php
        $servername = "localhost";
        $dBUsername = "root";
        $dBPaassword = "";
        $dBName = "web_db";

        $conn = mysqli_connect("localhost","root", $dBPaassword, $dBName);

        if(!$conn){
          die("Connection error:" .mysqli_connect_error());
        }
        else{
          echo "Connect Successful!";
        }
        //$query = '';
        //$table_data = '';//temp table for json indexes

        function JSON_to_db($JSON_filename, $db_table_name = "userMapData"){ //$db_table_name = "userMapData".time()

          $data = file_get_contents($JSON_filename); //Read the JSON file in PHP
          $json_obj = json_decode($data, true); //Convert JSON String into PHP Array

          $input_query = "INSERT INTO $db_table_name ("; // insert query for userMapData table
          $input_activity_query ="INSERT INTO user_activity ("; //insert query for user_activiry table

//sos gia to $input_activity_query prepei na kramame kai to timestamp
//diaforetikos tropos apothhkeushs ap'oti exoume dhmiourghsei th bash (activity type)

          reset($json_obj);
          foreach($json_obj as $json_array_key => $value){
            if($json_array_key == "activity"){
              $check_if_column_exists = mysql_query("SHOW COLUMNS FROM user_activity LIKE '$json_array_key'"); //if column exists => $check_if_column_exists=1
              $column_exists = (mysql_num_rows($check_if_column_exists))?TRUE:FALSE;
              if($column_exists){
                $input_activity_query .= $input_activity_query . ",";
              }
              else{
                $alter_query = "ALTER TABLE user_activity ADD $json_array_key int(11);"; //NULL DEFAULT NULL
                $result = mysql_query($alter_query) or die(mysql_error());
                $input_activity_query .= $input_activity_query . ",";
              }
            }

            $check_if_column_exists = mysql_query("SHOW COLUMNS FROM $db_table_name LIKE '$json_array_key'"); //if column exists => $check_if_column_exists=1
            $column_exists = (mysql_num_rows($check_if_column_exists))?TRUE:FALSE;
            if($column_exists){
              $input_query .= $json_array_key . ",";
            }
            else{
              $alter_query = "ALTER TABLE $db_table_name ADD $json_array_key int(11);"; //NULL DEFAULT NULL
              $result = mysql_query($alter_query) or die(mysql_error());
              $input_query .= $json_array_key . ",";
            }
          }
          $input_query = substr_replace($input_query,"",-1);
          $input_query .= ") VALUES (";

          $input_activity_query = substr_replace($input_activity_query,"",-1);
          $input_activity_query .= ") VALUES (";

          reset($json_obj);
          foreach($json_obj as $json_array_key => $value){
            $input_query .= "'" . mysql_real_escape_string($value) . "',";
          }
          $input_query = substr_replace($input_query,"",-1);
          $input_query .= ")";
          $result = mysql_query($input_query) or die(mysql_error());

          echo "done!";
          return true;
        }

        JSON_to_db(data.json);
      ?>
    <br />
  </div>
</body>
</html>

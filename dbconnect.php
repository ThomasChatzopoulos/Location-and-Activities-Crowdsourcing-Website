<?php
$servername = "localhost";
$dBUsername = "root";
$dBPaassword = "";
$dBName = "web_db";

$conn = mysqli_connect("localhost","root", $dBPaassword, $dBName);

if(!$conn){
  die("Connection error:" .mysqli_connect_error());
}

<?php

$servername = "";
$username = "";
$password = "";
$dbName = "";

$link = new mysqli($servername, $username, $password, $dbName);

if($link == false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

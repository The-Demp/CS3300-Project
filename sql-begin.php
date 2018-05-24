<?php
//This intended to be embedded to create a connection that will be used throughout the page.
//Then, close the connection with sql-end.php at the end of the page.

$servername = "cssql.seattleu.edu";
$username = "os_dempseys";
$password = "dhCrcrNy";
$dbname = "os_team07";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
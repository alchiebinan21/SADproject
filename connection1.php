<?php

$dbhost="localhost";
$dbuser="root";
$dbpass="usbw";
$dbname="alpacco";

$conn = mysqli_connect($dbhost,$dbuser,$dbpass);
mysqli_select_db($conn,$dbname);

if (!$conn)
	die('could not'. mysqli_error());




?>
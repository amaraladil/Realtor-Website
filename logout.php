<?php
/*
Group_13 
September 29, 2016
WEBD3201
Log-out page
*/
$title = "Login";
$date = "September 29, 2016";
$filename = "login.php";
$description = "The login page ";
include("header.php");
?>

<?php
session_destroy();
header("Location: login.php");
?>

<?php include 'footer.php'; ?>

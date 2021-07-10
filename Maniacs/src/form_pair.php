<?php

// INITIALISING THE SESSION
session_start();
require_once "config.php";
  
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: student_login.php");
    exit;
}
$email=$_SESSION["username"];
$selectname= "select * from student where email='$email'";
$namequery =  mysqli_query($link,$selectname);
$name = mysqli_fetch_array($namequery);



$select= "select username, email, subjects from teacher";
$sql = mysqli_query($link,$select);

//$row = mysqli_fetch_array($sql);

?>
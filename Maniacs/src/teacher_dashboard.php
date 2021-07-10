<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: teacher_login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      margin: 0;
      font-family: "Lato", sans-serif;
      background-image: url("https://png.pngtree.com/thumb_back/fh260/background/20190221/ourmid/pngtree-teachers-day-poster-background-blackboard-teacher-image_12766.jpg");
      opacity: 0.7;
      background-size: cover;
      font-size: 16px;
      line-height: 1.428571429;
      font-weight: 600;
      color: #fff;
    }

    h1 {
      text-align: center;
      color: #ffff00;
      font-sixe: 28px;
      position: absolute;
      top: 30px;
      left: 760px;
    }

    img {
      border-radius: 50%;
      position: absolute;
      top: 20px;
      left: 1350px;

    }


    .sidebar {
      margin: 0;
      padding: 0;
      width: 200px;
      background-color: #f1f1f1;
      position: fixed;
      height: 100%;
      overflow: auto;
    }

    .sidebar a {
      display: block;
      color: black;
      padding: 16px;
      text-decoration: none;
    }

    .sidebar a.active {
      background-color: #04AA6D;
      color: white;
    }

    .sidebar a:hover:not(.active) {
      background-color: #555;
      color: white;
    }




    @media screen and (max-width: 700px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }

      .sidebar a {
        float: left;
      }

      div.content {
        margin-left: 0;
      }
    }

    @media screen and (max-width: 400px) {
      .sidebar a {
        text-align: center;
        float: none;
      }
    }
  </style>
</head>

<body>
  <h1>Welcome!<b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
  <img src="teachericon.png" width="80" height="80">
  <p>
    <a href="teacher_reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="teacher_logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
  </p>
  <div class="sidebar">
    <a class="active" href="#home">Home</a>
    <a href="EditProfile_Teacher.php">Edit Profile</a>
    <a href="contact_us_teacher.html">Contact Us</a>
  </div>

</body>

</html>
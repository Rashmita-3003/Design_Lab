<?php error_reporting (E_ALL ^ E_NOTICE); ?>

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

$selectsub= "select subjects from student where email='$email'";
$subquery= mysqli_query($link,$selectsub);
$subs= mysqli_fetch_array($subquery);
$subject=explode(",",$subs['subjects']);



//$row = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>select preference</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            body{
                background-image: url(sp_1.png);
                background-size: cover;
                background-repeat: space;
            }
            
            thead, tbody{
                text-align: center;
            }
			
			p{
				text-align:center;
			}
			
        </style>
            
    </head>
    <body>
        <div class="container rounded bg-dark text-white mt-5 mb-5">
            <img class="rounded-circle mx-auto d-block mt-5" src="spicon1.jpg" width="150"><br>
            <div class="d-flex justify-content-center">
                <h3>Hello Dear Learner <?php echo $name['username']?></h3> 
            </div>
			<br><br>
			<form action="new2.php" method="POST">
				<div class="dropdown text-center">
				  
				  <select class="btn btn-warning" name="mysub" value="choose subject">
				    <option value="">Choose subjects</option>
					
					
					</select>
				  
				<input type="submit"  class="btn btn-info" name="selsub" value="Select subject">
						</div>				

			</form>
			<?php
			    if(isset($_POST['selsub']))
				{
					//getting selected subject from student
					$getsub= $_POST["mysub"];
					//echo 'The selected subject is: '.$getsub;
					
				}	
			?>
			
			<br>
			<?php 
			  $select= "select username, email, subjects, qualification from teacher where subjects like '%$getsub%'";
			  $sql = mysqli_query($link,$select);
			?>
            <div class=" d-flex justify-content-center font-weight-bold">
                Please select subject to get available teacher for the subject:
            </div>
            <br><br>
            <form action="new3.php" method="POST">
			
					
                
                <div class="mt-5 text-center">
                    <a href="student_dashboard.php" class="btn btn-outline-secondary" role="button">Back</a>
                    <input type="submit" class="btn btn-success" name="submit" value="Select Preference">
                </div>
            </form>
            <br>
            
        </div>
    </body>
</html>

<?php

if(isset($_POST['submit']))
{
	$checkbox2=$_POST['pref'];  
	$choice ="";
	$size=sizeof($checkbox2);
	$i=0;
    if (is_array($checkbox2) || is_object($checkbox2))
        {
            while($i<$size)  
            {  
              if($i<$size-1)
              $choice .= $checkbox2[$i].", ";  
              else
              $choice .= $checkbox2[$i];
              $i=$i+1;
            }
        }
	//echo $choice;	
	function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
	
	}
  
// Function call
function_alert("Your have chosen :".$choice);
}

?>
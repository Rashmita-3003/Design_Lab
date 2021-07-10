
<?php

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

include 'sp_backend.php';



$subject= view_pref($email);
//echo $name;





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
                <h3>Hello Dear Learner</h3> 
            </div>
			<br><br>
			<form action="" method="POST">
				<div class="dropdown text-center">
				  
				  <select class="btn btn-warning" name="mysub" value="choose subject">
				    <option value="">Choose subjects</option>
					<?php
					$i = 0;
					$arraylength= count($subject);
					
					while($i < $arraylength){
						
						?>
					<option value=<?php echo $subject[$i]?>><?php echo $subject[$i]?></option>
					<?php $i++;
					}
					?>
					
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
			  
			  $sql=get_teacher_choice($getsub);
			  
			?>
            <div class=" d-flex justify-content-center font-weight-bold">
                Please select subject to get available teacher for the subject:
            </div>
            <br><br>
            <form action="" method="POST">
			<?php 
				if(mysqli_num_rows($sql) > 0 && $getsub!=NULL){?>
					<table class="table table-dark table-striped">
						<thead>
						  <tr>
							<th>Name</th>
							<th>Email</th>
							<th>Subjects taught</th>
							<th>Highest Qualification</th>
						  </tr>
						</thead>
						<tbody>
					<?php	
					while($row = mysqli_fetch_array($sql)){?>
						
						  <tr>
							<td><input type="checkbox" class="form-check-input" name="pref[]" value=<?php echo $row['email']?>><?php echo $row['username'] ?></td>
							<td><?php echo $row['email'] ?></td>
							<td><?php echo $row['subjects'] ?></td>
							<td><?php echo $row['qualification'] ?></td>
						  </tr>
						
					<?php }?>
						</tbody>
					</table>
					<?php // Close result set
					//mysqli_free_result($sql);
				} else{?>
					<p>No records matching your prefernces found.</p>
				<?php	
				}
			?> 
					
                <?php
				if(array_key_exists('submit', $_POST)) {
            	send_teacher_choice();	
				}
				?>
                <div class="mt-5 text-center">
                    <a href="student_dashboard.php" class="btn btn-outline-secondary" role="button">Back</a>
                    <input type="submit" class="btn btn-success" name="submit" value="Select Preference">
                </div>
            </form>
            <br>
            
        </div>
    </body>
</html>
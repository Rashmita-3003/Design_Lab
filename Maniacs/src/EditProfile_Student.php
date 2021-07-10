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
$select= "select * from student where email='$email'";
$sql = mysqli_query($link,$select);
$row = mysqli_fetch_array($sql);


?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Student Edit</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>-->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <style>
            body {
                background: #FFD700;
            }

            .form-control:focus {
                box-shadow: none;
                border-color: #BA68C8
            }

            .profile-button {
                background: darkcyan;
                box-shadow: none;
                border: none
            }

            .profile-button:hover {
                background: darkslategrey;
            }

            .profile-button:focus {
                background: #682773;
                box-shadow: none
            }

            .profile-button:active {
                background: #682773;
                box-shadow: none
            }

            .back:hover {
                color: #682773;
                cursor: pointer
            }

            .labels {
                font-size: 11px
            }

            .add-experience:hover {
                background: #BA68C8;
                color: #fff;
                cursor: pointer;
                border: solid 1px #BA68C8
            }
        </style>
            
    </head>
    <body>
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" src="studenticon.jpg" width="150">
                        <span class="font-weight-bold"><?php echo $row['username']?></span>
                        <span class="text-black-50"><?php echo $_SESSION["username"]?></span>
                    </div>    
                </div>
                <div class="col-md-9 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Profile Settings</h4>
                        </div>
                        <form action="" method="POST">
                            <div class="row-mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Email</label>
                                    <input type="email" class="form-control" value=<?php echo $_SESSION["username"]?> readonly=readonly>
                                </div>
                            </div>
                            <div class="row-mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Contact Number</label>
                                    <input type="number" class="form-control" name="tno" value=<?php echo $row['contact_number']?>>
                                </div>
								
                                <div class="col-md-12">
                                    <label class="labels">Address</label><br><?php echo $row['addr']?>
								</div>
								<div class="col-md-12">
                                    <label class="labels"> New Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="If old address is unchanged type again, else enter new address">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Gender</label>
                                    <input type="text" class="form-control" value=<?php echo $row['gender']?> readonly=readonly>
                                </div>
								<div class="col-md-12">
                                    <label class="labels">Guardian name</label><br>
                                    <?php echo $row['guardian_name']?>
                                </div>
								<div class="col-md-12">
                                    <label class="labels">Guardian Number</label>
                                    <input type="number" class="form-control" value=<?php echo $row['guardian_phone']?> readonly=readonly>
                                </div>
								<div class="col-md-12">
                                    <label class="labels">Class</label>
                                    <input type="number" class="form-control" name="sclass" value=<?php echo $row['class']?>>
                                </div>
								<div class="col-md-12">
                                    <label class="labels">Board</label>
									<input type="text" class="form-control" name="sboard" value=<?php echo $row['board']?>>
                                </div>
								
								
                                
                                <div class="col-md-12">
                                    <label class="labels">Preferred medium</label>
									<?php
										$result = mysqli_query($link,"SELECT medium FROM student WHERE email = '$email'"); 
										while($row2 = mysqli_fetch_array($result))
										{
											$med=explode(",",$row2['medium']);
									?>  
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" class="form-check-input" name='medium[]' value="Bengali" <?php if(in_array("Bengali",$med)) { ?> checked="checked" <?php } ?>>Bengali</td>
                                                <td><input type="checkbox" class="form-check-input" name='medium[]' value="English" <?php if(in_array("English",$med)) { ?> checked="checked" <?php } ?>>English</td>
                                                <td><input type="checkbox" class="form-check-input" name='medium[]' value="Hindi" <?php if(in_array("Hindi",$med)) { ?> checked="checked" <?php } ?>>Hindi</td>
										<?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Subjects you want to study</label>
									<?php
										$result = mysqli_query($link,"SELECT subjects FROM student WHERE email = '$email'"); 
										while($row2 = mysqli_fetch_array($result))
										{
											$subs=explode(",",$row2['subjects']);
									?> 
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Bengali" <?php if(in_array("Bengali",$subs)) { ?> checked="checked" <?php } ?>>Bengali</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="English" <?php if(in_array("English",$subs)) { ?> checked="checked" <?php } ?>>English</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Hindi" <?php if(in_array("Hindi",$subs)) { ?> checked="checked" <?php } ?>>Hindi</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Maths" <?php if(in_array("Maths",$subs)) { ?> checked="checked" <?php } ?>>Maths</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="G.K." <?php if(in_array("G.K.",$subs)) { ?> checked="checked" <?php } ?>>G.K.</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Science" <?php if(in_array("Science",$subs)) { ?> checked="checked" <?php } ?>>Science</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="History" <?php if(in_array("History",$subs)) { ?> checked="checked" <?php } ?>>History</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Geography" <?php if(in_array("Geography",$subs)) { ?> checked="checked" <?php } ?>>Geography</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Computer" <?php if(in_array("Computer",$subs)) { ?> checked="checked" <?php } ?>>Computer</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Statistics" <?php if(in_array("Statistics",$subs)) { ?> checked="checked" <?php } ?>>Statistics</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Economics" <?php if(in_array("Economics",$subs)) { ?> checked="checked" <?php } ?>>Economics</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Civics" <?php if(in_array("Civics",$subs)) { ?> checked="checked" <?php } ?>>Civics</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Physical Science" <?php if(in_array("Physical Science",$subs)) { ?> checked="checked" <?php } ?>>Physical Science</td>
                                                <td><input type="checkbox" class="form-check-input" name='sub[]' value="Life Science" <?php if(in_array("Life Science",$subs)) { ?> checked="checked" <?php } ?>>Life Science</td>
										<?php } ?>
												<td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <br><br>
                                <div class="mt-5 text-center">
									<a href="student_dashboard.php" class="btn btn-dark" role="button">Back</a>
                                    <input type="submit" class="btn btn-success" name="update" value="Save Profile">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>

<?php



if(isset($_POST['update']))
{
	$no=$_POST["tno"];
	$add=$_POST["address"];
	//echo $add;
	$class=$_POST["sclass"];
	$board=$_POST["sboard"];
	
	if(!empty($_POST['medium'])) {

      $mediums = implode(",",$_POST['medium']);

      
 
    }
	
	if(!empty($_POST['sub'])) {

      $subjects = implode(",",$_POST['sub']);

      
 
    }

	//$myquery= "UPDATE teacher SET board='".$boards."' where email='$email'";
	$myquery= "UPDATE student SET contact_number=$no, addr='$add', class=$class, board='$board', medium='".$mediums."', subjects='".$subjects."' where email='$email'";
	
	if (mysqli_query($link,$myquery)) 
        {
            echo '<script type="text/javascript"> alert("Data Updated Successfully")</script>';
            //header('Location: teacher_dashboard.php');
        } 
    	
	else{
		echo '<script type="text/javascript"> alert("Data Not Updated")</script>';
		
	}
}

?>
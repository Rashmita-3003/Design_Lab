<?php

// INITIALISING THE SESSION
session_start();
require_once "config.php";
  
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: teacher_login.php");
    exit;
}
$email=$_SESSION["username"];
$select= "select * from teacher where email='$email'";
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
        <title>Let's edit</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>-->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <style>
            body {
                background: darkcyan;
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
                        <img class="rounded-circle mt-5" src="teachericon.png" width="150">
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
                                    <label class="labels">Classes you teach</label>
									<?php
										$result = mysqli_query($link,"SELECT class FROM teacher WHERE email = '$email'"); 
										while($row1 = mysqli_fetch_array($result))
										{
											$class=explode(",",$row1['class']);
									?>    
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" class="form-check-input" name='class[]' value="1 to 4" <?php if(in_array("1 to 4",$class)) { ?> checked="checked" <?php } ?>>1 to 4</td>
                                                <td><input type="checkbox" class="form-check-input" name='class[]' value="5 to 8" <?php if(in_array("5 to 8",$class)) { ?> checked="checked" <?php } ?>>5 to 8</td>
                                                <td><input type="checkbox" class="form-check-input" name='class[]' value="9 and 10" <?php if(in_array("9 and 10",$class)) { ?> checked="checked" <?php } ?>>9 and 10</td>
										<?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Boards you teach</label>
									<?php
										$result = mysqli_query($link,"SELECT board FROM teacher WHERE email = '$email'"); 
										while($row2 = mysqli_fetch_array($result))
										{
											$board=explode(",",$row2['board']);
									?>  
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                
                                                <td><input type="checkbox" class="form-check-input" name='board[]' value="State Board" <?php if(in_array("State Board",$board)) { ?> checked="checked" <?php } ?>>State Board</td>
												<td><input type="checkbox" class="form-check-input" name='board[]' value="ICSE" <?php if(in_array("ICSE",$board)) { ?> checked="checked" <?php } ?>>ICSE</td>
                                                <td><input type="checkbox" class="form-check-input" name='board[]' value="CBSE" <?php if(in_array("CBSE",$board)) { ?> checked="checked" <?php } ?>>CBSE</td>
										<?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Preferred medium</label>
									<?php
										$result = mysqli_query($link,"SELECT medium FROM teacher WHERE email = '$email'"); 
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
                                    <label class="labels">Subjects you teach</label>
									<?php
										$result = mysqli_query($link,"SELECT subjects FROM teacher WHERE email = '$email'"); 
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
                                <div class="col-md-12">
                                    <label class="labels">Highest Qualification</label>
                                    <input type="text" class="form-control" name="qual" value=<?php echo $row['qualification']?>>
                                </div><br><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4>Bank Details</h4>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Bank Name</label>
                                    <input type="text" class="form-control" name="bname" value=<?php echo $row['bank_name']?>>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Bank Account Number</label>
                                    <input type="number" class="form-control" name="accno" value=<?php echo $row['acc_no']?>>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">IFSC</label>
                                    <input type="text" class="form-control" name="ifsc" value=<?php echo $row['IFSC']?>>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Branch</label>
                                    <input type="text" class="form-control" name="branch" value=<?php echo $row['Branch']?>>
                                </div>
                                <br><br>
                                <div class="mt-5 text-center">
									<a href="teacher_dashboard.php" class="btn btn-info" role="button">Back</a>
                                    <input type="submit" class="btn btn-info" name="update" value="Save Profile">
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
	$qua=$_POST["qual"];
	$bankname=$_POST["bname"];
	$bankacc=$_POST["accno"];
	$ifsc=$_POST["ifsc"];
	$branch=$_POST["branch"];
	
	if(!empty($_POST['class'])) {

      $classes = implode(",",$_POST['class']);

      
 
    }
	
	if(!empty($_POST['board'])) {

      $boards = implode(",",$_POST['board']);

      
 
    }
	
	if(!empty($_POST['medium'])) {

      $mediums = implode(",",$_POST['medium']);

      
 
    }
	
	if(!empty($_POST['sub'])) {

      $subjects = implode(",",$_POST['sub']);

      
 
    }

	//$myquery= "UPDATE teacher SET board='".$boards."' where email='$email'";
	$myquery= "UPDATE teacher SET contact_number=$no, addr='$add', class='".$classes."', board='".$boards."', medium='".$mediums."', subjects='".$subjects."', qualification='$qua', bank_name='$bankname', acc_no=$bankacc, IFSC='$ifsc', Branch='$branch' where email='$email'";
	
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
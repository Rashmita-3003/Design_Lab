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
$status = $statusMsg = '';
if(isset($_POST["submit"]))
{ 
    $status = 'error'; 
    if(!empty($_FILES["uploadfile"]["name"])) 
	{ 
        // Get file info 
        $fileName = basename($_FILES["uploadfile"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes))
		{ 
            $image = $_FILES['uploadfile']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            //$insert = $db->query("INSERT into images (image, uploaded) VALUES ('$imgContent', NOW())"); 
            $sql = "INSERT INTO fees (image,email) VALUES ('$imgContent','$email')";
			if ($link->query($sql) === TRUE) 
        	{
				$status = 'success'; 
                $statusMsg = "File uploaded successfully.";     
            }
			else
			{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }
		else
		{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }
	else
	{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
mysqli_close($link);
?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	body {

		font-family: 'PT Sans', sans-serif;
  		font-size: 16px;
  		line-height: 1.428571429;
  		font-weight: 400;
  		color: white;
  
  background-image: url("https://i.pinimg.com/736x/ee/a4/43/eea4436b1056cc0e0f38928d9ce6a9ad.jpg");
  background-size: cover;
  
}
.button{
	background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

	.bank{

		position : absolute;
		top : 15%;
		left : 40%;
		width: 320px;
  		padding: 10px;
  		border: 5px #339966;
  		background: #003333;
  		opacity:0.5;
	}
	.upload{
		position : absolute;
		top : 60%;
		left : 40%;
		width: 320px;
  		padding: 10px;
  		border: 5px #339966;
  		background: #003333;
  		opacity:0.5;


	}
	

</style>
</head>
</html>

<body>



<div class="bank">
<h2> Bank Details of Admin</h2>
<h3> Account Name   : Maniacs </h3>
<h3> Bank Name      : AXIS    </h3>
<h3> Account Number : 12017002002177 </h3>
<h3> IFSC Code      : UTIB0001507 </h3>
<h3> Branch Name    : Dakshineswar  </h3>
</div>


<div class="upload">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<p>Click on the "Choose File" button to upload screenshot of payment :</p>
  <input type="file" id="image" name="uploadfile" value=""/>
  <button type="submit" name="submit" > Submit </button>
  <br>
</form>
<p>
<a href="student_dashboard.php" class="button" >Back</a>
</p>
</div>

</body>
</html>
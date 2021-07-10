<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: student_dashboard.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, pass FROM student WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: student_dashboard.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body{
                margin: 0;
                padding: 0;
                background: url(Home_page_bg3.jpg);
                
                background-size: cover;
                /*background-position: center;*/
                font-family: sans-serif;
                
                    
            }
            .loginbox{
                width: 320px;
                height: 420px;
                background: rgba(0,0,0,0.7);
                
                color: white;
                top: 50%;
                left: 50%;
                position: absolute;
                transform: translate(-50%, -50%);
                box-sizing: border-box;
                padding: 70px 30px;
                border: 1px solid white;
                
            }
            
            .icon{
                width: 100px;
                height: 100px;
                border-radius: 50%;
                position: absolute;
                top: -50px;
                left: calc(50% - 50px);
                margin-bottom: 50px;
                
            }
            
            h1{
                margin: 0;
                padding: 0 0 20px;
                text-align: center;
                font-size: 22px;
            }
            
            .loginbox p{
                margin: 0;
                padding: 0;
                font-weight: bold;
               
            }
            
            .loginbox input{
                width: 100%;
                margin-bottom: 20px;
                color: white;
            }
            
            .loginbox input[type="text"], input[type="password"]{
                border: none;
                border-bottom: 1px solid #fff;
                background: transparent;
                outline: none;
                height: 40px;
                color: #000;
                font-size: 16px;
                
            }
            
            .loginbox input[placeholder="Enter username"]{
                color: white;
            }
            .loginbox input[type="submit"]
            {
                border: none;
                outline: none;
                height: 40px;
                background: #fb2525;
                color: #fff;
                font-size: 18px;
            }
            
            .loginbox input[type="submit"]:hover{
                cursor: pointer;
                background: #ffc107;
                color: #000;
                
            }
            
            .loginbox a{
                text-decoration: none;
                font-size: 12px;
                line-height: 20px;
                color: teal;
            }
            
            .loginbox a:hover{
                color: yellow;
                font-width:bold;
            }
			
			
        </style>
</head>
<body>
    <div class="loginbox">
        
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
            <img src="login_icon2.png" class="icon">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p>Username</p>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter username">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                <p>Password</p>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter password">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <input type="submit" value="Login">
                <a href="Student_forgetpassword.php">Forgot Password?</a><br>
                <a href="Registration_Student.php">Don't have an account?Register here!</a>
				<div class="mt-5 text-center">
                <a href="Homepage.html" class="btn btn-dark" style="color:white">Home</a>
				</div>
            </form>
    </div>
</body>
</html>



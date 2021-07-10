<?php

require_once "config.php";
 
// Define variables and initialize with empty values
$email = $pass = $confirm_password = "";
$username = $contact_number = $addr = $gender =$clas =$board =$medium =$subjects =$qualification =$bank_name =$acc_no =$IFSC =$Branch="";
$username_err="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email=trim($_POST["temail"]);
    $sql = "SELECT * FROM teacher where email=?";
    /*$result = $link->query($sql);
    if ($result->num_rows > 0) 
    {
        $username_err = "This email is already taken.";

    }*/
    if($stmt = mysqli_prepare($link, $sql))
    {
        // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "s", $param_username);
            
        // Set parameters
        $param_username = trim($_POST["temail"]);
            
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_store_result($stmt);
                
            if(mysqli_stmt_num_rows($stmt) >= 1)
            {
                $username_err = "This email is already taken.";
            } 
            else
            {
                $email = trim($_POST["temail"]);
            }
        } 
        else
        {
            echo "Oops! Something went wrong. Please try again later.";
        }

            // Close statement
        mysqli_stmt_close($stmt);
    }
    if(empty($username_err))
    {
        $username=trim($_POST["tname"]);
        //$email = trim($_POST["temail"]);
        $pass = trim($_POST["pwd"]);
        $confirm_password = trim($_POST["pwd1"]);
        $contact_number=$_POST["no"];
        $addr=trim($_POST["addr"]);
        $qualification=trim($_POST["qual"]);
        $bank_name=trim($_POST["bname"]);
        $acc_no=trim($_POST["bno"]);
        $IFSC=trim($_POST["bifsc"]);
        $Branch=trim($_POST["branch"]);
        $gender=trim($_POST["gender"]);
        $checkbox1=$_POST['teach'];
        $clas="";  
        if (is_array($checkbox1) || is_object($checkbox1))
        {
            foreach($checkbox1 as $chk1)  
            {  
                $clas .= $chk1.",";  
            }
        }
        $checkbox2=$_POST['board'];  
        if (is_array($checkbox2) || is_object($checkbox2))
        {
            foreach($checkbox2 as $chk1)  
            {  
                $board .= $chk1.",";  
            } 
        }
        $checkbox3=$_POST['medium'];   
        if (is_array($checkbox3) || is_object($checkbox3))
        {
            foreach($checkbox3 as $chk1)  
            {  
                $medium .= $chk1.",";  
            }
        }
        $checkbox4=$_POST['subj'];  
        if (is_array($checkbox4) || is_object($checkbox4))
        {
            foreach($checkbox4 as $chk1)  
            {  
                $subjects .= $chk1.",";  
            }
        }
        // Prepare an insert statement
        $pass = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
        $sql = "INSERT INTO teacher (username,email,pass,contact_number,addr,gender,class,board,medium,subjects,qualification,bank_name	,acc_no,IFSC,Branch) VALUES ('$username','$email','$pass','$contact_number','$addr','$gender','$clas','$board','$medium','$subjects','$qualification','$bank_name','$acc_no','$IFSC','$Branch')";
        
        if ($link->query($sql) === TRUE) 
        {
            //echo "New record created successfully";
            header("location: teacher_dashboard.php");
        }  
        else 
        {
            echo "Error: " . $sql . "<br>" . $link->error;
        }
      
        //$link->close();
        mysqli_close($link);
    }
}
?>
 


<!DOCTYPE html>
<html>
    <head>
        <title>Registration Form Teacher</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style_teacher.css">
        <script>
            function validateForm(){
                var name=document.forms["regform"]["tname"].value;
                var email=document.forms["regform"]["temail"].value;
                var password=document.forms["regform"]["pwd"].value;
                var cpassword=document.forms["regform"]["pwd1"].value;
                var pno=document.forms["regform"]["no"].value;
                var validnumber=/^[6-9]\d{9}$/;
                var qualification=document.forms["regform"]["qual"].value;
                var bankname=document.forms["regform"]["bname"].value;
                var accnumber=document.forms["regform"]["bno"].value;
                var ifsc=document.forms["regform"]["bifsc"].value;
                var branch=document.forms["regform"]["branch"].value;
                if(name == ""){
                    alert("Name must be filed out");
                    return false;
                }
               if(email == ""){
                    alert("Email must be filed out");
                    return false;
                }
               
               if(password == ""){
                   alert("Please enter your password");
               } 
               if(password.length < 8)
               {
                    alert("Password must be at least 8 characters");
                   //document.getElementById("message").innerHTML = "**Password length must be atleast 8 characters";
		    return false;
               }
               if(password != cpassword){
                   alert("Passwords DON'T match!");
                   return false;
               }
               if(pno == null)
               {
                   alert("Please enter your contact number");
                   return false;
               }
               if(pno.length >10 || pno.length<10)
               {
                   alert("Please enter 10-digit number");
                   return false;
               }
               if(!(pno.match(validnumber))){
                   alert("Phone number INVALID");
                   return false;
               }
               if(qualification =="")
               {
                   alert("Please enter highest qualification");
                   return false;
               }
               if(bankname == "")
               {
                   alert("Please enter bank name");
                   return false;
               }
               if(accnumber == null)
               {
                   alert("Please enter bank account number");
                   return false;
               }
               if(accnumber.length<9)
               {
                   alert("Account number CANNOT be less than 9");
                   return false;
               }
               if(accnumber.length>18)
               {
                   alert("Account number CANNOT be greater than 18");
                   return false;
               }
               if(ifsc=="")
               {
                   alert("Please enter ifsc code");
                   return false;
               }
               if(ifsc.length!=11)
               {
                   alert("IFSC code INVALID");
                   return false;
               }
               if(branch=="")
               {
                   alert("Please enter branch");
                   return false;
               }
            
                }
            
        </script>
    </head>
    <body>
        <div class="row">
            <section class="section">
                <header>
                    <h3>Teacher Registration Form</h3>
                    <h4>Fill in your details here</h4>
                </header>
                <main>
                    <form name="regform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-item box-item">
                            <input type="text" name="tname" placeholder="Enter name">
                        </div>
                        <div class="form-item box-item">
                            <input type="email" name="temail" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter email">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-item box-item">
                            <input type="password" name="pwd" placeholder="Enter password">
                        </div>
                        <div class="form-item box-item">
                            <input type="password" name="pwd1" placeholder="Confirm password">
                        </div>
                        <div class="form-item box-item">
                            <input type="number" name="no" placeholder="Enter contact number">
                        </div>
                        <div class="form-item box-item">
                            <input type="text" name="addr" placeholder="Enter address">
                        </div>
                        <div class="form-item box-item">
                        <table>
                            <tr>
                                <td>Gender: </td>
                                <td><input type="radio" name="gender" value="Male">Male</td>
                                <td><input type="radio" name="gender" value="Female">Female
                                <td>
                                <td><input type="radio" name="gender" value="None">Choose not to say
                                <td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-item box-item">
                        <table>
                            <tr>
                                <td>Class you are comfortable to teach: </td>
                                <td><input type="checkbox" name="teach[]" value="1 to 4" >1 to 4</td>
                                <td><input type="checkbox" name="teach[]" value="5 to 8">5 to 8
                                <td>
                                <td><input type="checkbox" name="teach[]" value="9 and 10">9 and 10
                                <td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-item box-item">
                        <table>
                            <tr>
                                <td>Boards you are comfortable to teach: </td>
                                <td><input type="checkbox" name="board[]" checked=checked value="State Board">State Board</td>
                                <td><input type="checkbox" name="board[]" value="ICSE">ICSE
                                <td>
                                <td><input type="checkbox" name="board[]" value="CBSE">CBSE
                                <td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-item box-item">
                        <table>
                            <tr>
                                <td>Preferred medium: </td>
                                <td><input type="checkbox" name="medium[]" value="Bengali">Bengali</td>
                                <td><input type="checkbox" name="medium[]"value="Hindi">Hindi</td>
                                <td><input type="checkbox" name="medium[]" checked=checked value="English">English</td>
                            </tr>
                        </table>
                    </div>
                    <p>Choose subjects you want to teach:</p>
                    <div class="form-item box-item">

                        <table>
                            <tr>

                                <td><input type="checkbox" name="subj[]" value="Bengali">Bengali</td>
                                <td><input type="checkbox" name="subj[]"value="Hindi">Hindi</td>
                                <td><input type="checkbox" name="subj[]"value="English">English</td>
                                <td><input type="checkbox" name="subj[]"value="Maths">Maths</td>
                                <td><input type="checkbox" name="subj[]"value="General Knowledge">General Knowledge</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="subj[]" value="Computer">Computer</td>
                                <td><input type="checkbox" name="subj[]"value="Statistics">Statistics</td>
                                <td><input type="checkbox" name="subj[]" value="Science">Science</td>
                                <td><input type="checkbox" name="subj[]" value="History">History</td>
                                <td><input type="checkbox" name="subj[]" value="Geography">Geography</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="subj[]" value="Physical Science">Physical Science</td>
                                <td><input type="checkbox" name="subj[]" value="Life Science">Life Science</td>
                                <td><input type="checkbox" name="subj[]" value="Economics">Economics</td>
                                <td><input type="checkbox" name="subj[]" value="Civics">Civics</td>
                            </tr>

                        </table>
                        </div>
                        <br><br>
                        <div class="form-item box-item">
                            <input type="text" name="qual" placeholder="Enter Highest Qualification">
                        </div>
                        <div class="form-item box-item">
                            <input type="text" name="bname" placeholder="Enter bank name">
                        </div>
                        <div class="form-item box-item">
                            <input type="number" name="bno" placeholder="Enter bank account number">
                        </div>
                        <div class="form-item box-item">
                            <input type="text" name="bifsc" placeholder="Enter IFSC code">
                        </div>
                        <div class="form-item box-item">
                            <input type="text" name="branch" placeholder="Enter Branch">
                        </div>
                        <div class="form-item submit">
                            <input type="submit" id="submit" onclick="return validateForm()">
                        </div>
                    </form>
                </main>
                <footer>
                    <p>Already have an account? <a href="teacher_login.php">Login</a></p>
                </footer>
                <i class="wave"></i>

            </section>
        </div>
        

    </body>
</html>
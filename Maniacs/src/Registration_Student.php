<?php

require_once "config.php";
 
// Define variables and initialize with empty values
$email = $pass = $confirm_password = "";
$username = $contact_number = $addr = $gender =$clas =$board =$medium =$subjects =$dob=$guardian_name=$guardian_phone="";
$username_err="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email=trim($_POST["temail"]);
    $sql = "SELECT * FROM student where email=?";
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
        $email = trim($_POST["temail"]);
        $pass = trim($_POST["pwd"]);
        $confirm_password = trim($_POST["pwd1"]);
        $contact_number=$_POST["no"];
        $gender=trim($_POST["gender"]);
        $guardian_name=trim($_POST["gname"]);
        $guardian_phone=trim($_POST["gno"]);
        $addr=trim($_POST["addr"]);
        $board=trim($_POST["board"]);
        $clas= $_POST['class'];
        $checkbox4=$_POST['subj'];  
        $size=sizeof($checkbox4);
        $i=0;
        if (is_array($checkbox4) || is_object($checkbox4))
        {
            while($i<$size)  
            {  
              if($i<$size-1)
              $subjects .= $checkbox4[$i].",";  
              else
              $subjects .= $checkbox4[$i];
              $i=$i+1;
            }
        }
        $i=0;
        $checkbox3= $_POST['medium'];   
        $size=sizeof($checkbox3);
        if (is_array($checkbox3) || is_object($checkbox3))
        {
            while($i<$size)  
            {  
              if($i<$size-1)
              $medium .= $checkbox3[$i].",";  
              else
              $medium .= $checkbox3[$i];
              $i=$i+1;
            }
        }
        
        // Prepare an insert statement
        $pass = password_hash($pass, PASSWORD_DEFAULT); // Creates a password hash
        $sql = "INSERT INTO student (username,email,pass,contact_number,addr,gender,guardian_name,guardian_phone,class,board,medium,subjects) VALUES ('$username','$email','$pass','$contact_number','$addr','$gender','$guardian_name','$guardian_phone','$clas','$board','$medium','$subjects')";
        
        if ($link->query($sql) === TRUE) 
        {
            //echo "New record created successfully";
            header("location: student_dashboard.php");
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
  <meta charset="UTF-8">
  <title>Registration Form For Students</title>


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="style1.css">
  <script>
    function validateForm() {
      var name = document.forms["regform"]["tname"].value;
      var email = document.forms["regform"]["temail"].value;
      var password = document.forms["regform"]["pwd"].value;
      var cpassword = document.forms["regform"]["pwd1"].value;
      var pno = document.forms["regform"]["no"].value;
      var validnumber = /^[6-9]\d{9}$/;
      var cls = document.forms["regform"]["class"].value;
      var guardian_name = document.forms["regform"]["gname"].value;
      var guardian_no = document.forms["regform"]["gno"].value;
      var address = document.forms["regform"]["addr"].value;


      if (name == "") {
        alert("Name must be filed out");
        return false;
      }
      if (email == "") {
        alert("Email must be filed out");
        return false;
      }

      if (password == "") {
        alert("Please enter your password");
      }
      if (password.length < 8) {
        alert("Password must be at least 8 characters");
        //document.getElementById("message").innerHTML = "**Password length must be atleast 8 characters";
        return false;
      }
      if (password != cpassword) {
        alert("Passwords DON'T match!");
        return false;
      }
      if (pno == null) {
        alert("Please enter your contact number");
        return false;
      }
      if (pno.length > 10 || pno.length < 10) {
        alert("Please enter 10-digit number");
        return false;
      }
      if (!(pno.match(validnumber))) {
        alert("Phone number INVALID");
        return false;
      }
      if (address == "") {
        alert("address must be filed out");
        return false;
      }
      if (guardian_name == "") {
        alert("Guardian name must be filed out");
        return false;
      }
      if (guardian_no == null) {
        alert("Please enter guardian contact number");
        return false;
      }
      if (guardian_no.length > 10 || guardian_no.length < 10) {
        alert("Please enter 10-digit number");
        return false;
      }

      if (cls > 10 || cls < 1) {
        alert("Enter correct class between 1 to 10");
        return false;
      }
    }




  </script>


</head>

<body>

  <div class="row">
    <section class="section">
      <header>
        <h3>Student Registration Form</h3>
        <h4>Fill your details here</h4>
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
            <label for="password"> Password </label>
            <input type="password" name="pwd" placeholder="Enter password">
          </div>
          <div class="form-item box-item">
            <label for="password"> Confirm Password </label>
            <input type="password" name="pwd1" placeholder="Confirm password">
          </div>
          <div class="form-item box-item">
            <input type="number" name="no" placeholder="Enter contact number">
          </div>
          <div class="form-item box-item">
            <input type="text" name="addr" placeholder="Enter address">
          </div>
          <div class="form-item box-item">
            <div class="form-item-triple">
              <div class="radio-label">
                <label class="label">Gender</label>
              </div>
              <div class="form-item">
                <input id="Male" type="radio" name="gender" value="Male" data-once required>
                <label for="Male">Male</label>
              </div>
              <div class="form-item">
                <input id="Female" type="radio" name="gender" value="Female" data-once required>
                <label for="Female">Female</label>
              </div>
              <div class="form-item">
                <input id="Other" type="radio" name="gender" value="Other" data-once required>
                <label for="Other">Choose not to say</label>
              </div>

            </div>
          </div class="form-item box-item">
          <div class="form-item box-item">
            <input type="text" name="gname" placeholder="Enter guardian name">
          </div>
          <div class="form-item box-item">
            <input type="number" name="gno" placeholder="Enter guardian contact number">
          </div>
          <div class="form-item box-item">
            <div class="form-item-triple">
              <div class="radio-label">
                <label class="label">Board</label>
              </div>
              <div class="form-item">
                <input id="ICSE" type="radio" name="board" value="ICSE" data-once required>
                <label for="ICSE">ICSE</label>
              </div>
              <div class="form-item">
                <input id="CBSE" type="radio" name="board" value="CBSE" data-once required>
                <label for="CBSE">CBSE</label>
              </div>
              <div class="form-item">
                <input id="WBBSE" type="radio" name="board" value="State Board" data-once required>
                <label for="WBBSE">State Board</label>
              </div>
            </div>
          </div>
          <div class="form-item box-item">

            <input type="number" name="class" class="tx1" placeholder="Enter class ">
          </div>
          <div class="form-item box-item">
            <table>
              <tr>
                <td>Preferred medium: </td>
                <td><input type="checkbox" name="medium[]" value="Bengali">Bengali</td>
                <td><input type="checkbox" name="medium[]" value="Hindi">Hindi
                <td>
                <td><input type="checkbox" name="medium[]" checked=checked value="English">English
                <td>
              </tr>
            </table>
          </div>
          <p>Choose subjects you want to take tuition:</p>
          <div class="form-item box-item">

            <table>
              <tr>

                <td><input type="checkbox" name="subj[]" value="Bengali">Bengali</td>
                <td><input type="checkbox" name="subj[]" value="Hindi">Hindi</td>
                <td><input type="checkbox" name="subj[]" value="English">English</td>
                <td><input type="checkbox" name="subj[]" value="Maths">Maths</td>
                <td><input type="checkbox" name="subj[]" value="General Knowledge">General Knowledge</td>
              </tr>
              <tr>
                <td><input type="checkbox" name="subj[]" value="Computer">Computer</td>
                <td><input type="checkbox" name="subj[]" value="Statistics">Statistics</td>
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




          <div class="form-item submit">
            <input type="submit" id="submit" onclick="return validateForm()">
          </div>


        </form>
      </main>
      <footer>
        <p>Already have an account? <a href="student_login.php">Login</a></p>
      </footer>
      <i class="wave"></i>
    </section>
  </div>




</body>

</html>


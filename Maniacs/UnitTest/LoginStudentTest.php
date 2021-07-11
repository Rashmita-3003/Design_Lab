<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tutor_finder');

class LoginStudent{
	public $con;
      public function __construct()
      {
           $this->con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

           if(!$this->con)
           {
                echo 'Database Connection Error ' . mysqli_connect_error($this->con);
           }
           else{
            //    echo "Successfully Connected!";
           }
      }
			 public function Validate_info($key1, $value1,$key2,$value2)
			 {

				 // $query = "SELECT email, pass  FROM student WHERE $key1 = '$value1' AND $key2='$value2' ";
				 // $result = mysqli_query($this->con, $query);
				 //
				 // if(!$result){
					// return 'Failure';
				 // }
				 // else
				 // {
					//  return 'Success';
				 // }
				 if(empty(trim($value1))){
					  //mysqli_stmt_close($stmt);
						mysqli_close($this->con);
		        return "Failure";

		    } else{
		        $username = trim($value1);
		    }

		    // Check if password is empty
		    if(empty(trim($value2))){
					  //mysqli_stmt_close($stmt);
						mysqli_close($this->con);
		        return "Failure";

		    } else{
		        $password = trim($value2);
		    }

		    // Validate credentials
		    if(empty($username_err) && empty($password_err)){
		        // Prepare a select statement
		        $sql = "SELECT id, email, pass FROM student WHERE email = ?";

		        if($stmt = mysqli_prepare($this->con, $sql)){
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
		                            //session_start();

		                            // Store data in session variables
		                            // $_SESSION["loggedin"] = true;
		                            // $_SESSION["id"] = $id;
		                            // $_SESSION["username"] = $username;

		                            // Redirect user to welcome page
																mysqli_stmt_close($stmt);
																mysqli_close($this->con);
		                            return "Success";

		                        } else{
		                            // Password is not valid, display a generic error message
																mysqli_stmt_close($stmt);
																mysqli_close($this->con);
		                            return "Failure";

		                        }
		                    }
		                } else{
		                    // Username doesn't exist, display a generic error message
												mysqli_stmt_close($stmt);
												mysqli_close($this->con);
		                    return "Failure";

		                }
		            } else{
									  mysqli_stmt_close($stmt);
										mysqli_close($this->con);
		                return "Failure";

		            }

		            // Close statement

		        }
		    }

    // Close connection

}



}

class LoginStudentTest extends  \PHPUnit\Framework\TestCase{

	public function test(){
          $enroll = new LoginStudent;
          $semail="ishita.b.9199@gmail.com";
          $spass="Maniacs1";

		      $input=$enroll->Validate_info('email', $semail,'pass',$spass);


          $temp = "Success";
          $this->assertEquals($temp,$input);
					$new_enroll=new LoginStudent;
			    $input=$new_enroll->Validate_info('email','','pass','Idiot');
			    $temp="Failure";
          
					$this->assertEquals($temp,$input);
     }

}

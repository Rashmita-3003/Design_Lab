<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tutor_finder');

class Register_Teacher
{
    public $conn;
      public function __construct()
      {
           $this->conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

           if(!$this->conn)
           {
                echo 'Database Connection Error ' . mysqli_connect_error($this->con);
           }
           else{
            //    echo "Successfully Connected!";
           }
      }
      public function getTeacherInfo($table_name,$key,$value)
      {
                 $array = array();
                 $query = "SELECT email  FROM $table_name  WHERE username='$value' ";

                 $result = mysqli_query($this->conn, $query);
                 //echo '$result';
                 if($result)
                 {
                   while($row = mysqli_fetch_assoc($result))
                   {
                        array_push($array,$row['email']);
                   }
                   return $array;
                 }
      }
      public function submit($username,$email,$pass,$contact_number,$addr,$gender,$class,$board,$medium,$subjects,$qualification,$bank_name,$acc_no,$IFSC,$Branch){

          $sql = $sql = "INSERT INTO teacher (username,email,pass,contact_number,addr,gender,class,board,medium,subjects,qualification,bank_name	,acc_no,IFSC,Branch) VALUES ('$username','$email','$pass','$contact_number','$addr','$gender','$class','$board','$medium','$subjects','$qualification','$bank_name','$acc_no','$IFSC','$Branch')";
          mysqli_multi_query($this->conn, $sql);


        }
        public function validate($tname,$temail,$pwd,$pwd1,$no,$gender,$add,$qual,$bname,$bifsc,$branch,$teach,$board,$medium,$subj)
        {
            $email=trim($tname);
            $sql = "SELECT * FROM teacher where email=?";
            /*$result = $link->query($sql);
            if ($result->num_rows > 0)
            {
              $username_err = "This email is already taken.";

            }*/
            $link=$this->conn;
            if($stmt = mysqli_prepare($link, $sql))
            {
              // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt, "s", $param_username);

              // Set parameters
              $param_username = trim($temail);

              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt))
              {
                  mysqli_stmt_store_result($stmt);

                  if(mysqli_stmt_num_rows($stmt) >= 1)
                  {
                      $username_err = "This email is already taken.";
                      return "Failure";
                  }
                  else
                  {
                      $email = trim($temail);
                  }
              }
              else
              {
                //  echo "Oops! Something went wrong. Please try again later.";
                return "Failure";
              }

                  // Close statement
              mysqli_stmt_close($stmt);
            }
            if(empty($username_err))
            {
              $username=trim($tname);
              //$email = trim($_POST["temail"]);
              $pass = trim($pwd);
              $confirm_password = trim($pwd1);
              $contact_number=$no;
              $addr=$add;
              $qualification=trim($qual);
              $bank_name=trim($bname);
              $acc_no=trim($bno);
              $IFSC=trim($bifsc);
              $Branch=trim($branch);
              $gender=trim($gender);
              $checkbox1=$teach;
              $clas="";
              if (is_array($checkbox1) || is_object($checkbox1))
              {
                  foreach($checkbox1 as $chk1)
                  {
                      $clas .= $chk1.",";
                  }
              }
              $checkbox2=$board;
              if (is_array($checkbox2) || is_object($checkbox2))
              {
                  foreach($checkbox2 as $chk1)
                  {
                      $board .= $chk1.",";
                  }
              }
              $checkbox3=$medium;
              if (is_array($checkbox3) || is_object($checkbox3))
              {
                  foreach($checkbox3 as $chk1)
                  {
                      $medium .= $chk1.",";
                  }
              }
              $checkbox4=$subj;
              if (is_array($checkbox4) || is_object($checkbox4))
              {
                  foreach($checkbox4 as $chk1)
                  {
                      $subjects .= $chk1.",";
                  }
              }
        }
      }
}
class RegisterTeacherTest extends \PHPUnit\Framework\TestCase
{
  public function testRegister_Student()
  {
          $enroll = new Register_Teacher;
          $username="Ishita Bhattacharyya";
          $email="ishita.b.9199@gmail.com";
          $pass="Maniacs1";
          // $semail="ishita.b.9199@gmail.com";
          // $spass="Maniacs1";
          $contact_number=8017012942;
          $addr="Kolkata";
          $gender="Female";
    		  // $sgname="PapaBhattacharyya";
    		  // $sgno=9874563210;
    		  $class=9;
    		  $board="State Board";
    		  $medium="English";
    		  $subjects="Economics,Mathematics";
          $qualification="B.Tech";
          $bank_name="United Bank Of India";
          $acc_no=1201700200;
          $IFSC=13423234;
          $Branch="Kolkata";
          $teach=array("1 to 4");
          $validation_result=$enroll->validate($username,$email,$pass,$pass,$contact_number,$gender,$addr,$qualification,$bank_name,$IFSC,$Branch,$teach,$board,$medium,$subjects);
          $this->assertEquals($validation_result,"Failure");
          $username="Meghma Mullick";
          $email="mmeghma1999@gmail.com";
          $new_enroll=new Register_Teacher;
          $new_enroll->submit($username,$email,$pass,$contact_number,$addr,$gender,$class,$board,$medium,$subjects,$qualification,$bank_name,$acc_no,$IFSC,$Branch);
          $result=$new_enroll->getTeacherInfo('teacher','username',$username);
          //var_dump($result);
          $temp = array("mmeghma1999@gmail.com");
          $this->assertEquals($temp,$result);
  }
}

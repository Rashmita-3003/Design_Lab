<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tutor_finder');

class Register_Student
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
      public function getStudentInfo($table_name,$key,$value)
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
      public function submit($sname, $semail, $spass, $sno, $saddr, $sgender, $sgname, $sgno, $sclass, $sboard, $smedium, $sub){

          $sql = "INSERT INTO  `student` (username,email,pass,contact_number,addr,gender,guardian_name,guardian_phone,class,board,medium,subjects) VALUES ('$sname', '$semail', '$spass', '$sno', '$saddr','$sgender','$sgname' ,'$sgno' , '$sclass', '$sboard', '$smedium', '$sub')";
          mysqli_multi_query($this->conn, $sql);


        }

        public function validate($tname,$temail,$pwd,$pwd1,$no,$gender,$gname,$gno,$add,$brd,$class,$subj,$medium)
        {
            $email=trim($temail);
            $sql = "SELECT * FROM student where email=?";
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
                  return "Failure";
                }

                    // Close statement
                mysqli_stmt_close($stmt);
            }
            if(empty($username_err))
            {
                $username=$tname;
                $email = $temail;
                $pass = $pwd;
                $confirm_password =$pwd1;
                $contact_number=$no;
                $gender=$gender;
                $guardian_name=$gname;
                $guardian_phone=$gno;
                $addr=$add;
                $board=$brd;
                $clas=$class;
                $checkbox4=$subj;
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
                $checkbox3=$medium;
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

          }
          return "Success";
        }
}
class RegisterStudentTest extends \PHPUnit\Framework\TestCase
{
  public function testRegister_Student()
  {
          $enroll = new Register_Student;
          $sname="Ishita Bhattacharyya";
          $semail="ishita.b.9199@gmail.com";
          $spass="Maniacs1";
          $sno=8017012942;
          $saddr="Kolkata";
          $sgender="Female";
    		  $sgname="PapaBhattacharyya";
    		  $sgno=9874563210;
    		  $sclass=9;
    		  $sboard="State Board";
    		  $smedium="English";
    		  $sub="Economics";
          $validation_result=$enroll->validate($sname, $semail, $spass,$spass, $sno, $saddr, $sgender, $sgname, $sgno,  $sboard,$sclass, $sub,$smedium);
          $this->assertEquals($validation_result,"Failure");
          $sname="Rashmita Roy";
          $semail="royrashmita@gmail.com";
          $new_enroll=new Register_Student;
          $new_enroll->submit($sname, $semail, $spass, $sno, $saddr, $sgender, $sgname, $sgno, $sclass, $sboard, $smedium, $sub);
          $result=$enroll->getStudentInfo('student','username',$sname);
          // //var_dump($result);
          $temp = array("royrashmita@gmail.com");
          $this->assertEquals($temp,$result);
  }
}

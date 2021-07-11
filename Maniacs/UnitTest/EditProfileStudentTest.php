<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tutor_finder');
class EditProfileStudent
{
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
      public function save_fields($email, $no, $add, $class, $board, $mediums, $subjects)
      {

      	$link=$this->con;
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
      public function getStudentInfo($email)
      {
         $query="select contact_number from student where email='$email'";
         $result =mysqli_query($this->con, $query);
         $array=array();
         if($result)
         {
           while($row = mysqli_fetch_assoc($result))
           {
                array_push($array,$row['contact_number']);
           }
           return $array;
         }
      }
}
class EditProfileStudentTest extends \PHPUnit\Framework\TestCase
{
      public function test()
      {
           $update=new EditProfileStudent;
           $email="ishita.b.9199@gmail.com";
           $no=8981232343;
           $saddr="Kolkata";
           $sclass=9;
           $sboard="State Board";
           $smedium="English";
           $sub="Economics";
           $update->save_fields($email,$no,$saddr,$sclass,$sboard,$smedium,$sub);
           $updated_result=$update->getStudentInfo($email);
           $array=array(8981232343);
           $this->assertEquals($array,$updated_result);
      }
}

<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tutor_finder');

class Student
{
  public $conn;
  public function __construct()
  {
       $this->conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

       if(!$this->conn)
       {
            echo 'Database Connection Error ' . mysqli_connect_error($this->conn);
       }
       else{
            //echo "Successfully Connected!";
            
       }
  }
  public function insert_student($username,$email,$pass,$contact_number,$addr,$gender,$guardian_name,$guardian_phone,$clas,$board,$medium,$subjects)
  {
    $sql = "INSERT INTO student (username,email,pass,contact_number,addr,gender,guardian_name,guardian_phone,class,board,medium,subjects) VALUES ('$username','$email','$pass','$contact_number','$addr','$gender','$guardian_name','$guardian_phone','$clas','$board','$medium','$subjects')";
     mysqli_multi_query($this->conn, $sql);
  }
  public function update_student($no,$add,$class,$board,$mediums,$subjects,$email)
  {
     $sql= "UPDATE student SET contact_number=$no, addr='$add', class=$class, board='$board', medium='".$mediums."', subjects='".$subjects."' where email='$email'";
     mysqli_multi_query($this->conn, $sql);
  }
  public function delete_student($email)
  {
     $sql="DELETE from student where email='$email'";
     mysqli_multi_query($this->conn, $sql);

  }
  public function delete_student_teacher_pair($email)
  {
    $sql="DELETE from pairs where semail='$email'";
    mysqli_multi_query($this->conn, $sql);
  }
  public function get_teachers($email)
  {
      $array=array();
      $sql="SELECT temail from pairs where semail='$email'";
      $result = mysqli_query($this->conn, $sql);
      if($result)
      {
          while($row = mysqli_fetch_assoc($result))
          {
               array_push($array,$row['temail']);
          }

      }
      return $array;
  }
  public function get_subjects($email)
  {
    $array=array();
    $sql="SELECT subject from pairs where semail='$email'";
    $result = mysqli_query($this->conn, $sql);
    if($result)
    {
      while($row = mysqli_fetch_assoc($result))
      {
           array_push($array,$row['subject']);
      }

    }
      return $array;
  }
  public function get_student_details($email)
  {

     $sql="SELECT * FROM student WHERE email='$email'";
     $result = mysqli_query($this->conn, $sql);

     return $result;
  }
}
?>

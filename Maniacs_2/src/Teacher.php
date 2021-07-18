<?php
class Teacher
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
              echo "Successfully Connected!";
         }
    }
    public function fetch_teacher_name($email)
    {
      $array=array();
      $sql="SELECT username from teacher where email='$email'";
      $result = mysqli_query($this->conn, $sql);
      //echo '$result';
      if($result)
      {
        while($row = mysqli_fetch_assoc($result))
        {
             array_push($array,$row['username']);
        }
        return $array;
      }
    }
}

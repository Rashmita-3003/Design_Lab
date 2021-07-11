<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tutor_finder');

class Select_Preference
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
      public function view_pref($value)
    	{

        		$selectsub= "select subjects from student where email='$value'";
        		$subquery= mysqli_query($this->con,$selectsub);
        		$subs= mysqli_fetch_array($subquery);
        		$subject=explode(",",$subs['subjects']);

        		return $subject;
    	}
      public function get_teacher_choice($sub)
    	{

    		$select= "select username, email, subjects, qualification from teacher where subjects like '%$sub%'";
    		$sql = mysqli_query($this->con,$select);

    		return $sql;
    	}
      public function send_teacher_choice($checkbox2)
    	{
    		//$checkbox2=$_POST['pref'];
    		global $choice ="";
    		$size=sizeof($checkbox2);
    		$i=0;
        	if (is_array($checkbox2) || is_object($checkbox2))
            {
                while($i<$size)
                {
                  if($i<$size-1)
                  $choice .= $checkbox2[$i].", ";
                  else
                  $choice .= $checkbox2[$i];
                  $i=$i+1;
                }
            }
    		function_alert("Your have chosen :".$choice);
    	}

}

class SelectPreferenceTest extends \PHPUnit\Framework\TestCase
{
      public function test()
      {
          $subjects=array("Hindi","Geography");
          $student=new Select_Preference;
          $fetched_subjects=$student->view_pref("bhodu999@gmail.com");
          $this->assertEquals($subjects,$fetched_subjects);

          $result=$student->get_teacher_choice("English");
          $teachers_choices=array("Snoopy Brown","Payel Ghosh");
          $obtained_teacher_choices=array();
          if($result)
          {
            while($row = mysqli_fetch_assoc($result))
            {
                 array_push($obtained_teacher_choices,$row['username']);
            }

          }
          $this->assertEquals($teachers_choices,$obtained_teacher_choices);



      }
}

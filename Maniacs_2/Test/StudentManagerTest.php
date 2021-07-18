
<?php
require_once('Student.php');
require_once('Teacher.php');
class StudentManager
{
  public $conn;
  public function getStudentInfo($email)
  {

     $this->conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
     $query="select contact_number from student where email='$email'";
     $result =mysqli_query($this->conn, $query);
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

    public function add_student($sname,$semail,$pwd,$pwd1,$no,$gender,$gname,$gno,$add,$brd,$class,$subj,$medium)
    {
        $student_object=new Student;
        $ifexists=$student_object->get_student_name($semail);
        if(empty($ifexists))
        {
          $student_object->insert_student($sname,$semail,$pwd,$no,$add,$gender,$gname,$gno,$class,$brd,$medium,$subj);
          return "Success";
        }
        else
        {
           return "User already exists";
        }
    }
    public function update_profile($no,$add,$class,$board,$mediums,$subjects,$email)
    {
       $student_object=new Student;
       $student_object->update_student($no,$add,$class,$board,$mediums,$subjects,$email);
    }
    public function delete_student($email)
    {
       $student_object=new Student;
       $student_object->delete_student($email);
       $student_object->delete_student_teacher_pair($email);
    }
    public function get_tutor_names($email)
    {
      $student_object=new Student;
      $tutor_ids=$student_object->get_teachers($email);
      if(empty($tutor_ids))
      {
        return "No tution taken until now";
      }
      else
      {
         $names=array();
         $subjects=$student_object->get_subjects($email);
         $teacher_object=new Teacher;
         for($counter=0;$counter<count($tutor_ids);$counter++)
         {
           $tname=$teacher_object->fetch_teacher_name($tutor_ids[$counter]);

           $names[$tname[0]]=$subjects[$counter];
         }
         return $names;
      }
    }
    public function check_deletion($email)
    {
      $student_object=new Student;
      $result1=$student_object->get_student_name($email);
      $result2=$student_object->get_subjects($email);
      return count($result1)+count($result2);
    }
}

class StudentManagerTest extends \PHPUnit\Framework\TestCase
{
  public  function test()
  {
          $enroll = new StudentManager;
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
          $validation_result=$enroll->add_student($sname, $semail, $spass,$spass, $sno, $saddr, $sgender, $sgname, $sgno,  $sboard,$sclass, $sub,$smedium);
          $this->assertEquals($validation_result,"User already exists");
          $sname="Rashmita Roy";
          $semail="royrashmita@gmail.com";
          $new_enroll=new StudentManager;
          $result=$new_enroll->add_student($sname, $semail, $spass, $spass,$sno, $saddr, $sgender, $sgname, $sgno, $sboard, $sclass, $sub, $smedium);
          //
          // // //var_dump($result);
          //
          $this->assertEquals("Success",$result);

          $email="ishita.b.9199@gmail.com";
          $no=8981232343;
          $saddr="Kolkata";
          $sclass=9;
          $sboard="State Board";
          $smedium="English";
          $sub="Economics";
          $enroll->update_profile($no,$saddr,$sclass,$sboard,$smedium,$sub,$email);
          $updated_result=$enroll->getStudentInfo($email);
          $array=array(8981232343);
          $this->assertEquals($array,$updated_result);

         $teacher_subject_pair=$enroll->get_tutor_names($email);

         $this->assertEquals($teacher_subject_pair["Payel Ghosh"],"Economics");
            $enroll->delete_student($semail);
            $this->assertEquals($enroll->check_deletion($semail),0);

  }

}

<?php
require_once('Student.php');
require_once('Teacher.php');
class StudentManager
{
   public $email_id;
   // public static function validate($username,$email,$pass,$confirm_password,$contact_number,$gender,$guardian_name,$guardian_phone,$addr,$board,$clas,$checkbox4,$checkbox3)
   // {
   //    return "This email is already taken";
   // }
   public function get_student_name($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['username']);
       }

     }
      return $array;

   }
   public function get_student_contact_number($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['contact_number']);
       }

     }
      return $array;
   }
   public function get_student_address($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['addr']);
       }

     }
      return $array;
   }

   public function get_student_guardian_name($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['guardian_name']);
       }

     }
      return $array;
   }

   public function get_student_guardian_phone($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['guardian_phone']);
       }

     }
      return $array;
   }
   public function get_student_class($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['class']);
       }

     }
      return $array;
   }

   public function get_student_board($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['board']);
       }

     }
      return $array;
   }

   public function get_student_gender($email)
   {
     $array=array();
     $student_object=new Student;
     $result=$student_object->get_student_details($email);

     if($result)
     {
       while($row = mysqli_fetch_assoc($result))
       {
            array_push($array,$row['gender']);
       }

     }
      return $array;
   }

   public function add_student($sname,$semail,$pwd,$pwd1,$no,$gender,$gname,$gno,$add,$brd,$class,$subj,$medium)
   {

       $ifexists=get_student_name($semail);
       if(empty($ifexists))
       {
         $student_object->insert_student($sname,$semail,$pwd,$no,$add,$gender,$gname,$gno,$class,$board,$medium,$subj);
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
          $names[$tname]=$subjects[$counter];
        }
        return $names;
     }
   }
}
?>

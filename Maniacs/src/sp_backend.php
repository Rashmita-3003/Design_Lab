<?php

	
	
	function view_pref($value)
	{
		global $link;	
		$selectsub= "select subjects from student where email='$value'";
		$subquery= mysqli_query($link,$selectsub);
		$subs= mysqli_fetch_array($subquery);
		$subject=explode(",",$subs['subjects']);
		
		return $subject;
	}
	
	
	function get_teacher_choice($sub)
	{
		global $link;
		$select= "select username, email, subjects, qualification from teacher where subjects like '%$sub%'";
		$sql = mysqli_query($link,$select);
		
		return $sql;
	}

	function send_teacher_choice()
	{
		$checkbox2=$_POST['pref'];  
		$choice ="";
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
	
	function function_alert($message)
	{
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
	}
?>
	
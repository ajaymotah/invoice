
<?php
include('database.class.php');
class DataOperation extends Database
{
	public function  url_encode($id)
	{
		$salt=$this->salt;
		$encrypted_id = base64_encode($id.$salt);
		return $encrypted_id;

	}
	public function url_decode($id)
	{
		$salt=$this->salt;
		$decrypted_id_raw = base64_decode($id);
		$decrypted_id = preg_replace(sprintf('/%s/', $salt), '', $decrypted_id_raw);
		return $decrypted_id;
	}

	//find by id
	public function find_by_id($table,$field,$id)
	{
		$sql="SELECT * FROM ".$table." WHERE ".$field." = '".$id."'";
		$array=array();
		$query=mysqli_query($this->con,$sql);
		$row=mysqli_fetch_assoc($query)or die(mysqli_error());

			//echo $sql;
			return $row;

	}
	public function findAll_by_id($table,$field,$id)
	{
		$sql="SELECT * FROM ".$table." WHERE ".$field." = '".$id."'";
		$array=array();
		$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;

	}
	//function to insert data
	public function insert_record($table,$fields)
	{
		$sql="";
		$sql.="INSERT INTO ".$table;
		$sql.=" (".implode(",",array_keys($fields)).")VALUES";
		$sql.="('".implode("','", array_values($fields))."')";
		$query=mysqli_query($this->con,$sql)or die(mysqli_error());
		return true;
	}
	//function to delete data
	public function delete_records($table,$field,$id)
	{
		$sql = "DELETE FROM ".$table." WHERE ".$field." = '".$id."'";

		if (mysqli_query($this->con,$sql))
		{
   			 return "Record deleted successfully";
			} else
			{
   			 return "Error deleting record: " . mysqli_error($this->con);
			}
	}
	//function to delete data witk 2 fields SELECT
	public function delete_student_modules($field1,$field2,$value1,$value2)
	{
		$sql= "DELETE FROM tbl_studentmodules WHERE ".$field1." = '".$value1."' AND ".$field2."='".$value2."'";
		if (mysqli_query($this->con,$sql))
		{
   			 return "Record deleted successfully";
			} else
			{
   			 return "Error deleting record: " . mysqli_error($this->con);
			}
	}


	//function to Update Data

		public function update_records($table,$where,$fields)
	{
		$sql="";
		$condition="";
		foreach($where as $key=>$value){
			$condition.=$key . "=".$value."'AND";
		}
$condition=substr($condition,0,-4);
foreach ($fields as $key => $value) {
	//UPDATE table SET m_name=''
	$sql.=$key."='".$value."', ";
	}
	$sql=substr($sql,0,-2);
	$sql="UPDATE ".$table." SET ".$sql." WHERE ".$condition;
	if (mysqli_query($this->con,$sql))
	{
			 return "Student Status updated successfully";
		} else
		{
			 return "Error Updating Student: " . mysqli_error($this->con);
		}
}

	public function fetch_records($table)
	{
		$sql="SELECT * FROM ".$table;
		$array=array();
		$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;
	}
	public function fetch_join_2tables($table1,$table2,$join_id)
	{
		$sql="SELECT a.*,b.* FROM ".$table1." a
		INNER JOIN ".$table2." b ON a.".$join_id."=b.".$join_id;
		$array=array();
		$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;
	}

	//Find student courses
	public function fetch_student_courses($student_id)
	{
		$sql="SELECT a.*,b.*,c.* FROM tbl_studentcourses a
		JOIN tbl_students b ON a.student_id = b.student_id
		JOIN tbl_courses c ON a.course_id = c.course_id WHERE a.student_id='".$student_id."'";
		$array=array();
		$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;
			}

			//Find student modules
			public function fetch_student_modules($student_id)
			{
				$sql="SELECT a.*,b.* FROM tbl_studentmodules a,tbl_modules b
				WHERE a.module_id=b.module_id AND a.student_id='".$student_id."'";
				$array=array();
				$query=mysqli_query($this->con,$sql);
				while($row=mysqli_fetch_assoc($query))
					{
					$array[]=$row;
					}
					return $array;
					}


	//Is matching course
public function IsMatching($field)
	{
		$sql="SELECT
  c.course_id ,c.course_name,
  s.course_id, s.student_id,
  CASE
    WHEN s.course_id IS NOT NULL THEN 'Yes'
    ELSE c.course_id
  END AS IsMatching
	FROM `tbl_courses`c LEFT JOIN `tbl_studentcourses` s  ON c.course_id = s.course_id
	AND s.student_id ='".$field."'";
	$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;

	}
	//Is Matching Modules from tbl_student_modules
	public function IsMatchingModules($field)
		{
			$sql="SELECT
	  c.module_id ,c.module_name,s.student_id,
	  CASE
	    WHEN s.module_id IS NOT NULL THEN 'Yes'
	    ELSE 'No'
	  END AS IsMatchingModules
		FROM `tbl_modules`c LEFT JOIN `tbl_studentmodules` s  ON c.module_id = s.module_id
		AND s.student_id ='".$field."'";
		$query=mysqli_query($this->con,$sql);
			while($row=mysqli_fetch_assoc($query))
				{
				$array[]=$row;
				}
				return $array;
		}
		//get all modules from course
	public function get_course_modules()
	{
		$sql="SELECT m.module_id,m.module_name,c.course_id,c.course_name FROM tbl_modules m
			JOIN tbl_courses c ON c.course_id = m.course_id";
		$array=array();
		$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;
			}
	//get amount due
	public function get_payment_due($student_id,$course_id)
	{
		$sql="SELECT MIN(amount_due) AS min_value FROM tbl_payments WHERE student_id = '".$student_id."' AND course_id = '".$course_id."'";
		$query=mysqli_query($this->con,$sql);
		$row=mysqli_fetch_assoc($query)or die(mysqli_error());
		return $row['min_value'];
	}
	//make payment
	public function make_payment($student_id,$course_id,$amount)
	{
		//$var=$this->insert_record(

	}
	public function find_count($table)
	{
		$sql="SELECT * FROM ".$table;
		$result=mysqli_query($this->con,$sql);
		$rowcount=mysqli_num_rows($result);
		 return $rowcount;
	}

		//login function
	public function login($table,$username,$password)
	{
		$sql="SELECT * FROM ".$table." WHERE username = '".$username."'";
		$query=mysqli_query($this->con,$sql);
		$count=mysqli_num_rows($query);
		$msg="Please fill in";

		if($count>0)
			{
				$row=mysqli_fetch_array($query);
				if($row['password']==$password)
					{
						$_SESSION['student_id']=$row['student_id'];
						//delete any previous exam_answer
						$this->delete_records('tbl_exams','student_id',$row['student_id']);
						$_SESSION['start']=time();
						$expire=$this->session_timeout;
						$_SESSION['expire'] = $_SESSION['start'] + ($expire);
						$msg=1;
					}
					else {
						$msg="Error Logging - Please Check Username/Password";

					}
			}
			//$msg="Error Logging - Please Check Username/Password";
			return $msg;
		}

		//function encrypte MD5 password
	public function encrypt($password)
		{
			$salt=$this->salt.$password;
			return md5($salt);
		}
	public function check_registration($surname,$name,$address,$email,$phone,$pass1,$pass2)
		{




		}
#####Check Session######
	public function check_session($session)
		{
			if (!isset($session))
	{?>
    <script language="javascript">
    window.location.href = "login.php"
</script>
<?php

	}
		}

	//check session timeout

	public function check_session_time($session_time)
		{

			$now=time();
			if($now>$session_time)
			{
				session_destroy();
				echo "YOUR SESSION HAS EXPRIED, PLEASE LOGIN AGAIN";

			}

		}
	/* Exam Section */
	//fucntion to start the exams
	public function start_exam($student_id,$module_id,$no_of_questions)
		{
			$sql="SELECT * FROM tbl_questions WHERE module_id=$module_id ORDER BY rand() LIMIT $no_of_questions";
		 	$query=mysqli_query($this->con,$sql);
			$array=array();
		 while($row_question=mysqli_fetch_assoc($query))
		 	{
			 	$array[]=$row_question;
			 /*$question_id=$row_question['question_id'];
			 $question_answer=$row_question['question_answer'];
			 $fields=array(
				 "question_id"=>$question_id,
				 "student_id"=>$student_id,
				 "question_answer"=>$row_question['question_answer']);
			 $do_add_questions=$insert_record('tbl_exams',$fields);*/
			 //mysqli_query("INSERT INTO tbl_exams (student_id,question_id,question_answer) VALUES ('$student_id','$question_id','$question_answer')") or die (mysql_query());
			//return $array;
			}
			return $array;
		}
public function get_skipped_questions($student_id)
		{
			$sql="SELECT q.*,e.* FROM tbl_questions q
			JOIN tbl_exams e ON q.question_id = e.question_id WHERE e.student_id=$student_id AND e.exam_answer='U'";
			$array=array();
			$query=mysqli_query($this->con,$sql);
			while($row=mysqli_fetch_assoc($query))
				{
				$array[]=$row;
				}
				return $array;
		}
	public function update_skipped_questions($exam_id,$answer)
	{
		$sql="UPDATE tbl_exams SET exam_answer='".$answer."' WHERE exam_id=$exam_id";
		//return $sql;
		if(mysqli_query($this->con,$sql)){
			return true;
		}
		else{
			$error="Error Saving your result - See Application Administrator";
			return $error;
		}
	}
	public function end_exam($student_id)
	 {
		 $sql="SELECT DISTINCT tbl_exams.*,tbl_questions.*,tbl_students.* FROM tbl_exams,tbl_questions,tbl_students WHERE tbl_exams.question_id=tbl_questions.question_id AND tbl_exams.student_id=tbl_students.student_id AND tbl_exams.student_id=$student_id";
		$query=mysqli_query($this->con,$sql);
		while($row=mysqli_fetch_assoc($query))
			{
			$array[]=$row;
			}
			return $array;
		}

		/*------Demo SEction---*/
		public function start_demo_exam($module_id,$no_of_questions)
			{
				$sql="SELECT * FROM tbl_questions WHERE module_id=$module_id ORDER BY rand() LIMIT $no_of_questions";
				$query=mysqli_query($this->con,$sql);
				$array=array();
			 while($row_question=mysqli_fetch_assoc($query))
				{
					$array[]=$row_question;
				}
				return $array;
			}

}//end of class
//check isset
if(isset($_POST["login"]))
	{
		$login= new DataOperation;
		$username=$_POST['username'];
		$password = $_POST['password'];
		//$login->login('tbl_user',$username,$password);
			echo $msg="1";
	}

$db_operation=new DataOperation;
?>

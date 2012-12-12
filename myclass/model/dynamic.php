<?php
require '../includes/dbconnector.php';

$deptid = 1;

function SelectSubjects($deptid)
{
	$conn = new dbConnector();	
	
	$query1 = "SELECT subjectid, subject_desc FROM subjects WHERE departmentid = ".$deptid;

	$subjects = $conn->query($query1);
		
	
	$k = 0;
	if($subjects)
	{
		echo "[";
		while($row = $conn->fetch_row($subjects))
		{
			
			//echo "{id: '', text: '".$row[1]."',checked: false, leaf: 'true'},";
			
		 	$query2 = "SELECT courseid FROM courses WHERE course_subjectid = ".$row[0];
			//$query2 = "SELECT courseid FROM courses WHERE course_subjectid = 1";
			$courses = $conn->query($query2);
			
			$j = 0;
			
			echo "{ id: '".$row[0]."',	text: '".$row[1]."', checked: false, children: [";

			
			if($courses)
			{
				while($c = $conn->fetch_row($courses))
				{
					echo "{id: '".$c[0]."',	text: '".$row[1]."',checked: false, leaf: 'true'},";
					$j++;	
				}
			}
			echo "]},";
			$k++; 
		
		}
		echo "]";
	}
	
	 //return json_encode($result);
 

}
echo SelectSubjects($deptid);

?>
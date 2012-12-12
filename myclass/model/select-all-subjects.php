<?php
require '../includes/dbconnector.php';

function SelectAllSubjects() {
 
	$conn = new dbConnector();
	
	$query = "SELECT s.subjectid, s.subject_code, s.subject_desc, c.college_desc, c.collegeid, d.department_desc, d.departmentid 
			FROM colleges c, departments d, subjects s 
			WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid";
	$array = 'subjects';		
	$result = array($array => array());
	$row = $conn->query($query);
	
	$i = 0;
	
	if($row)
	{
		while($a =  $conn->fetch_assoc($row))
		{
			$result[$array][$i]= $a;
			$i++;
		}
	}

  return json_encode($result);
} 
echo SelectAllSubjects();
?>
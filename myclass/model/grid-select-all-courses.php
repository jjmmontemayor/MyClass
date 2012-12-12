<?php
require '../includes/dbconnector.php';

$start = $_POST['start'];
$limit = $_POST['limit'];  
 
/* $start = 0;
$limit = 15;  */ 

function SelectAllCourses($start, $limit) {
 
	$conn = new dbConnector();	
	
	$query = "SELECT c.college_desc, d.department_desc, s.subject_desc, k.course_offerings, k.course_capacity, k.courseid
	FROM colleges c, departments d, subjects s, courses k WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid AND s.subjectid = k.course_subjectid ORDER BY courseid ASC LIMIT ".$limit." OFFSET ".$start;
	
	
	
	$array = 'courses';
	$result = array($array => array());
	$row = $conn->query($query);

	$query2 = "SELECT * FROM courses";
	$all = $conn->query($query2);
	$result['totalcount'] = $conn->row_count($all);
	
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
echo SelectAllCourses($start, $limit);
?>

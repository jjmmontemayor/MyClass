<?php
require '../includes/dbconnector.php';

$course_college = $_POST['course_college'];
$course_department = $_POST['course_department'];
$course_subject = $_POST['course_subject'];
$course_capacity = $_POST['course_capacity']; 
$course_offerings = $_POST['course_offerings'];  

/*  $course_college = 2;
$course_department = 12;
$course_subject = 37;
$course_capacity = 20; 
$course_offerings = 5;   */

function addCourse($course_college, $course_department, $course_subject, $course_capacity, $course_offerings)
{
	
	$conn = new dbConnector();
	
	for($i = 0; $i<$course_offerings; $i++)
	{
		$query = "INSERT INTO courses (course_subjectid, course_offerings, course_capacity) VALUES (".$course_subject.", ".$course_offerings.", ".$course_capacity.")";
		$result = $conn->query($query);
		if(!result)
		{
			break;
			echo "{
				'success': false,
				'msg': 'Form submission failed.'
			}";
		}
		
	}
	 echo 	"{
				'success': true,
				'msg': 'Form submission complete.'
	}";
}
addCourse($course_college, $course_department, $course_subject, $course_capacity, $course_offerings);
?>


	
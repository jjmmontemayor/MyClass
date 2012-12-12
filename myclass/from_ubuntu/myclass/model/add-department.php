<?php
require '../includes/dbconnector.php';

$department_college = $_POST['department_college'];
$department_desc = $_POST['department_desc'];

function addDepartment($department_college, $department_desc)
{
	
	$conn = new dbConnector();	
	$query = "insert into departments (department_desc, collegeid) values ('".$department_desc."', '".$department_college."')";
	$result = $conn->query($query);	
	
	if($result)
	{
	 echo 	"{
				'success': true,
				'msg': 'Form submission complete.'
			}";


	}
	else
	{
		echo "{
				'success': false,
				'msg': 'Form submission failed.'
			}";
	}
}
echo addDepartment($department_college, $department_desc);
?>


	
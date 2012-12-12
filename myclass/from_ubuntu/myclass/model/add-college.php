<?php
require '../includes/dbconnector.php';

$college_code = $_POST['collegecode'];
$college_desc = $_POST['collegedesc'];

function addCollege($college_code, $college_desc)
{
	
	$conn = new dbConnector();	
	$query = "insert into colleges (college_code, college_desc) values ('".$college_code."', '".$college_desc."')";
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
addCollege($college_code, $college_desc);
?>


	
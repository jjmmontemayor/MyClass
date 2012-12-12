<?php
require '../includes/dbconnector.php';

$day_code = $_POST['daycode'];

function addDay($day_code)
{
	
	$conn = new dbConnector();	
	$query = "insert into days (day_code) values ('".$day_code."')";
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
addDay($day_code);
?>


	
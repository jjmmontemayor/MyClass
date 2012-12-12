<?php
require '../includes/dbconnector.php';

$time_start = $_POST['time-start'];
$time_end = $_POST['time-end'];
$time_desc = $time_start." - ".$time_end;

function addTime($time_start, $time_end, $time_desc)
{
	
	$conn = new dbConnector();	
	$query = "insert into time (time_start, time_end, time_desc) values ('".$time_start."','".$time_end."', '".$time_desc."')";
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
addTime($time_start, $time_end, $time_desc);
?>
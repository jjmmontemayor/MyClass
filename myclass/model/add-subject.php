<?php
require '../includes/dbconnector.php';

$subject_code = $_POST['subject_code'];
$subject_desc = $_POST['subject_desc'];
$collegeid = $_POST['subject_college'];
$departmentid = $_POST['subject_department']; 
$typeid = $_POST['subject-type'];
$room_options = $_POST['subject-room-options'];
$room_items = $_POST['subject-room-items'];
$subject_units = $_POST['subject-units'];

function addSubject($subject_code, $subject_desc, $collegeid, $departmentid, $typeid, $room_options, $room_items, $subject_units)
{
	
	$conn = new dbConnector();	
	
	$typeIds = count ($typeid);
	$roomItems = count($room_items);
	$roomOptions = count($room_options);
	
	$items = "";
	$ids = "";
	$options = "";
	
	for($r= 0; $r<$roomItems ;$r++)
	{
		$items .= $room_items[$r].",";	
	}
	
	for($i= 0; $i<$typeIds ;$i++)
	{
		$ids .= $typeid[$i].",";	
	}
	
	for($o= 0; $o<$roomOptions ;$o++)
	{
		$options .= $room_options[$o].",";	
	}
	
	$query = "insert into subjects (subject_code, subject_desc, collegeid, departmentid, typeid, room_options, room_items, subject_units) values ('".$subject_code."', '".$subject_desc."', '".$collegeid."', '".$departmentid."', '".$ids."', '".$options."', '".$items."', '".$subject_units."')";
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
addSubject($subject_code, $subject_desc, $collegeid, $departmentid, $typeid, $room_options, $room_items, $subject_units);
?>
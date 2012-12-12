<?php
require '../includes/dbconnector.php';

$type_code = $_POST['typecode'];
$type_desc = $_POST['typedesc'];

function addType($type_code, $type_desc)
{
	
	$conn = new dbConnector();	
	$query = "insert into types (type_code, type_desc) values ('".$type_code."', '".$type_desc."')";
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
addType($type_code, $type_desc);
?>
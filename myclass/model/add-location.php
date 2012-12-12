<?php
require '../includes/dbconnector.php';

$location_desc = $_POST['location_desc'];
$location_college = $_POST['location_college'];
$location_department = $_POST['location_department'];
$location_capacity = $_POST['location_capacity'];
$location_type = $_POST['location_type'];
$location_items = $_POST['location_items'];


function addLocation($location_desc, $location_college, $location_department, $location_capacity, $location_type, $location_items)
{
	
	$conn = new dbConnector();
	
	$d = count($location_department);
	$t = count($location_type);
	$s = count($location_items);
	
	$departments = "";
	
	for($i = 0; $i<$d ; $i++)
	{
		$departments .= $location_department[$i].",";	
	}
	
	$types = "";
	
	for($j = 0; $j<$t; $j++)
	{
		$types .= $location_type[$j].",";
	}

	$items = "";
	
	for($k = 0; $k<$s; $k++)
	{
		$items .= $location_items[$k].",";
	}

	$query = "INSERT INTO locations (location_desc, location_college, location_department, location_capacity, location_type, location_items) 
				VALUES ('".$location_desc."' , ".$location_college.", '".$departments."', ".$location_capacity.", '".$types."', '".$items."')";
	
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
addLocation($location_desc, $location_college, $location_department, $location_capacity, $location_type, $location_items);
?>


	
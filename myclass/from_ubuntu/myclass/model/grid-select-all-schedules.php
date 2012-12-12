<?php
require '../includes/dbconnector.php';

/*$start = $_POST['start'];
$limit = $_POST['limit']; */
 
$start = 0;
$limit = 15;  

function SelectAllScheduleDetails($start, $limit) 
{
 
	$conn = new dbConnector();	
	
	$query = "SELECT * FROM schedule ORDER BY scheduleid ASC LIMIT ".$limit." OFFSET ".$start;
	
	$array = 'schedule_details';
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
echo SelectAllScheduleDetails($start, $limit);
?>


	

<?php
require '../includes/dbconnector.php';


function SelectAllTypes() {
 
	$conn = new dbConnector();	
	$query = "SELECT * FROM types";
	$array = 'types';
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
echo SelectAllTypes();
?>


	
<?php
require '../includes/dbconnector.php';

//$collegeid = urlencode($_GET['collegeid']);
$collegeid = $_REQUEST['collegeid'];

function SelectCollege($collegeid) {
 
	$conn = new dbConnector();	
	$query = "SELECT * FROM colleges WHERE collegeid =".$collegeid;
	$array = $collegeid;
	//$result = array($array => array());
	$row = $conn->query($query);
	$i = 0;
	
	if($row)
	{
		$result = $conn->fetch_obj($row);
		
		echo '{success: true, data:'.json_encode($result).'}';
	}
	else
	{
		echo '{success: false}';
	
	}
	
  //return json_encode($result);
  
  
  
} 
SelectCollege($collegeid);
?>


	
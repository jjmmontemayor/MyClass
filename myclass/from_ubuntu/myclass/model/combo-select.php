<?php
require '../includes/dbconnector.php';

$string = urlencode($_GET['string']);
/* $start = $_POST['start'];
$limit = $_POST['limit']; */

function Select($string) {
 
	$conn = new dbConnector();	
	$query = "SELECT * FROM ".$string;
	$result = array($string => array());
	$row = $conn->query($query);

	$i = 0;
	
	if($row)
	{
		while($a =  $conn->fetch_assoc($row))
		{
			$result[$string][$i]= $a;
			$i++;
		}
	}
	
  return json_encode($result);
} 
echo Select($string);
?>


	
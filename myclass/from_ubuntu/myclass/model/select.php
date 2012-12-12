<?php
require '../includes/dbconnector.php';

$string = urlencode($_GET['string']);
$start = $_POST['start'];
$limit = $_POST['limit'];

function Select($string, $start, $limit) {
 
	$conn = new dbConnector();	
	$query = "SELECT * FROM ".$string." LIMIT ".$limit." OFFSET ".$start;
	$query2 = "SELECT * FROM ".$string;
	$array = $string;
	$result = array($array => array());
	$row = $conn->query($query);
	$all = $conn->query($query2);
	$result['totalcount'] = $conn->row_count($all);
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
echo Select($string, $start, $limit);
?>


	
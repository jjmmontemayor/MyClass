<?php
require '../includes/dbconnector.php';

$start = $_POST['start'];
$limit = $_POST['limit']; 
 
/*$start = 0;
$limit = 15;  */

function SelectAllTimeslots($start, $limit) {
 
	$conn = new dbConnector();	
	
	$query = "SELECT * FROM timeslots ORDER BY timeslotid ASC LIMIT ".$limit." OFFSET ".$start;
	
	$array = 'timeslots';
	$result = array($array => array());
	$row = $conn->query($query);

	$query2 = "SELECT * FROM timeslots";
	$all = $conn->query($query2);
	$result['totalcount'] = $conn->row_count($all);
	
	
	$i = 0;
	
	if($row)
	{
		while($a =  $conn->fetch_assoc($row))
		{
			$timeslottypes = $a['timeslot_types'];
			$timeslottypes2 = trim(str_replace("," , " ", $timeslottypes));
			$timeslottypes3 = explode(" ", $timeslottypes2);
			$ttl = count($timeslottypes3);
		
			$ttypes = "";
			for($l = 0; $l<$ttl; $l++)
			{
				$query = "SELECT type_desc FROM types WHERE typeid =".$timeslottypes3[$l];
				$data = $conn->query($query);
				$tttypes = $conn->fetch_row($data);
				$ttypes .= $tttypes[0].",";
			}
		
			$a['timeslot_types'] = $ttypes;
			
			$result[$array][$i]= $a;
			$i++;
		}
	}
	
  return json_encode($result);
} 
echo SelectAllTimeslots($start, $limit);
?>
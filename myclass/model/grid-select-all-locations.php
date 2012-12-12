<?php
require '../includes/dbconnector.php';

$start = $_POST['start'];
$limit = $_POST['limit'];  
  
/* $start = 0;
$limit = 15;  */  

function SelectAllLocations($start, $limit) {
 
	$conn = new dbConnector();	
	
	$query = "SELECT l.locationid, l.location_desc, c.college_desc, l.location_college, l.location_department, l.location_capacity, l.location_type, l.location_items FROM colleges c, locations l WHERE c.collegeid = l.location_college ORDER BY locationid ASC LIMIT ".$limit." OFFSET ".$start;
	
	$array = 'locations';
	$result = array($array => array());
	
	$row = $conn->query($query);
	$query2 = "SELECT * FROM locations";
	$all = $conn->query($query2);
	$result['totalcount'] = $conn->row_count($all);
	
	$k = 0;
	
	if($row)
	{
		while($a =  $conn->fetch_assoc($row))
		{
			$list_departments = $a['location_department'];
			$list_departments2 = trim(str_replace("," , " ", $list_departments));
			$list_departments3 = explode(" ", $list_departments2);
			$length = count($list_departments3);
			
			$locdeptid = "";
			for($d = 0; $d<$length; $d++)
			{
				$query = "SELECT department_desc FROM departments WHERE departmentid =".$list_departments3[$d];
				$data = $conn->query($query);
				$locdept = $conn->fetch_row($data);
				$locdeptid .= $locdept[0].",";
			}
			
			
			$list_items = $a['location_items'];
			$list_items2 = trim(str_replace("," , " ", $list_items));
			$list_items3 = explode(" ", $list_items2);
			$length = count($list_items3);
			
			$locitemcode = "";
			for($i = 0; $i<$length; $i++)
			{
				$query = "SELECT item_code FROM items WHERE itemid =".$list_items3[$i];
				$data = $conn->query($query);
				$locitem = $conn->fetch_row($data);
				$locitemcode .= $locitem[0].",";	
			}
			
			
			$list_types = $a['location_type'];
			$list_types2 = trim(str_replace("," , " ", $list_types));
			$list_types3 = explode(" ", $list_types2);
			$length = count($list_types3);
			
			$loctypecode = "";
			for($t = 0; $t<$length; $t++)
			{
				$query = "SELECT type_desc FROM types WHERE typeid =".$list_types3[$t];
				$data = $conn->query($query);
				$loctype = $conn->fetch_row($data);
				$loctypecode .= $loctype[0].",";
				
			}
			
			$a['location_department'] = $locdeptid;
			$a['location_items'] = $locitemcode;
			$a['location_type'] = $loctypecode;
			
			$result[$array][$k]= $a;
			$k++;
		}
	
	}
	
  return json_encode($result);
} 
echo SelectAllLocations($start, $limit);
?>

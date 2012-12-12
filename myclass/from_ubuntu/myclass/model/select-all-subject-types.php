<?php
require '../includes/dbconnector.php';

$start = $_POST['start'];
$limit = $_POST['limit']; 

/* $start = "0";
$limit = "15"; */ 

function SelectAllSubjectTypes($start, $limit) 
{
 
	$conn = new dbConnector();	
	
	$query ="SELECT typeid FROM subjects LIMIT ".$limit." OFFSET ".$start;
	
	$query2 = "SELECT * FROM subjects";
		
	$array = 'subject-types';
	$result = array($array => array());
	$row = $conn->query($query);
	$all = $conn->query($query2);
	$result['totalcount'] = $conn->row_count($all);

	$j =0;
	
	
	if($row)
	{
		while($b =  $conn->fetch_assoc($row))
		{
			//echo $b['typeid'];
			$list = $b['typeid'];
			$list2 = str_replace("{", "", $list);
			$list3 = str_replace("}", "", $list2);
			$id = explode(",", $list3);
			$length = count($id);
		
			$str = "";
			for($l = 0; $l<$length; $l++)
			{
				$query3 = "SELECT type_desc FROM types WHERE typeid =".$id[$l];
				$data = $conn->query($query3);
				$type = $conn->fetch_row($data);
				$str .= $type[0].",";
				
			}
			$c = array('typeid'=> $str);
			$result[$array][$j] = $c ;
			$j++;
		}
	}
	
  return json_encode($result);
} 
echo SelectAllSubjectTypes($start, $limit) ;
?>


	
<?php
require '../includes/dbconnector.php';
 
$start = $_POST['start'];
$limit = $_POST['limit'];  

/*$start = 0;
$limit = 15;  */

function GridSelectAllSubjects($start, $limit) 
{
 
	$conn = new dbConnector();	
	
	$query = "SELECT s.subjectid, s.subject_code, s.subject_desc, s.subject_offering, s.typeid, s.faculty_credits, s.room_options, s.room_items, c.college_desc, c.collegeid, d.department_desc, d.departmentid FROM colleges c, departments d, subjects s WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid ORDER BY subjectid ASC LIMIT ".$limit." OFFSET ".$start;
	
	$query2 = "SELECT * FROM subjects";
	
	$query3 ="SELECT typeid FROM subjects";
	$query4 ="SELECT room_options FROM subjects";
	$query5 ="SELECT room_items FROM subjects";
	
	$array = 'subjects';
	$result = array($array => array());
	$row = $conn->query($query);
	$all = $conn->query($query2);
	$row3 = $conn->query($query3);
	$result['totalcount'] = $conn->row_count($all);
		
	$i = 0;
	
	if($row)
	{
		while($a =  $conn->fetch_assoc($row))
		{
			
			$list = $a['typeid'];
			
			$id = trim(str_replace("," , " ", $list));
			
			$ids = explode(" ", $id);
			
			$length = count($ids);
			
			
			$typeid = "";
			for($l = 0; $l<$length; $l++)
			{
				$query3 = "SELECT type_code FROM types WHERE typeid =".$ids[$l];
				
				$data = $conn->query($query3);
				$type = $conn->fetch_row($data);
				$typeid .= $type[0].",";
				
			}
			
			$roomlist = $a['room_options'];
			$roomlist2 = trim(str_replace("," , " ", $roomlist));
			$options = explode(" ", $roomlist2);
			$roomlistlength = count($options);
		
			$roomoptions = "";
			for($l = 0; $l<$roomlistlength; $l++)
			{
				$query = "SELECT college_code FROM colleges WHERE collegeid =".$options[$l];
				$data = $conn->query($query);
				$roomoption = $conn->fetch_row($data);
				$roomoptions .= $roomoption[0].",";
				
			}
			
			$roomitems = $a['room_items'];
			$roomitems2 = trim(str_replace("," , " ", $roomitems));
			$items = explode(" ", $roomitems2);
			$roomitemslength = count($items);
		
			$roomitems = "";
			for($l = 0; $l<$roomitemslength; $l++)
			{
				$query = "SELECT item_code FROM items WHERE itemid =".$items[$l];
				$data = $conn->query($query);
				$roomItem = $conn->fetch_row($data);
				$roomitems .= $roomItem[0].",";
				
			}
			
			$a['typeid'] = $typeid;
			$a['room_options'] = $roomoptions;
			$a['room_items'] = $roomitems;
			$result[$array][$i]= $a;
			$i++;
		}
	}
	
  return json_encode($result);
} 
echo GridSelectAllSubjects($start, $limit) ;
?>


	

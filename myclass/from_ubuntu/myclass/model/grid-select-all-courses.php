<?php
require '../includes/dbconnector.php';

$start = $_POST['start'];
$limit = $_POST['limit']; 
 
/*$start = 0;
$limit = 275;  */

function SelectAllCourses($start, $limit) {
 
	$conn = new dbConnector();	
	
	$query = "SELECT k.courseid, c.college_desc, d.department_desc, s.subject_desc, s.faculty_credits, k.course_capacity, k.room_options, k.room_items FROM colleges c, departments d, subjects s, courses k WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid AND s.subjectid = k.course_subjectid ORDER BY courseid ASC LIMIT ".$limit." OFFSET ".$start;
	
	
	$row = $conn->query($query);

	$query2 = "SELECT * FROM courses";
	$all = $conn->query($query2);
	$result['totalcount'] = $conn->row_count($all);
	
	$c = 0;
	if($row)
	{
		
		while($a =  $conn->fetch_assoc($row))
		{
			if($a['room_options'] != "0")
			{
				$list_options = $a['room_options'];
				$list_options2 = trim(str_replace("," , " ", $list_options));
				$list_options3 = explode(" ", $list_options2);
				$length = count($list_options3);
			
				$room_options = "";
				for($i = 0; $i<$length; $i++)
				{
					$query = "SELECT college_code FROM colleges WHERE collegeid =".$list_options3[$i];
					//echo $query.'<br/>';	
					$data = $conn->query($query);
					$option = $conn->fetch_row($data);
					$room_options .= $option[0].",";	
					
				}

				//echo $room_options.'<br/>';		
				$a['room_options'] = $room_options;
			}			
			else
			{
				$room_options = "NONE";
				//echo $room_options.'<br/>';		
				$a['room_options'] = $room_options;
			}

				if($a['room_items'] != "0")
			{
				$list_items = $a['room_items'];
				$list_items2 = trim(str_replace("," , " ", $list_items));
				$list_items3 = explode(" ", $list_items2);
				$count = count($list_items3);
			
				$room_items = "";
				for($r = 0; $r<$count; $r++)
				{
					$query = "SELECT item_code FROM items WHERE itemid =".$list_items3[$r];
					//echo $query.'<br/>';	
					$data = $conn->query($query);
					$items = $conn->fetch_row($data);
					$room_items .= $items[0].",";	
					
				}

				
				$a['room_items'] = $room_items;
			}			
			else
			{
				$a['room_items'] = "NONE";
			}


			

			$result['courses'][$c]= $a;
			$c++;

		}
	}
	
  return json_encode($result);
} 
echo SelectAllCourses($start, $limit);
?>


	

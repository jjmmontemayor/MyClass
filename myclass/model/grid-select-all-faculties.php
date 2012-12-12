<?php
require '../includes/dbconnector.php';
 
$start = $_POST['start'];
$limit = $_POST['limit']; 

/*  $start = 0;
$limit = 15; */  

function GridSelectAllFaculties($start, $limit) 
{
 
	$conn = new dbConnector();	
	
	$query = "SELECT f.facultyid, f.faculty_desc, f.faculty_department, f.faculty_maxload, f.faculty_minload, c.college_desc, d.department_desc,
	f.faculty_preftime, f.faculty_prefloc, f.faculty_teachables FROM faculties f, colleges c, departments d WHERE c.collegeid = f.faculty_college 
	AND d.departmentid = f.faculty_department ORDER BY faculty_desc ASC LIMIT ".$limit." OFFSET ".$start;
	
	$query2 = "SELECT * FROM faculties";
	
	$array = 'faculties';
	$result = array($array => array());
	$row = $conn->query($query);
	$all = $conn->query($query2);
	
	$result['totalcount'] = $conn->row_count($all);
		
	$i = 0;
	
	if($row)
	{
		while($a =  $conn->fetch_assoc($row))
		{
			
			$preftime = $a['faculty_preftime'];
			$preftime2 = trim(str_replace("," , " ", $preftime));
			$preftime3 = explode(" ", $preftime2);
			$length = count($preftime3);
			
			$time = "";
			for($l = 0; $l<$length; $l++)
			{
				$query3 = "SELECT time_desc FROM time WHERE timeid =".$preftime3[$l];
				
				$data = $conn->query($query3);
				$data2 = $conn->fetch_row($data);
				$time .= $data2[0].",";
				
			}
			
			$prefloc = $a['faculty_prefloc'];
			$prefloc2 = trim(str_replace("," , " ", $prefloc));
			$prefloc3 = explode(" ", $prefloc2);
			$loclength = count($prefloc3);
		
			$location = "";
			for($m = 0; $m<$loclength; $m++)
			{
				$query = "SELECT location_desc FROM locations WHERE locationid =".$prefloc3[$m];
				$data = $conn->query($query);
				$data2 = $conn->fetch_row($data);
				$location .= $data2[0].",";
			}
			
			$teachables1 = $a['faculty_teachables'];
			$teachables2 = trim(str_replace("," , " ", $teachables1));
			$teachables3 = explode(" ", $teachables2);
			$teachableslength = count($teachables3);
		
			$teachables = "";
			for($n = 0; $n<$teachableslength; $n++)
			{
				$query = "SELECT subject_desc FROM subjects WHERE subjectid =".$teachables3[$n];
				$data = $conn->query($query);
				$data2 = $conn->fetch_row($data);
				$teachables .= $data2[0].",";
				
			}
			
			$a['faculty_preftime'] = $time;
			$a['faculty_prefloc'] = $location;
			$a['faculty_teachables'] = $teachables;
			$result[$array][$i]= $a;
			$i++;
		}
	}
	
  return json_encode($result);
} 
echo GridSelectAllFaculties($start, $limit) ;
?>
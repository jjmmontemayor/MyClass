<?php
require '../includes/dbconnector.php';


function SelectAllDepartments() {
 
	$conn = new dbConnector();	
	$query = "SELECT c.collegeid, c.college_desc, d.departmentid, d.department_desc from colleges c, departments d where c.collegeid = d.collegeid";
	$array = 'departments';
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
echo SelectAllDepartments();
?>


	
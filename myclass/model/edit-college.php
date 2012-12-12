<?php
require '../includes/dbconnector.php';

$collegeid = $_POST['collegeid'];;
$college_code = $_POST['college_code'];
$college_desc = $_POST['college_desc'];

function editCollege($collegeid, $college_code, $college_desc)
{
	
	$conn = new dbConnector();	
	$query = "UPDATE colleges SET college_code = '".$college_code."', college_desc = '".$college_desc."' WHERE collegeid = ".$collegeid;
	$result = $conn->query($query);	
	
	if($result)
	{
	 echo 	"{
				'success': true,
				'msg': 'Update Complete.'
			}";
	}
	else
	{
		echo "{
				'success': false,
				'msg': 'Update Failed.'
			}";
	}
}
editCollege($collegeid, $college_code, $college_desc);
?>
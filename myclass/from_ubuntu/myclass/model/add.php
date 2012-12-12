<?php
require '../includes/dbconnector.php';

function addCollege()
{
	$college_code = $_POST['cc'];
	$college_desc = $_POST['cd'];

	$conn = new dbConnector();	
	$query = "insert into colleges (college_code, college_desc) values ('".$college_code."' '".$college_desc."')";
	$result = $conn->query($query);	
	
	if($result)
	{
		echo "SUCCESSFUL";
	}
	else
	{
		echo "FAILED";
	}
}
?>


	
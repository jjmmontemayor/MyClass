<?php
require '../includes/dbconnector.php';

$scope_desc = $_POST['scopedesc'];

function addScope($scope_desc)
{
	
	$conn = new dbConnector();	
	$query = "insert into scopes (scope_desc) values ('".$scope_desc."')";
	$result = $conn->query($query);	
	
	if($result)
	{
	 echo 	"{
				'success': true,
				'msg': 'Form submission complete.'
			}";
	}
	else
	{
		echo "{
				'success': false,
				'msg': 'Form submission failed.'
			}";
	}
}
addScope($scope_desc);
?>
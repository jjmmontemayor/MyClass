<?php
require '../includes/dbconnector.php';

$item_code = $_POST['itemcode'];
$item_desc = $_POST['itemdesc'];

function addItem($item_code, $item_desc)
{
	
	$conn = new dbConnector();	
	$query = "insert into items (item_code, item_desc) values ('".$item_code."', '".$item_desc."')";
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
addItem($item_code, $item_desc);
?>


	
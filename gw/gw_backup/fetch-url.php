<?php
require 'includes/dbconnector.php';


$url = $_POST['url'];

if($url)
{
	$dbconn = new dbConnector();
	$query = "INSERT INTO url (url_desc) VALUES (".$url.")"; 	
	$result = $dbconn->query($query);

	if($result)
	{
		json_encode( array( 'success' => true ) );			
	}
	else
	{
		json_encode( array( 'error' => false ) );
	}

}

?>
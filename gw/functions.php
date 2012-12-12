<?php
require 'includes/dbconnector.php';

class Functions
{

function showTable()
{

	$dbconn = new dbConnector();
	$query = "SELECT url FROM gw_urls"; 	
	$result = $dbconn->query($query);

	if($result)
	{
		$html = '<table>';
		while($row = $dbconn->fetchRow($result))
		{
			$html .= '<tr><td>'.$row[0].'</td></tr>';		
		}
		$html .= '</table>';
		
		echo $html;
	}
	else
	{
		$html = '<span>No Results Found</span>';
		echo $html;
	}

}
}

?>
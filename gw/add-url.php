<?php
require 'includes/dbconnector.php';


$url = $_POST['url'];

if($url)
{
	$dbconn = new dbConnector();
	$query = "INSERT INTO gw_urls (url) VALUES ('".$url."')"; 	
	$result = $dbconn->query($query);

	if($result)
	{
			$query = "SELECT url FROM gw_urls"; 	
			$result2 = $dbconn->query($query);

			if($result2)
			{
				$html = '<table>';
				while($row = $dbconn->fetchRow($result2))
				{
					$html .= '<tr><td>'.$row[0].'</td></tr>';		
				}
				$html .= '</table>';
				
				return $html;
			}
			else
			{
				$html = '<span>No Results Found</span>';
				return $html;
			}
	
	}
	else
	{
		echo "error";
	}

}

?>
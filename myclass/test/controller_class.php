<?php

class Controllers
{

function Controllers
{
	$dbconn = new dbConnector();
	
}


function getByLocation()
{
	while($result_locationdesc = $dbconn->fetch_row($locationdesc))
	{
				
		$querylocsched = "SELECT * FROM schedules WHERE location_desc = '".$result_locationdesc[0]."'";
		$locsched = $dbconn->query($querylocsched);
		
		//$f = fopen($result_facultydesc[0], "w"); 
		
		
		echo "<table><tr><th style='text-align:left;font-style:oblique;font-size:18px;'>".$result_locationdesc[0]."</th></tr>";
		echo "<tr><th style='text-align:left'>TIMESLOT</th><th style='text-align:left'>COURSE</th><th style='text-align:left'>FACULTY</th></tr>";
		
		while($a = $dbconn->fetch_array($locsched))
		{
		
			$locclass = "<tr><td width=400px>".$a[3]."</td><td width=300px>".$a[2]."</td><td width=200px>".$a[1]."</td></tr>";
			echo $locclass;	
			//fwrite($f, $class); 
		}
		
		echo "</table><br/>";

		//fclose($f);
	}

}
}






















}

?>
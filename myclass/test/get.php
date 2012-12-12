<?php
require 'dbconnector.php';

	$dbconn = new dbConnector();	
	$queryfacultydesc = "SELECT faculty_desc FROM faculties";
	$facultydesc = $dbconn->query($queryfacultydesc);
	
	while($result_facultydesc = $dbconn->fetch_row($facultydesc))
	{
		$dbconn = new dbConnector();
		$faculty_desc = str_replace(",", "", $result_facultydesc[0]);
			
		$querysched = "SELECT * FROM schedules WHERE faculty_desc = '".$faculty_desc."'";
		$sched = $dbconn->query($querysched);
		
		//$f = fopen($result_facultydesc[0], "w"); 
		
		
		echo "<table><tr><th style='text-align:left;font-style:oblique;font-size:18px;'>".$result_facultydesc[0]."</th></tr>";
		echo "<tr><th style='text-align:left'>COURSE</th><th style='text-align:left'>TIMESLOT</th><th style='text-align:left'>LOCATION</th><th style='text-align:left'>CREDITS</th></tr>";
		
		while($a = $dbconn->fetch_array($sched))
		{
			if($a[3] == "")
			{
				$ts = "TBA";
			}
			else
			{
				$ts = $a[3]; 
			}
			
			if($a[4] == "")
			{
				$loc = "TBA";
			}
			else
			{
				$loc = $a[4]; 
			}

			$class = "<tr><td width=400px>".$a[2]."</td><td width=300px>".$ts."</td><td width=200px>".$loc."</td><td width=200px>".$a[5]."</td></tr>";
			echo $class;	
			//fwrite($f, $class); 
		}
		
		echo "</table><br/>";

		//fclose($f);
	}




	
?>

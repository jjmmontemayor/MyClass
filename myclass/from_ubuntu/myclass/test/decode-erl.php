<?php
require 'dbconnector.php';
require 'erlconnector.php';


//{{c2,courseid},timeslotid,locationid,facultyid}
//{{fe1,facultyeventid},time}

function isEmpty($result)
{
	if($result == "")
	{
		$result = "TBA";
		return $result;
	}
	else
	{
		return $result;
	}	
}



	$erl = new erlConnector();
	$erl->send("{~p, ~a, ~a}", array(array($link, $username,"ss_done")));
	$result = $erl->receive();

	if($result[0][0] == "solutions_ok")
	{
		$erl->send("~a", array("solutions_accepting"));
		
		$result = $erl->receive();
		
		while($result[0][0] != "solutions_done")
		{
			$type = $result[0][0][0];
			
			if($type == "c2")
			{
				$courseid = isEmpty($result[0][0][1]);		
				$timeslotid = isEmpty($result[0][1]);
				$locationid = isEmpty($result[0][2]);
				$facultyid = isEmpty($result[0][3]);
				$eventid = 0;
				$generated_time = time();

				$course = "Schedule:<br/>COURSE: ".$courseid."<br/>FACULTY: ".$facultyid."<br/>TIMESLOT: ".$timeslotid."<br/>LOCATION: ".$locationid;

				$dbconn = new dbConnector();
				$queryschedule = "INSERT INTO schedules (facultyid, courseid, timeslotid, locationid, eventid, time_generated) VALUES ('".$facultyid."', '".$courseid."', '".$timeslotid."', '".$locationid."', '".$eventid."', '".$generated_time."')";
				$dbconn->query($queryschedule);
		
				echo $course;
			}
			elseif($type == "fe1")
			{
				$eventid = isEmpty($result[0][0][1]);
				$timeslotid = isEmpty($result[0][1]);
				$courseid = 0;		
				$locationid = 0;
				$facultyid = 0;
				$generated_time = time();		

				
				
				$meeting = "Schedule:<br/>FACULTY MEETING: ".$eventid."<br/TIMESLOT: ".$timeslotid;

				$dbconn = new dbConnector();
				$queryschedule = "INSERT INTO schedules (facultyid, courseid, timeslotid, locationid, eventid, time_generated) VALUES ('".$facultyid."', '".$courseid."', '".$timeslotid."', '".$locationid."', '".$eventid."', '".$generated_time."')";
				$dbconn->query($queryschedule);

				echo $meeting;
			}
		
		
					
		}
	}





	/*$file = file('solution.txt');
	$count= count($file);

	for($i=0;$i<$count;$i++)
	{
		get($file[$i])."<br/>";
	}*/ 

?>


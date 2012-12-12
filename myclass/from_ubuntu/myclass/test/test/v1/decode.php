<?php
require 'dbconnector.php';
//require 'erlconnector.php';

//ask for solutions -> solutions_get
//if response solutions_ok
//send solutions_accepting

//{{c2,courseid},timeslotid,locationid,facultyid}
//{{fe1,facultyeventid},time}

function isEmpty($result)
{
	if($result == "")
	{
		$result = 0;
		return $result;
	}
	else
	{
		return $result;
	}	
}


function get($solution)
{
	$remove_openbrackets = str_replace("{", "", $solution);
	$remove_closebrackets = str_replace("}", "", $remove_openbrackets);
	$finalsolution = explode(",", $remove_closebrackets);
	
	if($finalsolution[0] == 'c2')
	{
		$result_faculty = isEmpty($finalsolution[4]);
		$result_timeslot = isEmpty($finalsolution[2]);
		$result_course = isEmpty($finalsolution[1]);
		$result_location = isEmpty($finalsolution[3]);	
		$result_eventid = 0;
		$generated_time = time();
	
		$queryschedule = "INSERT INTO schedules (facultyid, courseid, timeslotid, locationid, eventid, time_generated) VALUES ('".$result_faculty."', '".$result_course."', '".$result_timeslot."', '".$result_location."', '".$result_eventid."', '".$generated_time."')";
		$dbconn = new dbConnector();	
		$dbconn->query($queryschedule);
		echo $queryschedule;
	}

	elseif($finalsolution[0] == 'fe1')
	{
		
		$result_faculty = 0;
		$result_timeslot = isEmpty($finalsolution[2]);
		$result_location = 0;	
		$result_eventid = isEmpty($finalsolution[1]);
		$generated_time = time();
	
		$queryschedule = "INSERT INTO schedules (facultyid, courseid, timeslotid, locationid, eventid, time_generated) VALUES ('".$result_faculty."', '".$result_course."', '".$result_timeslot."', '".$result_location."', '".$result_eventid."', '".$generated_time."')";
		
		$dbconn = new dbConnector();	
		$dbconn->query($queryschedule);
		echo $queryschedule;
	}

}

	$file = file('solution.txt');
	$count= count($file);

	for($i=0;$i<$count;$i++)
	{
		get($file[$i])."<br/>";
	}

	 

?>


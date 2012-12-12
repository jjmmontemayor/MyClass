<?php
require 'dbconnector.php';
//require 'erlconnector.php';

//ask for solutions -> solutions_get
//if response solutions_ok
//send solutions_accepting

//{{c2,courseid},timeslotid,locationid,facultyid}
//{{fe1,facultyeventid},time}

$schoolyear = '2010-2011';
$semester = '2';
$version = '3';
$desc = $schoolyear."_".$semester."_".$version;

function addSchedule($desc, $schoolyear, $semester, $version)
{
	$queryschedule = "INSERT INTO schedule (schedule_desc, schedule_schoolyear, schedule_semester, schedule_version) VALUES ('".$desc."','".$schoolyear."', '".$semester."', '".$version."')";
	$dbconn = new dbConnector();	
	$result = $dbconn->query($queryschedule);
	if($result)
	{
		return true;
	}
	else
	{
		return false;
	}
}


function getScheduleId($schoolyear, $semester, $version)
{
		$dbconn = new dbConnector();
		$queryscheduleid = "SELECT scheduleid FROM schedule WHERE schedule_schoolyear = '".$schoolyear."' AND schedule_semester = ".$semester." AND schedule_version = ".$version;		
		$result = $dbconn->query($queryscheduleid);
		while($row = $dbconn->fetch_row($result))
		{
			return $row[0];
		}
}		
		

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


function get($solution, $scheduleid)
{
	$remove_openbrackets = str_replace("{", "", $solution);
	$remove_closebrackets = str_replace("}", "", $remove_openbrackets);
	$finalsolution = explode(",", $remove_closebrackets);
	
	$solution_length = count($finalsolution);
	
	if($solution_length == 5)
	{
		$result_faculty = isEmpty($finalsolution[4]);
		$result_timeslot = isEmpty($finalsolution[2]);
		$result_course = isEmpty($finalsolution[1]);
		$result_location = isEmpty($finalsolution[3]);	
		$result_eventid = 0;

		$queryschedule = "INSERT INTO schedule_details (facultyid, courseid, timeslotid, locationid, eventid, scheduleid ) VALUES ('".$result_faculty."', '".$result_course."', '".$result_timeslot."', '".$result_location."', '".$result_eventid."', '".$scheduleid."')";
		
		
		$dbconn = new dbConnector();	
		$dbconn->query($queryschedule);
		echo $queryschedule;
	}

	elseif($solution_length == 3)
	{
		
		$result_faculty = 0;
		$result_timeslot = isEmpty($finalsolution[2]);
		$result_location = 0;
		$result_course = 0;	
		$result_eventid = isEmpty($finalsolution[1]);
		//$generated_time = time();
	
		$queryschedule = "INSERT INTO schedule_details (facultyid, courseid, timeslotid, locationid, eventid, scheduleid) VALUES ('".$result_faculty."', '".$result_course."', '".$result_timeslot."', '".$result_location."', '".$result_eventid."', '".$scheduleid."')";
		
		$dbconn = new dbConnector();	
		$dbconn->query($queryschedule);
		//echo $queryschedule;
	}

}
//addSchedule($desc, $schoolyear, $semester, $version);

$id = getScheduleId($schoolyear, $semester, $version);
//echo$id;

	$file = file($desc.".txt");
	$count= count($file);

	for($i=0;$i<$count;$i++)
	{
		//echo $file[$i]." ".$id."<br/>";
		get($file[$i], $id)."<br/>";
	}
	
	 

?>


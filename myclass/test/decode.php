<?php
require 'dbconnector.php';

class Decode
{

function get($solution)
{

$remove_openbrackets = str_replace("{", "", $solution);
$remove_closebrackets = str_replace("}", "", $remove_openbrackets);
$finalsolution = explode(",", $remove_closebrackets);

	if($finalsolution[0] == 'c2')
	{
		$dbconn = new dbConnector();	
		$queryfaculty = "SELECT faculty_desc FROM faculties where facultyid = ".$finalsolution[4];
		$faculty = $dbconn->query($queryfaculty);
		$result_faculty = $dbconn->fetch_row($faculty);
		$resultfaculty = str_replace(",", "", $result_faculty[0]);

		$querytimeslot = "SELECT timeslot_desc FROM timeslots where timeslotid = ".$finalsolution[2];
		$timeslot = $dbconn->query($querytimeslot);
		$result_timeslot = $dbconn->fetch_row($timeslot);

		$querysubjectid = "SELECT course_subjectid FROM courses where courseid = ".$finalsolution[1];
		$subject = $dbconn->query($querysubjectid);
		$result_subject = $dbconn->fetch_row($subject);
		$querycourseid = "SELECT subject_desc, faculty_credits FROM subjects where subjectid = ".$result_subject[0];
		$course = $dbconn->query($querycourseid);
		$result_course = $dbconn->fetch_row($course);

		$querylocation = "SELECT location_desc FROM locations where locationid = ".$finalsolution[3];
		$location = $dbconn->query($querylocation);
		$result_location = $dbconn->fetch_row($location);

		$final = "Schedule:<br/>COURSE: ".$result_course[0]."<br/>FACULTY: ".$resultfaculty."<br/>TIMESLOT: ".$result_timeslot[0]."<br/>LOCATION: ".$result_location[0];

		$queryschedule = "INSERT INTO schedules (faculty_desc, course_desc, timeslot_desc, location_desc, faculty_credits) VALUES ('".$resultfaculty."', '".			$result_course[0]."', '".$result_timeslot[0]."', '".$result_location[0]."', '".$result_course[1]."')";
		$dbconn->query($queryschedule);

		echo $final;
	}

	
}


	$file = file('solution.txt');
	$count= count($file);

	for($i=0;$i<$count;$i++)
	{
		get($file[$i])."<br/>";
	}

}
?>
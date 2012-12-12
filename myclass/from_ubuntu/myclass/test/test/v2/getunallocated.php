<?php
require 'dbconnector.php';
$scheduleid = $_GET['schedid'];
	
 $html = "<link rel='stylesheet' type='text/css' href='../css/pdf.css' />";	

//summary of courses with no teachers

	
 $dbconn = new dbConnector();
 $querylocation = "SELECT locationid, location_desc FROM locations";
 $locationdec = $dbconn->query($querylocation);
 
 $tbc = 0;
while($l = $dbconn->fetch_row($locationdec))
{
	$querylocsched = "SELECT * FROM schedule_details WHERE locationid = ".$l[0]." AND scheduleid = ".$scheduleid;
	$locsched = $dbconn->query($querylocsched);
	
	if($dbconn->row_count($locsched) != 0)
	{
 		while($s = $dbconn->fetch_row($locsched))
		{
		
			if($s[1] == "0")
				{
					$faculty = "TBA";
			
					$tba_courseid = $s[2];
				   	$tba_querysubjectid = "SELECT course_subjectid FROM courses where courseid = ".$tba_courseid;
				   	$tba_subject = $dbconn->query($tba_querysubjectid);
					$tba_result_subject = $dbconn->fetch_row($tba_subject);
					$tba_querycourseid = "SELECT subject_desc, subject_code FROM subjects where subjectid = ".$tba_result_subject[0];
					$tba_qcourse = $dbconn->query($tba_querycourseid);
					$tba_result_course = $dbconn->fetch_row($tba_qcourse); 
					$tba_course = $tba_result_course[0];
					$tba_subject_code = $tba_result_course[1];
					$tba_course_id = $tba_courseid;
				
					$tba_timeslotid = $s[3];
					$tba_querytimeslot = "SELECT timeslot_desc, timeslot_details FROM timeslots where timeslotid = ".$tba_timeslotid;
					$tba_qtimeslot = $dbconn->query($tba_querytimeslot);
					$tba_result_timeslot = $dbconn->fetch_row($tba_qtimeslot);
					$tba_timeslot = $tba_result_timeslot[0];
					$tba_timeslot_details = $tba_result_timeslot[1];
				
					$tba[$tbc]['tba_course'] = $tba_course;
					$tba[$tbc]['tba_subject_code'] = $tba_subject_code;
					$tba[$tbc]['tba_timeslot'] = $tba_timeslot;
					$tba[$tbc]['location'] = $l[1];
					$tbc++;
					//echo $tba_course." ".$tba_subject_code." ".$tba_timeslot." ".$l[1]."<br/>";
				}
			}
		}
		else
		{
			$unallocated[] = $l[1];
		}
	}
	
		
	$html.="</table><br/>";	
	$html.= "<table style='font-size:18px;'><tr><th style='text-align:center;background:#ffffff;font-weight:normal;'>SUMMARY OF COURSES WITH NO TEACHERS</th></tr>";
	$html.= "<tr><th style='text-align:left'>COURSE</th><th style='text-align:left'>CODE</th><th style='text-align:left'>TIMESLOT</th><th style='text-align:left'>LOCATION</th></tr>";
	

	for($z=0;$z<count($tba);$z++)
	{
		
$html.= "<tr><td>".$tba[$z]['tba_subject_code']."</td><td>".$tba[$z]['tba_course']."</td><td>".$tba[$z]['tba_timeslot']."</td><td>".$tba[$z]['location']."</td><tr/>";
	}
	
	$html.="</table><br/>";
 
 
 
 //summary of unallocated courses 
 
 $queryulocation = "SELECT scheduleid, facultyid, courseid, timeslotid FROM schedule_details WHERE locationid = 0 AND eventid = 0";
 $ulocsched = $dbconn->query($queryulocation);	
 

 
$html.= "<table style='font-size:18px;'><tr><th style='text-align:center;background:#ffffff;font-weight:normal;'>SUMMARY OF UNALLOCATED COURSES</th></tr>";
		
$html.= "<tr><th style='text-align:left;'>ID</th><th style='text-align:left'>COURSE</th><th style='text-align:left'>CODE</th><th style='text-align:left'>FACULTY</th></tr>";
 
 while($a = $dbconn->fetch_row($ulocsched))
 {
 	
 	$facultyid = $a[1];
 	$queryfaculty = "SELECT faculty_desc FROM faculties WHERE facultyid = ".$facultyid;
 	$qfaculty = $dbconn->query($queryfaculty);
 	$result_faculty = $dbconn->fetch_row($qfaculty);
	$faculty = $result_faculty[0];
	
	$courseid = $a[2];
	$querysubjectid = "SELECT course_subjectid FROM courses where courseid = ".$courseid;
	$subject = $dbconn->query($querysubjectid);
	$result_subject = $dbconn->fetch_row($subject);
	$querycourseid = "SELECT subject_desc, faculty_credits, subject_code FROM subjects where subjectid = ".$result_subject[0];
	$qcourse = $dbconn->query($querycourseid);
	$result_course = $dbconn->fetch_row($qcourse); 
	$course = $result_course[0];
	$faculty_credits = $result_course[1];
	$subject_code = $result_course[2];
	$course_id = $courseid;
	
					 	
	$html.= "<tr><td>".$course_id."</td><td >".$course."</td><td >".$subject_code."</td><td >".$faculty."</td><tr/>";

 }
 $html.="</table><br/>";
 
//summary of unallocated rooms

	$html.= "<table style='font-size:18px;'><tr><th style='text-align:center;background:#ffffff;font-weight:normal;'>SUMMARY OF UNALLOCATED ROOMS</th></tr>";
	$html.= "<tr><th style='text-align:left'>ROOM DESCRIPTION</th></tr>";
	
	for($z=0;$z<count($unallocated);$z++)
	{
		$html.= "<tr><td>".$unallocated[$z]."</td><tr/>";
	}	

 	 $html.="</table><br/>";

 echo $html;
	
?>

<?php
require 'dbconnector.php';
$scheduleid = $_GET['schedid'];
	
 $html = "<link rel='stylesheet' type='text/css' href='../css/pdf.css' />";	

//summary of courses with no teachers

	
 $dbconn = new dbConnector();
 $querylocation = "SELECT locationid, location_desc FROM locations";
 $locationdec = $dbconn->query($querylocation);
 
 $tbc = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>  
    <title>MyClass Beta | MSU - IIT Faculty Workload Scheduler</title>  
    <link rel="stylesheet" href="../css/styles.css" type="text/css" />
	<link rel="shortcut icon" href="../images/favicon.ico" />  	
</head>  
<body>  
	<div id="container">  
		<div id="header">
			MINDANAO STATE UNIVERSITY - ILIGAN INSTITUTE OF TECHNOLOGY
		</div> <!--end header--> 
		<div id="results">
		<center>
		<div style="font-size:16px;text-align:center;padding:1.5em;">
		<hr>
		<b>Notice of Unassigned Courses, Unallocated Courses, and Unallocated Rooms</b><br />
		<small>
		College: School of Computer Studies <br />
		</small>			
		<!--small><a href="getbyfaculty.php">by Faculty</a></small> | <b><a href="getbylocation.php" style="font-size:120%;line-height:1.5em;">by Location</a></b><br /-->
		<hr>
		</div>
		
<?php
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
	$html.= "<table cellpadding='2' style='font-size:15px;' ><tr><td colspan='5' style='text-align:left;background:#CC9990;font-size:15px'>SUMMARY OF COURSES WITH NO TEACHERS</th></tr>";
	$html.= "<tr><th style='text-align:left'>COURSE</th><th style='text-align:left'>CODE</th><th style='text-align:left'>TIMESLOT</th><th style='text-align:left'>LOCATION</th></tr>";
	

	for($z=0;$z<count($tba);$z++)
	{
		
$html.= "<tr><td width=100px>".$tba[$z]['tba_subject_code']."</td><td width=400px>".$tba[$z]['tba_course']."</td><td width=400px>".$tba[$z]['tba_timeslot']."</td><td width=200px>".$tba[$z]['location']."</td><tr/>";
	}
	
	$html.="</table><br/>";
 
 
 
 //summary of unallocated courses 
 
 $queryulocation = "SELECT scheduleid, facultyid, courseid, timeslotid FROM schedule_details WHERE locationid = 0 AND eventid = 0";
 $ulocsched = $dbconn->query($queryulocation);	
 

 
$html.= "<br /><table cellpadding='2' style='font-size:15px;' ><tr><td colspan='5' style='text-align:left;background:#CC9990;font-size:15px'>SUMMARY OF UNALLOCATED COURSES</th></tr>";
		
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
	
					 	
	$html.= "<tr><td width=100px>".$course_id."</td><td width=400px>".$course."</td><td width=200px>".$subject_code."</td><td width=400px>".$faculty."</td><tr/>";

 }
 $html.="</table><br/>";
 
//summary of unallocated rooms

	$html.= "<br /><table cellpadding='2' style='font-size:15px;'><tr><td colspan='5' style='text-align:left;background:#CC9990;font-size:15px'>SUMMARY OF UNALLOCATED ROOMS</th></tr>";
	$html.= "<tr><th style='text-align:left'>ROOM DESCRIPTION</th></tr>";
	
	for($z=0;$z<count($unallocated);$z++)
	{
		$html.= "<tr><td width=1000px>".$unallocated[$z]."</td><tr/>";
	}	

 	 $html.="</table><br/>";

 echo $html;
	
?>
		<img src="../images/powered-by.jpg">
		</center>
		</div>
	</div><!--end container-->  
	<div id="footer"> 
			<hr>
			<div class="float-right">
			<a href="../about.html">THE DEVELOPERS</a> | <a href="http://msuiit.edu.ph" target="_blank">MSUIIT.EDU.PH</a> | <a href="http://my.iit.edu.ph" target="_blank">MY.IIT</a>
			</div>
			<div class="float-left">
			<span>MyClass Beta || MSU-IIT Faculty Workload and Class Assignment System &copy; 2010</span>
			</div>
	</div><!--end of footer-->
</body>
</html>

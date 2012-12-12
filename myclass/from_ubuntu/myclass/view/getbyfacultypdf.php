<?php
//ini_set("display_errors", 0); 
require '../includes/dbconnector.php';
require_once("dompdf/dompdf_config.inc.php");

$scheduleid = $_GET['schedid'];


	$dbconn = new dbConnector();	
	$queryfacultydesc = "SELECT facultyid, faculty_desc FROM faculties";
	$facultydesc = $dbconn->query($queryfacultydesc);
	
	$html = "<link rel='stylesheet' type='text/css' href='../css/pdf.css' />";
	
	while($result_facultydesc = $dbconn->fetch_row($facultydesc))
	{
		$dbconn = new dbConnector();
		$facultyid = $result_facultydesc[0];
		
		$querysched = "SELECT * FROM schedule_details WHERE facultyid = ".$facultyid." AND scheduleid = ".$scheduleid;
		$sched = $dbconn->query($querysched);
		
			
		$html.= "<table style='font-size:10px;'><tr><th style='text-align:left;font-size:15px;background:#ffffff;font-weight:normal;'>Faculty Name: ".$result_facultydesc[1]."</th></tr>";
		
		$html.= "<tr style=''><th style='text-align:left'>COURSE</th><th style='text-align:left'>CODE</th><th style='text-align:left'>TIMESLOT</th><th style='text-align:left'>LOCATION</th><th style='text-align:left'>CREDITS</th></tr>";

		
		while($a = $dbconn->fetch_array($sched))
		{
			
			if($a[2] == "0")
				{ 
					$course = "TBA"; 
				}
			else
				{ 
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
				}
			
			if($a[3] == "0")
				{
					$timeslot = "TBA";
				}
			else
				{
					$timeslotid = $a[3];
					$querytimeslot = "SELECT timeslot_desc FROM timeslots where timeslotid = ".$timeslotid;
					$qtimeslot = $dbconn->query($querytimeslot);
					$result_timeslot = $dbconn->fetch_row($qtimeslot);
					$timeslot = $result_timeslot[0];				 	
				}

			if($a[4] == "0")
				{
					$location = "TBA";
				}
			else
				{
					$locationid = $a[4];
					$querylocation = "SELECT location_desc FROM locations where locationid = ".$locationid;
					$qlocation = $dbconn->query($querylocation);
					$result_location = $dbconn->fetch_row($qlocation);
					$location = $result_location[0];
				}

			$html.= "<tr><td width=300px>".$course."</td><td width=200px>".$subject_code."</td><td width=250px>".$timeslot."</td><td width=200px>".$location."</td><td width=200px>".$faculty_credits."</td></tr>";

		
				}
		
		$html.="</table><br/>";

		

			} 



$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($scheduleid." - Faculty.pdf");

//echo $html;



?>

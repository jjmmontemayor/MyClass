<?php
require 'dbconnector.php';
require_once("dompdf/dompdf_config.inc.php");
	
	$dbconn = new dbConnector();	
	$querytimeslotdesc = "SELECT timeslot_desc FROM timeslots";
	$timeslotdesc = $dbconn->query($querytimeslotdesc);

	$querylocationdesc = "SELECT locationid, location_desc FROM locations";
	$locationid = $dbconn->query($querylocationdesc);
	//$html = "";
	$html = "<link rel='stylesheet' type='text/css' href='../css/pdf.css' />";

	while($result_locationid = $dbconn->fetch_row($locationid))
	{
		
			
		$querylocsched = "SELECT * FROM schedules WHERE locationid = '".$result_locationid[0]."'";
		$locsched = $dbconn->query($querylocsched);

		
		$html .= "<table><tr><td style='text-align:left;background:#ffffff;'>ROOM: <b>".$result_locationid[1]."<b></td></tr>";
		
		$html .= "<tr><td style='text-align:left'>TIMESLOT</td><td style='text-align:left'>COURSE</td><td style='text-align:left'>CODE</td><td style='text-align:left'>FACULTY</td></tr>";
		
		
		while($a = $dbconn->fetch_array($locsched))
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

			if($a[1] == "0")
				{
					$faculty = "TBA";
				}
			else
				{
					$facultyid = $a[1];
					$queryfaculty = "SELECT faculty_desc FROM faculties where facultyid = ".$facultyid;
					$qfaculty = $dbconn->query($queryfaculty);
					$result_faculty = $dbconn->fetch_row($qfaculty);
					$faculty = $result_faculty[0];
				}




			$html .= "<tr><td width=400px>".$timeslot."</td><td width=300px>".$course."</td><td width=150px>".$subject_code."</td><td width=200px>".$faculty."</td></tr>";
		}
		
		$html .= "</table><br/>";
			}





/*$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Location.pdf");*/

echo $html;
?>

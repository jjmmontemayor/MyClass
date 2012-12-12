<?php
//ini_set("display_errors", 0); 
require 'dbconnector.php';
require_once("dompdf/dompdf_config.inc.php");

$scheduleid = $_GET['schedid'];

$dbconn = new dbConnector();	
$queryfacultydesc = "SELECT facultyid, faculty_desc FROM faculties";
$facultydesc = $dbconn->query($queryfacultydesc);

$html = "<link rel='stylesheet' type='text/css' href='../css/pdf.css' />";
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
		<b>Notice of Subject Load</b> <br />
		<small>
		College: School of Computer Studies <br />
		</small>		
		<!--b><a href="getbyfaculty.php" style="font-size:120%;line-height:1.5em;">by Faculty</a></b> | <small><a href="getbylocation.php">by Location</a></small><br /-->
		<hr>
		</div>
<?php	
	while($result_facultydesc = $dbconn->fetch_row($facultydesc))
	{
		$dbconn = new dbConnector();
		$facultyid = $result_facultydesc[0];
		
		$querysched = "SELECT * FROM schedule_details WHERE facultyid = ".$facultyid." AND scheduleid =".$scheduleid;
		$sched = $dbconn->query($querysched);
		
			
		$html.= "<br /><table cellpadding='2' style='font-size:15px;'><tr><td colspan='5' style='text-align:left;background:#CC9990;font-size:15px'>Faculty Name: <b>".$result_facultydesc[1]."</b></th></tr>";
		
		$html.= "<tr><th style='text-align:left'>COURSE</th><th style='text-align:left'>CODE</th><th style='text-align:left'>TIMESLOT</th><th style='text-align:left'>LOCATION</th><th style='text-align:left'>CREDITS</th></tr>";

		$sum = 0;
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
					
					$sum += $faculty_credits;
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

			$html.= "<tr><td width=350px>".$course."</td><td width=100px>".$subject_code."</td><td width=250px>".$timeslot."</td><td width=200px>".$location."</td><td width=80px>".$faculty_credits."</td></tr>";

		
		}
		$total = $sum;
		$html.="<tr><td colspan='4' style='text-align:right;'>Total:</td><td><b>".$total."</b></td></tr>";
		$html.="</table><br/>";

		

			} 



/*$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Faculty.pdf");*/

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
			<span>MyClass Beta || MSU-IIT Faculty Workload Scheduler &copy; 2010</span>
			</div>
	</div><!--end of footer-->
</body>
</html>

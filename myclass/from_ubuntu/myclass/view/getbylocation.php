<?php
ini_set('display_errors', '0');
require '../includes/dbconnector.php';


require_once("dompdf/dompdf_config.inc.php");

$scheduleid = $_GET['schedid'];
	
$dbconn = new dbConnector();
	

$querylocationdesc = "SELECT locationid, location_desc FROM locations";
$locationid = $dbconn->query($querylocationdesc);
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
		<b>Notice of Room Utilizations</b><br />
		<small>
		College: School of Computer Studies <br />
		</small>			
		<!--small><a href="getbyfaculty.php">by Faculty</a></small> | <b><a href="getbylocation.php" style="font-size:120%;line-height:1.5em;">by Location</a></b><br /-->
		<hr>
		</div>	
<?php
while($l = $dbconn->fetch_row($locationid))
{
	$querylocsched = "SELECT * FROM schedule_details WHERE locationid = ".$l[0]." AND scheduleid = ".$scheduleid;
	$locsched = $dbconn->query($querylocsched);
	
	if($dbconn->row_count($locsched) != 0)
	{
		$mc = 0; $tc = 0; $wc = 0; $hc = 0;	$fc = 0; $stc = 0; $snc = 0; 
	$m = array(); $t = array(); $w = array(); $h = array(); $f = array();$st = array();$sn = array();
	

	while($s = $dbconn->fetch_row($locsched))
	{
		
		if($s[1] == "0")
			{
				$faculty = "TBA";		
	
			}
		else
			{
				$facultyid = $s[1];
				$queryfaculty = "SELECT faculty_desc FROM faculties where facultyid = ".$facultyid;
				$qfaculty = $dbconn->query($queryfaculty);
				$result_faculty = $dbconn->fetch_row($qfaculty);
				$faculty = $result_faculty[0];
			}
			
		if($s[2] == "0")
			{ 
				$course = "TBA"; 
			}
		else
			{ 
			   	$courseid = $s[2];
			   	$querysubjectid = "SELECT course_subjectid FROM courses where courseid = ".$courseid;
			   	$subject = $dbconn->query($querysubjectid);
				$result_subject = $dbconn->fetch_row($subject);
				$querycourseid = "SELECT subject_desc, subject_code FROM subjects where subjectid = ".$result_subject[0];
				$qcourse = $dbconn->query($querycourseid);
				$result_course = $dbconn->fetch_row($qcourse); 
				$course = $result_course[0];
				$subject_code = $result_course[1];
				$course_id = $courseid;
			}
	
	
		if($s[3] != "0")
			{
				$timeslotid = $s[3];
				$querytimeslot = "SELECT timeslot_desc, timeslot_details FROM timeslots where timeslotid = ".$timeslotid;
				$qtimeslot = $dbconn->query($querytimeslot);
				$result_timeslot = $dbconn->fetch_row($qtimeslot);
				$timeslot = $result_timeslot[0];
				$timeslot_details = $result_timeslot[1];
			}
			
		$data = $subject_code.'<br/>'.$course_id.'<br/>'.$timeslot.'<br/>'.$faculty;	
		
		
		
		$change_delimiter = str_replace("},{", ";", $timeslot_details);
		$remove_obracket = str_replace("{", "", $change_delimiter);
		$remove_cbracket = str_replace("}", "", $remove_obracket);
		$to_parse = explode(";", $remove_cbracket);
		$length = count($to_parse);
		$ref = "";
		
		for($c = 0; $c<$length; $c++)
			{
				$tocheck = $to_parse[$c];
				$day = $tocheck{0};
				
				if($ref != $day)
				{
					$ref = $day;
					
					if($day == "2")
					{
						
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$m[$mc][0] = $start_time;
						$m[$mc][1]= $data;
						$mc++;
					}
					if($day == "3")
					{
						
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$t[$tc][0]= $start_time;
						$t[$tc][1]= $data;
						$tc++;
					}
					if($day == "4")
					{
						
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$w[$wc][0] = $start_time;
						$w[$wc][1]= $data;
						$wc++;
					}
					if($day == "5")
					{
					
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$h[$hc][0] = $start_time;
						$h[$hc][1]= $data;
						$hc++;
					}
					if($day == "6")
					{
					
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$f[$fc][0] = $start_time;
						$f[$fc][1]= $data;
						$fc++;
					}
					if($day == "7")
					{
					
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$st[$stc][0] = $start_time;
						$st[$stc][1]= $data;
						$stc++;
					}
					if($day == "1")
					{
					
						$start_time = substr($tocheck,2,strlen($tocheck)-1);
						$sn[$snc][0] = $start_time;
						$sn[$snc][1]= $data;
						$snc++;
					}	
				}	
			}					
	}
	
	
	$len = array($mc , $tc, $wc, $hc, $fc, $stc, $snc);
	$max = max($len);
	
	$sortedm = sort_array($m);
	$sortedt = sort_array($t);
	$sortedw = sort_array($w);
	$sortedh = sort_array($h);
	$sortedf = sort_array($f);
	$sortedst = sort_array($st);
	$sortedsn = sort_array($sn);
	
	$html.=  "<link rel='stylesheet' type='text/css' href='../css/pdf.css' />";
	$html.=  "<br /><table cellpadding='2' style='font-size:15px;'><tr><td colspan='7' style='text-align:left;background:#CC9990;font-size:15px'>Room Name: <b>".$l[1]."<b></td></tr>";
	$html.=  "<tr style='text-align:left;'><th width=150px>MONDAY</th><th width=150px>TUESDAY</th><th width=150px>WEDNESDAY</th><th width=150px>THURSDAY</th><th width=150px>FRIDAY</th><th width=150px>SATURDAY</th><th>SUNDAY</th></tr>";
	
	for($i=0; $i<$max;$i++)
	{
		$html.=  "<tr>";
		$html.=  "<td>".$sortedm[$i][1]."</td>";
		$html.=  "<td>".$sortedt[$i][1]."</td>";
		$html.=  "<td>".$sortedw[$i][1]."</td>";
		$html.=  "<td>".$sortedh[$i][1]."</td>";
		$html.=  "<td>".$sortedf[$i][1]."</td>";
		$html.=  "<td>".$sortedst[$i][1]."</td>";
		$html.=  "<td>".$sortedsn[$i][1]."</td>";
		$html.=  "</tr>";
	}
	
	$html.=  "</table><br/>";
		
	}
	
	else
	{
		$unallocated[] = $l[1];
	}

		
			
}

echo $html;


function sort_array($array)
{
	$length = count($array);
	//echo $length;
	for($x = 0; $x <$length; $x++) 
	{
		for($y = $x+1; $y < $length; $y++) 
		{
			if($array[$x][0] > $array[$y][0]) 
		 	{
			  	$hold = $array[$x];  	
			  	$array[$x] = $array[$y];
			  	$array[$y] = $hold;			  
			}
		}
	}
	return $array;	
}

	
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

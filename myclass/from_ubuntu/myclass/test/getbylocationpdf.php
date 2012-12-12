<?php
ini_set('display_errors', '0');
require 'dbconnector.php';
require_once("dompdf/dompdf_config.inc.php");

$scheduleid = $_GET['schedid'];
	
$dbconn = new dbConnector();	

$querylocationdesc = "SELECT locationid, location_desc FROM locations";
$locationid = $dbconn->query($querylocationdesc);

while($l = $dbconn->fetch_row($locationid))
{
	$querylocsched = "SELECT * FROM schedule_details WHERE locationid = ".$l[0]." AND scheduleid = ".$scheduleid;
	$locsched = $dbconn->query($querylocsched);
	
	
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
			
		$data = $subject_code.'<br/>'.$timeslot.'<br/>'.$faculty;	
		
		
		
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
	$html.=  "<table><tr><td style='text-align:left;background:#ffffff;'>ROOM: <b>".$l[1]."<b></td></tr>";
	$html.=  "<tr style='text-align:left;'><th>MONDAY</th><th>TUESDAY</th><th>WEDNESDAY</th><th>THURSDAY</th><th>FRIDAY</th><th>SATURDAY</th><th>SUNDAY</th></tr>";
	
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

//echo $html;

function sort_array($array)
{
	$length = count($array);
	
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


$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($scheduleid." - Location.pdf");
	
?>

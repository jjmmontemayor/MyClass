<?php
ini_set("display_errors", 0); 
require '../includes/dbconnector.php';
include '../includes/erlconnector.php';



function sendColleges()
{
	$dbconn = new dbConnector();
	$dbquery = "SELECT * FROM colleges";
	$dbrows = $dbconn->query($dbquery);
	
	
	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$collegeid = (int)$result['collegeid'];
			$college_code = $result['college_code'];
			
			$message = peb_encode("[{{~a,~i},~a}]", array(array(array(array("college,", $collegeid), $college_code))));
					
			rpc("send1", $message);
		}
	}
	else
	{
		echo 'Database Error. No Data Entries: COLLEGES';
	}
	
}

function sendDepartments()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM departments";
	$dbrows = $dbconn->query($dbquery);

	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$departmentid = (int)$result['departmentid'];
			$department_desc = $result['department_desc'];
		
			$message = peb_encode("[{{~a,~i},~a}]", array(array(array(array("department,", $departmentid), $department_desc))));
			rpc("send1", $message);
		}
	}
	else
	{
		echo 'Database Error. No Data Entries: DEPARTMENTS.';
	}
}

function sendTypes()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM types";
	$dbrows = $dbconn->query($dbquery);


	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$typeid = (int)$result['typeid'];
			$type_desc = $result['type_desc'];
			
			$message = peb_encode("[{{~a,~i},~a}]", array(array(array(array("type,", $typeid), $type_desc))));
			rpc("send1", $message);
		}
	
	}
	else
	{
		echo 'Database Error. No Data Entries: TYPE.';
	}
}

function sendItems()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM items";
	$dbrows = $dbconn->query($dbquery);


	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$itemid = (int)$result['itemid'];
			$item_desc = $result['item_desc'];
			
			$message = peb_encode("[{{~a,~i},~a}]", array(array(array(array("item,", $itemid), $item_desc))));
			rpc("send1", $message);
		}
	}
	else
	{
		echo 'Database Error. No Data Entries: ITEMS.';
	}
	
}


function sendDays()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM days";
	$dbrows = $dbconn->query($dbquery);

	
	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$dayid = (int)$result['dayid'];
			$day_code = $result['day_code'];
			
			$message = peb_encode("[{{~a,~i},~a}]", array(array(array(array("day,", $dayid), $day_code))));
			rpc("send1", $message);
		}
	
	}
	else
	{
		echo 'Database Error. No Data Entries: DAYS.';
	}

}

function sendTime()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM time";
	$dbrows = $dbconn->query($dbquery);

	
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$timeid = (int)$result['timeid'];
				$time_desc = $result['time_desc'];
				
				$message = peb_encode("[{{~a,~i},~a}]", array(array(array(array("time,", $timeid), $time_desc))));
				rpc("send1", $message);
			}
		
		}
		else
		{
			echo 'Database Error. No Data Entries: TIME.';
		}
	
}

function sendCourses()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT k.courseid, c.collegeid, d.departmentid, s.subjectid, s.faculty_credits, s.typeid, k.course_capacity, s.room_options, 		s.room_items FROM colleges c, departments d, subjects s, courses k WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid AND s.subjectid = k.course_subjectid";
	
	//$dbquery = "SELECT * FROM courses";
	
	$dbrows = $dbconn->query($dbquery);

	
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				
				$tc_types = array();
				$tc_cbc = array();
				$tc_items = array();
				
  				if($result['typeid'] != "0")
  				{
  					
  					$types = explode(",", $result['typeid']);
   					
  					for($i=0;$i<count($types);$i++)
  					{
  						$tc_types[] = (int)$types[$i];
  					}
  					
  				}
  				else
  				{
  					$tc_types[] = -1;
  				}
  				
  				
  				if($result['room_options'] != "0")
  				{
  					
  					$cbc = explode(",", $result['room_options']);
				//	print_r($cbc);
					//echo count($cbc).'<br/>';
					
					for($c=0;$c < count($cbc);$c++)
  					{
  					//	echo $cbc[$c].'<br/>';
  					//	echo (int)$cbc[$c].'<br/>';
  						$tc_cbc[] = (int)$cbc[$c];
   					}
   					//print_r($tc_cbc);
  				}	
  				else
  				{
  					$tc_cbc[] = -1;
  				}
  				
  				
  				if($result['room_items'] != "0")
  				{
  					
					$items = explode(",", $result['room_items']);
					
					for($k=0;$k<count($items);$k++)
  					{
  						$tc_items[] = (int)$items[$k];
  					}
  					
  				}
  				else
  				{
  					$tc_items[] = -1;
  				}
  				
  				$courseid = (int)$result['courseid'];
				$collegeid = (int)$result['collegeid'];
				$departmentid = (int)$result['departmentid'];
				$subjectid = (int)$result['subjectid'];
				$faculty_credits = (float)$result['faculty_credits'];
				$course_capacity = (int)$result['course_capacity'];
				
				$message = peb_encode("[{~i,~i,~i,~i,~f,[".implode(",",array_fill(0, count($tc_types),"~i"))."],~i,"
				."[".implode(",", array_fill(0,count($tc_cbc),"~i"))."],"
				."[".implode(",", array_fill(0,count($tc_items),"~i"))."]}]",array(array(array($courseid, $collegeid, $departmentid, $subjectid, $faculty_credits, $tc_types, $course_capacity, $tc_cbc, $tc_items))));
			
				rpc("send1", $message);	
			
			}
		}
			
		
		else
		{
			echo 'Database Error. No Data Entries: COURSES.';
		}

}

function sendLocations()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM locations";
	$dbrows = $dbconn->query($dbquery);

		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				if($result['location_department'] != 0)
				{
					$string_departments = $result['location_department'];
					$trimmed_departments = rtrim($string_departments,",");
	  				$departments = explode(",", $trimmed_departments);
	  				
	  				for($j=0;$j<count($departments);$j++)
  					{
  						$tc_departments[] = (int)$departments[$j];
  					}	
				}
				else
				{
					$tc_departments = array(-1);
				}
				if($result['location_type'] != 0)
				{
					$string_types = $result['location_type'];
					$trimmed_types = rtrim($string_types, ",");
					$types = explode("," ,$trimmed_types);
					
					for($j=0;$j<count($types);$j++)
  					{
  						$tc_types[] = (int)$types[$j];
  					}
				}
				else
				{
					$tc_types = array(-1);
				}
				if($result['location_items'] != 0)
				{
					$string_items = $result['location_items'];
					$trimmed_items = rtrim($string_items, ",");
					$items = explode(",", $trimmed_items);
					
					for($j=0;$j<count($items);$j++)
  					{
  						$tc_items[] = (int)$items[$j];
  					}
				}
				else
				{
					$tc_items = array(-1);
				}
				
				$locationid = (int)$result['locationid'];
				$location_college = (int)$result['location_college'];
				$location_capacity = (int)$result['location_capacity'];
				
				$message = peb_encode("[{~i,~i,[".implode(",", array_fill(0, count($departments),"~i"))."],"
				."[".implode(",",array_fill(0,count($types),"~i"))."],~i"
				."[".implode(",",array_fill(0,count($items),"~i"))."]}]",array(array(array($locationid, $location_college, $tc_departments, $tc_types, $location_capacity, $tc_items))));
			
				rpc("send1", $message);
			
			}
			
		}
		else
		{
			echo 'Database Error. No Data Entries: LOCATIONS.';
		}
	
}

function sendFaculties()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM faculties";
	$dbrows = $dbconn->query($dbquery);

	if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				if($result['faculty_teachables'] != 0)
				{	
					$string_teachables = $result['faculty_teachables'];
					$trimmed_teachables = rtrim($string_teachables,",");
	  				$teachables = explode(",", $trimmed_teachables);
	  				
	  				for($j=0;$j<count($teachables);$j++)
  					{
  						$tc_teachables[$j] = (int)$teachables[$j];
  					}
				}
				else
				{
					$tc_teachables[0] = -1;
				}
				if($result['faculty_preftime'] != 0)
				{
					$string_preftime = $result['faculty_preftime'];
					$trimmed_preftime = rtrim($string_preftime, ",");
					$preftime = explode("," ,$trimmed_preftime);
					
					for($j=0;$j<count($preftime);$j++)
  					{
  						$tc_preftime[$j] = (int)$preftime[$j];
  					}
				}
				else
				{
					$tc_preftime[0] = -1;
				}
				if($result['faculty_prefloc'] != 0)
				{
					$string_prefloc = $result['faculty_prefloc'];
					$trimmed_prefloc = rtrim($string_prefloc, ",");
					$prefloc = explode(",", $trimmed_prefloc);
					
					//print_r($prefloc);
					
					
					for($j=0;$j<count($prefloc);$j++)
  					{
  						$tc_prefloc[$j] = (int)$prefloc[$j];
  					}
  					//print_r($tc_prefloc);
				}
				else
				{
					$tc_prefloc[0] = -1;
				}
				if($result['lim_location'] != 0)
				{
					$string_lim_location = $result['lim_location'];
					$trimmed_lim_location = rtrim($string_lim_location, ",");
					$lim_location = explode(",", $trimmed_lim_location);
					
					for($j=0;$j<count($lim_location);$j++)
  					{
  						$tc_lim_location[$j] = (int)$lim_location[$j];
  					}
				}
				else
				{
					$tc_lim_location[0] = -1;
				}
				if($result['lim_time'] != 0)
				{
					$string_lim_time = $result['lim_time'];
					$change_delimiter = str_replace("},{", ";", $string_lim_time);
					$remove_obracket = str_replace("{", "", $change_delimiter);
					$remove_cbracket = str_replace("}", "", $remove_obracket);
					$lim_time = explode(";", $remove_cbracket);
					
					
					for($j=0;$j<count($lim_time);$j++)
  					{
  						$tc_lim_time[$j] =  $lim_time[$j];
  					}
				}
				else
				{
					$tc_lim_time[0] = -1;
				}
				
				$facultyid = (int)$result['facultyid'];
				$faculty_college = (int)$result['faculty_college'];
				$faculty_department = (int)$result['faculty_department'];
				$faculty_minload = (float)$result['faculty_minload'];
				$faculty_maxload = (float)$result['faculty_maxload'];
				$targetload = (float)$result['faculty_targetload'] ;
				
				
				
				$message = peb_encode("[{~i,~i,~i,[".implode(",", array_fill(0, count($teachables), "~i"))."],~f,~f,~f,[".implode(",", array_fill(0, $preftime.length, "~i"))."],[".implode(",", array_fill(0, count($prefloc), "~i"))."],[".implode(",", array_fill(0, count($lim_location), "~i"))."],[".implode(",", array_fill(0, count($lim_time), "~i"))."]}]", array(array(array($facultyid, $faculty_college, $faculty_department, $tc_teachables, $faculty_minload, $faculty_maxload, $targetload, $tc_preftime, $tc_prefloc, $tc_lim_location, $tc_lim_time))));
				
				//rpc("send1", $message);
				
			}
			
		}
		else
		{
			echo 'Database Error. No Data Entries: FACULTY.';
		}
	
}

function sendTimeslots()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM timeslots";
	$dbrows = $dbconn->query($dbquery);


	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$tc_timeslot_types = array();
			$details = array();
			
			if($result['timeslot_types'] != 0)
			{	
				$trimmed_timeslot_types = rtrim($result['timeslot_types'],",");
				$timeslot_types = explode(",", $trimmed_timeslot_types);
				
				for($j=0;$j<count($timeslot_types);$j++)
  					{
  						$tc_timeslot_types[] = (int)$timeslot_types[$j];
  					}
			}
			else
			{
				$tc_timeslot_types[] = -1;
			}
			
			if($result['timeslot_details'] != 0) 
			{
				$string_timeslot_details = $result['timeslot_details'];
				$change_delimiter = str_replace("},{", ";", $string_timeslot_details);
				$remove_obracket = str_replace("{", "", $change_delimiter);
				$remove_cbracket = str_replace("}", "", $remove_obracket);
				$timeslot_details = explode(";", $remove_cbracket);
				
				for($f=0;$f<count($timeslot_details);$f++)
				{
					$td = explode(",", $timeslot_details[$f]);
					$ftd = array();
					for($t=0;$t<count($td);$t++)
					{
						$ftd[] = (int)$td[$t]; 
					}
					$details[] = $ftd;
				}
			}
			else
			{
				$details[] = -1;
			}
				
			
			$timeslotid = (int)$result['timeslotid'];
			$timeslot_priority = $result['timeslot_priority'];
			
			$message = peb_encode("[{~i,[".implode(",", array_fill(0, count($tc_timeslot_types), "~i"))."],~a,[".implode(",", array_fill(0, count($details), "{~i, ~i},"))."]}]", array(array(array($timeslotid, $tc_timeslot_types, $timeslot_priority, $details))));
		
			rpc("send1", $message);
		}
		
		
	}
	else
	{
		echo 'Database Error. No Data Entries: TIMESLOTS.';
	}

}

function sendFacultyEvents()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM faculty_events";
	$dbrows = $dbconn->query($dbquery);

	
	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			
			if($result['event_type'] != 0)
			{
				$string_event_types = $result['event_type'];
				$trimmed_event_types = rtrim($string_event_types,",");
				$event_types = explode(",", $trimmed_event_types);
				
				for($j=0;$j<count($event_types);$j++)
  					{
  						$tc_event_types[] = (int)$event_types[$j];
  					}
			}
			else
			{
				$tc_event_types = array(-1);
			}
			if($result['event_preftimeslot'] != 0)
			{	
				$string_event_preftimeslot = $result['event_preftimeslot'];
				$trimmed_event_preftimeslot = rtrim($string_event_preftimeslot, ",");
				$event_preftimeslot = explode("," ,$trimmed_event_preftimeslot);
				
				for($j=0;$j<count($event_preftimeslot);$j++)
  					{
  						$tc_event_preftimeslot[] = (int)$event_preftimeslot[$j];
  					}
			}
			else
			{
				$tc_event_preftimeslot = array(-1);
			}
			$eventid = (int)$result['eventid'];
			$collegeid = (int)$result['collegeid'];
			$departmentid = (int)$result['departmentid'];
			$event_scope = $result['event_scope'];	
					
			$message = peb_encode("[{~i,~i,~i,~a,[".implode(",",array_fill(0, count($event_types), "~i"))."],[".implode(",", array_fill(0, count($event_preftimeslot), "~i"))."]}]", array(array(array($eventid, $collegeid, $departmentid, $event_scope, $tc_event_types, $tc_event_preftimeslot))));
			
			rpc("send1", $message);
			
			
		}
	
	}
	else
	{
		echo 'Database Error. No Data Entries: FACULTY EVENTS.';
	}

}
		set_time_limit(0);
		connect();
		
	
		$username = 'jenn';
		
		
		$userarg = peb_encode("[~a]", array(array($username)));
		$x = rpc("search_begin", $userarg);
		
		if($x == "search_begin") 
		{
		
		// 1. send parameters
			if(rpc("params_begin", $userarg) == 'params_begin') 
			{
				//cycle the params and rpc send1(Msg), Msg = {Param, Val}
				rpc("send1", peb_encode("[{~a,~i}]", array(array(array("timelimit", 30))))); //sample
				rpc("send1", peb_encode("[{~a,~i}]", array(array(array("m", 4))))); //sample
				rpc("send1", peb_encode("[{~a,~i}]", array(array(array("apc", 5))))); //sample
				rpc("send1", peb_encode("[{~a,~a}]", array(array(array("fullEval", "false"))))); //sample
			
				$params_done = rpc("params_done", $userarg);
				if($params_done != "params_ok") die("unknown myclass error after sending parameters<br />");
			}
			else
				die("unknown myclass error on sending parameters</br>");
		
		// 2. send "elists"
			if(rpc("elists_begin", $userarg) == 'elists_begin') 
			{
				//send 5 elists as arrays, rpc send1(Msg), Msg = [<int>] | [] | 0
				//rpc("send1", peb_encode("[[~i,~i,~i,~i,~i]]", array(array(array(1,2,3,4,5))))); //sample
				rpc("send1", peb_encode("[~i]", array(array(0)))); //sample
				rpc("send1", peb_encode("[~i]", array(array(0)))); //sample
				rpc("send1", peb_encode("[~i]", array(array(0)))); //sample
				rpc("send1", peb_encode("[~i]", array(array(0)))); //sample
				rpc("send1", peb_encode("[~i]", array(array(0)))); //sample
			
				$elists_done = rpc("elists_done", $userarg);
				if($elists_done != "elists_ok") die("myclass error: $elists_done<br />");
			}
			else
				die("unknown myclass error on sending elists</br>");
		
		// 3. send existing solution
			if(rpc("esol_begin", $userarg) == 'esol_begin') 
			{
				//cycle the existing solution and rpc send1(Msg), Msg = <solution component>
			
				$esol_done = rpc("esol_done", $userarg);
				if($esol_done != "esol_ok") die("myclass error: $esol_done<br />");
			}
			else
				die("unknown myclass error on sending existing solution</br>");
		
		// 4. send distributed node list
			if(rpc("nodes_begin", $userarg) == 'nodes_begin') 
			{
				//send the node list as just one list, and rpc send1(Msg), Msg = [<string>] | []
				//rpc("send1", peb_encode("[[~a,~a]]", array(array(array("slave1@127.0.0.1", "slave2@127.0.0.1"))))); //sample
				rpc("send1", peb_encode("[[]]", array(array(array())))); //sample
			
				$nodes_done = rpc("nodes_done", $userarg);
				if($nodes_done != "nodes_ok") die("unknown myclass error after sending nodes<br />");
			}
			else
				die("unknown myclass error on sending nodes</br>");
		
		// 5. send the search space
			if(rpc("ss_begin", $userarg) == 'ss_begin') 
			{
				//send the search space in order
					include("sampledata.php"); //sample
			
					// attributes
					if(rpc("attributes_begin", $userarg) == 'attributes_begin')
					{
				
						sendColleges();
						sendDepartments();
						sendTypes();
						sendItems();
						sendDays();
						sendTime();
				
						$attributes_done = rpc("attributes_done", $userarg);
						if($attributes_done != "attributes_ok") die("myclass error: $attributes_done<br />");
					}
					else
						die("unknown myclass error on sending the attributes</br>");

					// courses
					if(rpc("courses_begin", $userarg) == 'courses_begin') 
					{
			
						sendCourses();
				
						$courses_done = rpc("courses_done", $userarg);
						if($courses_done != "courses_ok") die("myclass error: $courses_done<br />");
					}
					else
						die("unknown myclass error on sending the courses</br>");

					// timeslots
					if(rpc("timeslots_begin", $userarg) == 'timeslots_begin') {
		
						sendTimeslots();
				
						$timeslots_done = rpc("timeslots_done", $userarg);
						if($timeslots_done != "timeslots_ok") die("myclass error: $timeslots_done<br />");
					}
					else
						die("unknown myclass error on sending the timeslots</br>");

					// locations
					if(rpc("locations_begin", $userarg) == 'locations_begin') {
				
						sendLocations();
				
						$locations_done = rpc("locations_done", $userarg);
						if($locations_done != "locations_ok") die("myclass error: $locations_done<br />");
					}
					else
						die("unknown myclass error on sending the locations</br>");

					// faculties
					if(rpc("faculties_begin", $userarg) == 'faculties_begin') {
			
						sendFaculties();
				
						$faculties_done = rpc("faculties_done", $userarg);
						if($faculties_done != "faculties_ok") die("myclass error: $faculties_done<br />");
					}
					else
						die("unknown myclass error on sending the faculties</br>");

					// faculty events
					if(rpc("facultyevents_begin", $userarg) == 'facultyevents_begin') {
			
						sendFacultyEvents();
				
						$facultyevents_done = rpc("facultyevents_done", $userarg);
						if($facultyevents_done != "facultyevents_ok") die("myclass error: $facultyevents_done<br />");
					}
					else
						die("unknown myclass error on sending the faculty events</br>");
			
					$ss_done = rpc("ss_done", $userarg);
					if($ss_done != "ss_ok") die("unknown myclass error after sending the search space<br />");
			}
			else
				die("unknown myclass error on sending the search space</br>");

			echo "Now searching...";
		}
		else 
			die("myclass error: " . $x . "<br />");

		peb_close();
	
?>

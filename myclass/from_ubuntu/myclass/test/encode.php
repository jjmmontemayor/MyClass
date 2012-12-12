<?php
require '../includes/dbconnector.php';
include 'erlconnector.php';
ini_set("display_errors", 0); 


function sendColleges()
{
	$dbconn = new dbConnector();
	$dbquery = "SELECT * FROM colleges";
	$dbrows = $dbconn->query($dbquery);
	
	
	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$message = peb_encode("[{{~a, ~i}, ~a}]", array(array(array(array("college,",$result['collegeid']), $result['college_desc']))));
			
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
			$message = peb_encode("[{{~a, ~i}, ~a}]", array(array(array(array("department,",$result['departmentid']), $result['department_desc']))));
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
			$message = peb_encode("[{{~a, ~i}, ~a}]", array(array(array(array("type,",$result['typeid']), $result['type_desc']))));
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
			$message = peb_encode("[{{~a, ~i}, ~a}]", array(array(array(array("item,",$result['itemid']), $result['item_desc']))));
			
			rpc("send1", $message);
		}
	}
	else
	{
		echo 'Database Error. No Data Entries: ITEMS.';
	}
	
}

/*function sendScopes()
{
	dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM scopes";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("scopes_begin"));
	$result = $erl->receive($link);

	if($result[0][0] == 'scopes_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("scope,",$result['scopeid']), $result['scope_desc']))));
			}
			$erl->send("~a", array("scopes_done"));
			$result = $erl->receive($link);

			if($result[0][0] != 'scopes_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: SCOPES.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}*/

function sendDays()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM days";
	$dbrows = $dbconn->query($dbquery);

	
	if($dbrows)
	{
		while ($result = $dbconn->fetch_assoc($dbrows))
		{
			$message = peb_encode("[{{~a, ~i}, ~a}]", array(array(array(array("day,",$result['dayid']), $result['day_code']))));
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
				$message = peb_encode("[{{~a, ~i}, ~a}]", array(array(array(array("time,",$result['time']), $result['time_desc']))));
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
	$dbrows = $dbconn->query($dbquery);

	
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$string_type = $result['typeid'];
				$trimmed_type = rtrim($string_type,",");
  				$type = explode(",", $trimmed_type);

				$string_cbc = $result['room_options'];
				$trimmed_cbc = rtrim($string_cbc, ",");
				$cbc = explode(",", $trimmed_cbc);

				$string_items = $result['room_items'];
				$trimmed_items = rtrim($string_items, ",");
				$items = explode(",", $trimmed_items);
				
				
				$message = peb_encode("[{~i, ~i, ~i, ~i, ~i, [". implode(",", array_fill(0, $type.length, "~i")) ."], ~i,"
				. "[". implode(",", array_fill(0, $cbc.length, "~i")) ."],"
				. "[". implode(",", array_fill(0, $item.length, "~i")) ."]}]", array(array(array($result['courseid'], $result['collegeid'], $result['departmentid'], $result['subjectid'], $result['faculty_credits'],
					$type, $result['course_capacity'], $cbc, $item))));
			
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
				
				$string_departments = $result['location_department'];
				$trimmed_departments = rtrim($string_departments,",");
  				$departments = explode(",", $trimmed_departments);

				$string_types = $result['location_type'];
				$trimmed_types = rtrim($string_types, ",");
				$types = explode("," ,$trimmed_types);

				$string_items = $result['location_items'];
				$trimmed_items = rtrim($string_items, ",");
				$items = explode(",", $trimmed_items);
				
				
				$message = peb_encode("[{~i, ~i, [". implode(",", array_fill(0, $departments.length, "~i")) ."], "
				. "[". implode(",", array_fill(0, $types.length, "~i")) ."], ~i"
				. "[". implode(",", array_fill(0, $items.length, "~i")) ."]}]", array(array(array($result['locationid'], $result['location_college'], $departments, $types, $result['location_capacity'], $items))));
			
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
				
				$string_teachables = $result['faculty_teachables'];
				$trimmed_teachables = rtrim($string_teachables,",");
  				$teachables = explode(",", $trimmed_teachables);

				$string_preftime = $result['faculty_preftime'];
				$trimmed_preftime = rtrim($string_preftime, ",");
				$preftime = explode("," ,$trimmed_preftime);

				$string_prefloc = $result['faculty_prefloc'];
				$trimmed_prefloc = rtrim($string_prefloc, ",");
				$prefloc = explode(",", $trimmed_prefloc);
				
				$string_lim_location = $result['lim_location'];
				$trimmed_lim_location = rtrim($string_lim_location, ",");
				$lim_location = explode(",", $trimmed_lim_location);

				$string_lim_time = $result['lim_time'];
				$trimmed_lim_time = rtrim($string_lim_time, ",");
				$lim_time = explode(",", $trimmed_lim_time);


				$targetload = "17";
				
				$message = peb_encode("[{~i, ~i, ~i, [". implode(",", array_fill(0, $teachables.length, "~i")) ."], ~i, ~i, ~i, [". implode(",", array_fill(0, $preftime.length, "~i")) ."], [". implode(",", array_fill(0, $prefloc.length, "~i")) ."],[".implode(",", array_fill(0, $lim_location.length, "~i"))."],[".implode(",", array_fill(0, $lim_time.length, "~i"))."]}]", array(array(array($result['facultyid'], $result['faculty_college'], $result['faculty_department'], $teachables, $result['faculty_minload'], $result['faculty_maxload'], $targetload, $preftime, $prefloc, $lim_location, $lim_time))));
				
				rpc("send1", $message);
				
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
			
			$string_timeslot_types = $result['timeslot_types'];
			$trimmed_timeslot_types = rtrim($string_timeslot_types,",");
			$timeslot_types = explode(",", $trimmed_timeslot_types);

			$string_timeslot_details = $result['timeslot_details'];
			$trimmed_timeslot_details = rtrim($string_timeslot_details, ",");
			$timeslot_details = explode(",", $trimmed_timeslot_details);

			
			$message = peb_encode("[{~i,[". implode(",", array_fill(0, $timeslot_types.length, "~i")) ."],~i,[". implode(",", array_fill(0, $timeslot_details.length, "~i")) ."]}]", array(array(array($result['timeslotid'], $timeslot_types, $result['timeslot_priority'], $timeslot_details ))));
		
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
			
			$string_event_types = $result['event_type'];
			$trimmed_event_types = rtrim($string_event_types,",");
			$event_types = explode(",", $trimmed_event_types);

			$string_event_preftimeslot = $result['event_preftimeslot'];
			$trimmed_event_preftimeslot = rtrim($string_event_preftimeslot, ",");
			$event_preftimeslot = explode("," ,$trimmed_event_preftimeslot);

			
			$message = peb_encode("[{~i,~i,~i,~i,[". implode(",", array_fill(0, $event_types.length, "~i")) ."], [". implode(",", array_fill(0, $event_preftimeslot.length, "~i")) ."]}]", array(array(array($result['eventid'],$result['collegeid'],$result['departmentid'],$result['event_scope'],$event_types,$event_preftimeslot))));
			
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

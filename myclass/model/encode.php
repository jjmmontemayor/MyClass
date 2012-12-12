<?php
require 'dbconnector.php';
require 'erlconnector.php';

class encode()
{

function sendCollege()
{
	$dbconn = new dbConnector();
	$dbquery = "SELECT * FROM colleges";
	$dbrows = $dbconn->query($dbquery);
	
	
	$erl = new erlConnector();
	$erl->send("~a", array("colleges_begin"));
	$result = $erl->receive();

		if($result[0][0] == 'colleges_accepting')
		{
			if($dbrows)
			{
				while ($result = $dbconn->fetch_assoc($dbrows))
				{
					$erl->send("{{~a, ~i}, ~a}", array(array(array("college,",$result['collegeid']), $result['college_desc']))));
				}
				$erl->send("~a", array("colleges_done"));
				$result = $erl->receive();

				if($result[0][0] != 'colleges_ok')
				{
					echo 'Erlang Error: '.$result[0][3];				
				}
			}
			else
			{
				echo 'Database Error. No Data Entries: COLLEGES';
			}
		}
		else	
		{
			echo 'Erlang Error: '.$result[0][3];
		}

}

function sendDepartments()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM departments";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("departments_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'departments_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("department,",$result['departmentid']), $result['department_desc']))));
			}
			$erl->send("~a", array("departments_done"));
			$result = $erl->receive();

			if($result[0][0] != 'departments_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: DEPARTMENTS.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}

}

function sendTypes()
{
	dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM types";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("types_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'types_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("type,",$result['typeid']), $result['type_desc']))));
			}
			$erl->send("~a", array("types_done"));
			$result = $erl->receive();

			if($result[0][0] != 'types_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: TYPE.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
	

}

function sendItems()
{
	dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM items";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("items_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'items_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("item,",$result['itemid']), $result['item_desc']))));
			}
			$erl->send("~a", array("items_done"));
			$result = $erl->receive();

			if($result[0][0] != 'items_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: ITEMS.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}

function sendScopes()
{
	dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM scopes";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("scopes_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'scopes_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("scope,",$result['scopeid']), $result['scope_desc']))));
			}
			$erl->send("~a", array("scopes_done"));
			$result = $erl->receive();

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
}

function sendDays()
{
	dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM days";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("days_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'days_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("day,",$result['dayid']), $result['day_code']))));
			}
			$erl->send("~a", array("days_done"));
			$result = $erl->receive();

			if($result[0][0] != 'days_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: DAYS.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}

function sendTime()
{
	dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM time";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("time_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'time_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$erl->send("{{~a, ~i}, ~a}", array(array(array("time,",$result['time']), $result['time_desc']))));
			}
			$erl->send("~a", array("time_done"));
			$result = $erl->receive();

			if($result[0][0] != 'time_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: TIME.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}

function sendCourses()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT k.courseid, c.collegeid, d.departmentid, s.subjectid, s.faculty_credits, s.typeid, k.course_capacity, s.room_options, 		s.room_items FROM colleges c, departments d, subjects s, courses k WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid AND s.subjectid = k.course_subjectid";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("courses_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'courses_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				$string_type = $result['typeid'];
				$trimmed_type = rtrim($string_type,",");
  				$type = explode(",", $trimmed_type);

				$string_cbc = $result['room_options'];
				$trimmed_cbc = rtrim($string_cbc, ",");
				$cbc = explode("," $trimmed_cbc);

				$string_items = $result['room_items'];
				$trimmed_items = rtrim($string_items, ",");
				$items = explode(",", $trimmed_items);
				
				
				$erl->send("{~i, ~i, ~i, ~i, ~i, [". implode(",", array_fill(0, $type.length, "~i")) ."], ~i,"
				. "[". implode(",", array_fill(0, $cbc.length, "~i")) ."],"
				. "[". implode(",", array_fill(0, $item.length, "~i")) ."]}", array(array($result['courseid'], $result['collegeid'], $result['departmentid'], $result['subjectid'], $result['faculty_credits'],
					$type, $result['course_capacity'], $cbc, $item)));
			}
			$erl->send("~a", array("courses_done"));
			$result = $erl->receive();

			if($result[0][0] != 'courses_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: COURSES.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}

function sendLocations()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM locations";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("location_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'locations_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				
				$string_departments = $result['location_department'];
				$trimmed_departments = rtrim($string_departments,",");
  				$departments = explode(",", $trimmed_departments);

				$string_types = $result['location_type'];
				$trimmed_types = rtrim($string_types, ",");
				$types = explode("," $trimmed_types);

				$string_items = $result['location_items'];
				$trimmed_items = rtrim($string_items, ",");
				$items = explode(",", $trimmed_items);
				
				
				$erl->send("{~i, ~i, [". implode(",", array_fill(0, $departments.length, "~i")) ."], "
				. "[". implode(",", array_fill(0, $types.length, "~i")) ."], ~i"
				. "[". implode(",", array_fill(0, $items.length, "~i")) ."]}", array(array($result['locationid'], $result['location_college'], $departments, $types, $result['location_capacity'], $items)));
			}
			$erl->send("~a", array("locations_done"));
			$result = $erl->receive();

			if($result[0][0] != 'locations_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: LOCATIONS.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}

function sendFaculties()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM faculties";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("faculty_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'faculty_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				
				$string_teachables = $result['faculty_teachables'];
				$trimmed_teachables = rtrim($string_teachables,",");
  				$teachables = explode(",", $trimmed_teachables);

				$string_preftime = $result['faculty_preftime'];
				$trimmed_preftime = rtrim($string_preftime, ",");
				$preftime = explode("," $trimmed_preftime);

				$string_prefloc = $result['faculty_prefloc'];
				$trimmed_prefloc = rtrim($string_prefloc, ",");
				$prefloc = explode(",", $trimmed_prefloc);
				
				$targetload = "17";
				
				$erl->send("{~i, ~i, ~i, [". implode(",", array_fill(0, $teachables.length, "~i")) ."], ~i, ~i, ~i, [". implode(",", array_fill(0, $preftime.length, "~i")) ."], [". implode(",", array_fill(0, $prefloc.length, "~i")) ."]}", array(array($result['facultyid'], $result['faculty_college'], $result['faculty_department'], $teachables, $result['faculty_minload'], $result['faculty_maxload'], $targetload, $preftime, $prefloc )));
			}
			$erl->send("~a", array("faculty_done"));
			$result = $erl->receive();

			if($result[0][0] != 'faculty_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: FACULTY.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}

function sendTimeslots()
{
	$dbconn = new dbConnector();	
	$dbquery = "SELECT * FROM timeslots";
	$dbrows = $dbconn->query($dbquery);

	$erl = new erlConnector();
	$erl->send("~a", array("timeslots_begin"));
	$result = $erl->receive();

	if($result[0][0] == 'timeslots_accepting')
	{
		if($dbrows)
		{
			while ($result = $dbconn->fetch_assoc($dbrows))
			{
				
				$string_timeslot_types = $result['timeslot_types'];
				$trimmed_timeslot_types = rtrim($string_timeslot_types,",");
  				$timeslot_types = explode(",", $trimmed_timeslot_types);

				$string_timeslot_details = $result['timeslot_details'];
				$trimmed_timeslot_details = rtrim($string_timeslot_details, ",");
				$timeslot_details = explode("," $trimmed_timeslot_details);

				
				$erl->send("{~i, [". implode(",", array_fill(0, $timeslot_types.length, "~i")) ."], ~i, [". implode(",", array_fill(0, $timeslot_details.length, "~i")) ."]}", array(array($result['timeslotid'], $timeslot_types, $result['timeslot_priority'], $timeslot_details )));
			}
			$erl->send("~a", array("timeslots_done"));
			$result = $erl->receive();

			if($result[0][0] != 'timeslots_ok')
			{
				echo 'Erlang Error: '.$result[0][3];				
			}
		}
		else
		{
			echo 'Database Error. No Data Entries: TIMESLOTS.';
		}
	}
	else	
	{
		echo 'Erlang Error: '.$result[0][3];
	}
}
}
?>

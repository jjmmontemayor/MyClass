<?php
include_once("../includes/erlconnector.php");

class myClass
{

function activate()
{
	set_time_limit(0);
	connect();

	$x = rpc("is_on", peb_encode("[]", array(array())));
	if($x == "true") {
		echo "Myclass is already on.<br />";
	}
	else {
		rpc("start", peb_encode("[]", array(array())));
		echo "Myclass is now turned on.<br />";
	}
	
	peb_close();
}

function start($username)
{
	set_time_limit(0);
	connect();
	$userarg = peb_encode("[~a]", array(array($username)));
	$x = rpc("search_begin", $userarg);
	if($x == "search_begin") {
		
		// 1. send parameters
		if(rpc("params_begin", $userarg) == 'params_begin') {
			//cycle the params and rpc send1(Msg), Msg = {Param, Val}
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("timelimit", 60*30))))); //sample
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("m", 1))))); //sample
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("apc", 1))))); //sample
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("cg", 3)))));
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("alpha", 1)))));
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("beta", 1))))); //sample //sample //sample
			rpc("send1", peb_encode("[{~a,~f}]", array(array(array("pr", 0.2))))); //sample
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("ad", 5))))); //sample
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("zap", 10))))); //sample
			rpc("send1", peb_encode("[{~a,~i}]", array(array(array("iap", 1000)))));
			 rpc("send1", peb_encode("[{~a,~i}]", array(array(array("qi", 999999)))));
			 rpc("send1", peb_encode("[{~a,~i}]", array(array(array("ifs", 40)))));
			 rpc("send1", peb_encode("[{~a,~a}]", array(array(array("ls", "true")))));
			 rpc("send1", peb_encode("[{~a,~a}]", array(array(array("ibu", "true")))));
			 rpc("send1", peb_encode("[{~a,~i}]", array(array(array("str", 12)))));
			 rpc("send1", peb_encode("[{~a,~i}]", array(array(array("pd", 1)))));
			rpc("send1", peb_encode("[{~a,~a}]", array(array(array("fullEval", "true"))))); //sample
			
			$params_done = rpc("params_done", $userarg);
			if($params_done != "params_ok") die("unknown myclass error after sending parameters<br />");
		}
		else
			die("unknown myclass error on sending parameters</br>");
		
		// 2. send "elists"
		if(rpc("elists_begin", $userarg) == 'elists_begin') {
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
		if(rpc("esol_begin", $userarg) == 'esol_begin') {
			//cycle the existing solution and rpc send1(Msg), Msg = <solution component>
			
			$esol_done = rpc("esol_done", $userarg);
			if($esol_done != "esol_ok") die("myclass error: $esol_done<br />");
		}
		else
			die("unknown myclass error on sending existing solution</br>");
		
		// 4. send distributed node list
		if(rpc("nodes_begin", $userarg) == 'nodes_begin') {
			//send the node list as just one list, and rpc send1(Msg), Msg = [<string>] | []
			//rpc("send1", peb_encode("[[~a,~a]]", array(array(array("slave1@127.0.0.1", "slave2@127.0.0.1"))))); //sample
			rpc("send1", peb_encode("[[]]", array(array(array())))); //sample
			
			$nodes_done = rpc("nodes_done", $userarg);
			if($nodes_done != "nodes_ok") die("unknown myclass error after sending nodes<br />");
		}
		else
			die("unknown myclass error on sending nodes</br>");
		
		// 5. send the search space
		if(rpc("ss_begin", $userarg) == 'ss_begin') {
			//send the search space in order
			include("../connect/sampledata.php"); //sample
			
			// attributes
			if(rpc("attributes_begin", $userarg) == 'attributes_begin') {
				foreach($attributes as $x) { //sample
					rpc("send1", peb_encode("[{{~a,~i},~a}]", array($x)));
				}
				unset($attributes);
				$attributes_done = rpc("attributes_done", $userarg);
				if($attributes_done != "attributes_ok") die("myclass error: $attributes_done<br />");
			}
			else
				die("unknown myclass error on sending the attributes</br>");

			// courses
			if(rpc("courses_begin", $userarg) == 'courses_begin') {
				foreach($courses as $x) { //sample
					$types = array();
					foreach($x[0][5] as $x1) {
						$types[] = "~i";
					}
					$cbc = array();
					foreach($x[0][7] as $x1) {
						$cbc[] = "~i";
					}
					$items = array();
					foreach($x[0][8] as $x1) {
						$items[] = "~i";
					}
					rpc("send1", peb_encode("[{~i,~i,~i,~i,~f,[" 
						. implode(",", $types) 
						. "],~i,["
						. implode(",", $cbc) 
						. "],["
						. implode(",", $items) 
						. "]}]", array($x)));
				}
				unset($courses);
				$courses_done = rpc("courses_done", $userarg);
				if($courses_done != "courses_ok") die("myclass error: $courses_done<br />");
			}
			else
				die("unknown myclass error on sending the courses</br>");

			// timeslots
			if(rpc("timeslots_begin", $userarg) == 'timeslots_begin') {
				foreach($timeslots as $x) { //sample
					$types = array();
					foreach($x[0][1] as $x1) {
						$types[] = "~i";
					}
					$details = array();
					foreach($x[0][3] as $x1) {
						$details[] = "{~i,~i}";
					}
					rpc("send1", peb_encode("[{~i,[" 
						. implode(",", $types) 
						. "],~a,[" 
						. implode(",", $details) 
						. "]}]", array($x)));
				}
				unset($timeslots);
				$timeslots_done = rpc("timeslots_done", $userarg);
				if($timeslots_done != "timeslots_ok") die("myclass error: $timeslots_done<br />");
			}
			else
				die("unknown myclass error on sending the timeslots</br>");

			// locations
			if(rpc("locations_begin", $userarg) == 'locations_begin') {
				foreach($locations as $x) { //sample
					$deps = array();
					foreach($x[0][2] as $x1) {
						$deps[] = "~i";
					}
					$types = array();
					foreach($x[0][3] as $x1) {
						$types[] = "~i";
					}
					$items = array();
					foreach($x[0][5] as $x1) {
						$details[] = "~i";
					}
					rpc("send1", peb_encode("[{~i,~i,[" 
						. implode(",", $deps) 
						. "],[" 
						. implode(",", $types) 
						. "],~i,["
						. implode(",", $items) 
						. "]}]", array($x)));
				}
				unset($locations);
				$locations_done = rpc("locations_done", $userarg);
				if($locations_done != "locations_ok") die("myclass error: $locations_done<br />");
			}
			else
				die("unknown myclass error on sending the locations</br>");

			// faculties
			if(rpc("faculties_begin", $userarg) == 'faculties_begin') {
				foreach($faculties as $x) { //sample
					$teaches = array();
					foreach($x[0][3] as $x1) {
						$teaches[] = "~i";
					}
					$ptime = array();
					foreach($x[0][7] as $x1) {
						$ptime[] = "~i";
					}
					$plocs = array();
					foreach($x[0][8] as $x1) {
						$plocs[] = "~i";
					}
					$ltime = array();
					foreach($x[0][9] as $x1) {
						if(is_array($x1)) {
							$ltime[] = "{~i,~i}";
						}
						else $ltime[] = "~i";
					}
					$llocs = array();
					foreach($x[0][10] as $x1) {
						$llocs[] = "~i";
					}
					rpc("send1", peb_encode("[{~i,~i,~i,["
						. implode(",", $teaches)
						. "],~f,~f,~f,["
						. implode(",", $ptime)
						. "],["
						. implode(",", $plocs)
						. "],["
						. implode(",", $ltime)
						. "],["
						. implode(",", $llocs)
						. "]}]", array($x)));
				}
				unset($faculties);
				$faculties_done = rpc("faculties_done", $userarg);
				if($faculties_done != "faculties_ok") die("myclass error: $faculties_done<br />");
			}
			else
				die("unknown myclass error on sending the faculties</br>");

			// faculty events
			if(rpc("facultyevents_begin", $userarg) == 'facultyevents_begin') {
				foreach($facultyevents as $x) { //sample
					$types = array();
					foreach($x[0][4] as $x1) {
						$types[] = "~i";
					}
					$ptime = array();
					foreach($x[0][5] as $x1) {
						$ptime[] = "~i";
					}
					rpc("send1", peb_encode("[{~i,~i,~i,~a,[" . implode(",", $types) . "],[" . implode(",", $ptime) . "]}]", array($x)));
					//rpc("send1", peb_encode("[{~i,~i,~i,~a,[~i],[]}]", array(array(array(1, 1, 1, "department", array(5), array())))));
				}
				unset($facultyevents);
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

}

function deactivate()
{
	set_time_limit(0);
	connect();

	$x = rpc("is_on", peb_encode("[]", array(array())));
	if($x == "true") {
		rpc("stop", peb_encode("[]", array(array())));
		echo "Myclass has been turned off.<br />";
	}
	else {
		echo "Myclass is already off.<br />";
	}
	
	peb_close();
}

function stopsearch($username)
{
	set_time_limit(0);
	connect();

	$userarg = peb_encode("[~a]", array(array($username)));
	$x = rpc("search_stop", $userarg);
	if($x == "search_pstopped") {
		echo "The search has been prematurely stopped. No solution.<br />";
	}
	else if($x == "search_nstopped") {
		echo "The search has already finished. You may want to get the solutions now. <br />";
	}
	else if($x == "search_astopped") {
		echo "The search is already inactive. <br />";
	}
	else 
		die("myclass error: $x<br />");

	
	peb_close();
}

}
?>

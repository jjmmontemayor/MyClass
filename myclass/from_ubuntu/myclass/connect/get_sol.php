<?php

	set_time_limit(0);
	connect();

	$userarg = peb_encode("[~a]", array(array($_GET['username'])));
	$x = rpc("getsolution", $userarg);
	if($x == "solution_ready") {
		do {
			$y = rpc("getcomp", $userarg);
			if($y == "solution_done") {
				break;
			}
			else if($y[0] == "c") {
				// a course component: {"c",{C,T,L,F}}, $y = array("c", array(C, T, L, F))
				echo "course: {$y[1][0]} {$y[1][1]} {$y[1][2]} {$y[1][3]}<br />";
			}
			else if($y[0] == "fe") {
				// a faculty event component: {"fe",{Fe,T}}, $y = array("fe", array(Fe, T))
				echo "faculty event: {$y[1][0]} {$y[1][1]}<br />";
			}
			else if($y[0] == "qsf") {
				// the solution quality. this gets transmitted only once-- at the very beginning
				echo "solution quality: {$y[1]}<br /><br />";
			}
		}
		while(true);
	}
	else if($x == "search_active") {
		echo "Not ready. The ant search is still active. <br />";
	}
	else 
		die("myclass error: $x<br />");

	
	peb_close();
?>

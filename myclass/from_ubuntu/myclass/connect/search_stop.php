<?php

	set_time_limit(0);
	connect();

	$userarg = peb_encode("[~a]", array(array($_GET['username'])));
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
?>

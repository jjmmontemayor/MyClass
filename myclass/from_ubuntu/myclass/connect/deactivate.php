<?php

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
?>

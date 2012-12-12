<?php
	include_once("../includes/erlconnector.php");

	if(!$_GET) $_GET['ac'] = 'none';
	// $username should be a session variable $_SESSION['username'] or something
	$_GET['username'] = "Jenn";
	
?>
<html>
<head>
	<title>peb aco test</title>
</head>
<body>
	<a href="?ac=activate">activate myclass</a><br /><br />
	<a href="?ac=start">1. start aco</a><br />
	<a href="?ac=stop">2. stop aco</a><br />
	<a href="?ac=get_sol">3. get solution</a><br /><br />
	<a href="?ac=deactivate">deactivate myclass</a><br />
	<p>
		<?php
			if($_GET['ac'] == 'activate') {
				include("activate.php");
			}
			else if($_GET['ac'] == 'start') {
				include("search_start.php");
			}
			else if($_GET['ac'] == 'get_sol') {
				include("get_sol.php");
			}
			else if($_GET['ac'] == 'stop') {
				include("search_stop.php");
			}
			else if($_GET['ac'] == 'deactivate') {
				include("deactivate.php");
			}
		?>
	</p>
</body>
</html>

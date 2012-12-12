<?php
require_once 'functions.php';
$function = new Functions();

$id = $_POST['id'];

if($id)
{
	echo '<strong>Neighborhood Statistics</strong>';
	$function->getNeighborhoodStat($id);
}
else
{
	echo 'Call to Trulia Web Services failed: HTTP';
}


?>
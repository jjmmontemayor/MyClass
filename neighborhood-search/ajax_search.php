<?php
require_once 'functions.php';
$function = new Functions();

$zip = $_POST['zip'];
$city = $_POST['city'];
$state = $_POST['state'];

if($zip)
{
	echo '<strong>Zip Code Statistics</strong>';
	$function->getZipCode($zip);
}
else if($city && $state)
{
	echo '<strong>City Statistics</strong>';
	$function->getCityStats($city, $state);
	echo '<strong>List of Neighborhoods</strong>';
	$function->getNeighborhood($city, $state);	
}
else
{
	echo 'Call to Trulia Web Services failed: HTTP';
}
?>
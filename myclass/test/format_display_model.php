<?php
require 'dbconnector.php';

class Model  
{
	
function Model
{
	$dbconn = new dbConnector();	


}


function getByLocation()
{
	$querytimeslotdesc = "SELECT timeslot_desc FROM timeslots";
	$timeslotdesc = $dbconn->query($querytimeslotdesc);

	$querylocationdesc = "SELECT location_desc FROM locations";
	$locationdesc = $dbconn->query($querylocationdesc);

	return $locationdesc;
}

function getByFaculty()
{
	$queryfacultydesc = "SELECT faculty_desc FROM faculties";
	$facultydesc = $dbconn->query($queryfacultydesc);
	
	return $facultydesc

}

function display($el)
{
	echo $el + "();";
	
}

}
?>
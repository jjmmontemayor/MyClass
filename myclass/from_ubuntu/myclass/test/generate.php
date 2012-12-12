<?php
require 'dbconnector.php';

function getColleges()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM colleges";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{college, ".$result[0]."}, '".$result[1]."'}),"."<br/>";
		}
		$colleges = count($data);
		echo "ets:insert(A, {{college, size}, ".$colleges."}),"."<br/>";
	
	}
}

getColleges();

function getDepartments()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM departments";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{department, ".$result[0]."}, '".$result[1]."'}),"."<br/>";
		}
		$departments = count($data);
		echo "ets:insert(A, {{department, size}, ".$departments."}),"."<br/>";
	
	}
}

getDepartments();


function getTypes()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM types";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{type, ".$result[0]."}, '".$result[2]."'}),"."<br/>";
		}
		$types = count($data);
		echo "ets:insert(A, {{type, size}, ".$types."}),"."<br/>";
	
	}
}

getTypes();

function getItems()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM items";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{item, ".$result[0]."}, '".$result[2]."'}),"."<br/>";
		}
		$items = count($data);
		echo "ets:insert(A, {{item, size}, ".$items."}),"."<br/>";
	
	}
}

getItems();

function getScopes()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM scopes";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{scope, ".$result[0]."}, '".$result[1]."'}),"."<br/>";
		}
		$scopes = count($data);
		echo "ets:insert(A, {{scope, size}, ".$scopes."}),"."<br/>";
	
	}
}

getScopes();

function getDays()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM days";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{day, ".$result[0]."}, '".$result[1]."'}),"."<br/>";
		}
		$days = count($data);
		echo "ets:insert(A, {{day, size}, ".$days."}),"."<br/>";
	
	}
}

getDays();

function getTime()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM time";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(A, {{time, ".$result[0]."}, '".$result[1]."'}),"."<br/>";
		}
		$time = count($data);
		echo "ets:insert(A, {{time, size}, ".$time."}),"."<br/>";
	
	}
}

getTime();

function getCourses()
{
	$conn = new dbConnector();	
	$query = "SELECT k.courseid, c.collegeid, d.departmentid, s.subjectid, s.faculty_credits, s.typeid, k.course_capacity, s.room_options, s.room_items
	FROM colleges c, departments d, subjects s, courses k WHERE c.collegeid = s.collegeid AND d.departmentid = s.departmentid AND s.subjectid = k.course_subjectid";

	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(C, {".$result[0].",".$result[1].",".$result[2].", ".$result[3].",  ".$result[4].", [".$result[5]."], ".$result[6].", [".$result[7]."],  [".$result[8]."]}),"."<br/>";
		}
		
	
	}
}

getCourses();

function getLocations()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM locations";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(L, {".$result[0].", ".$result[2].", [".$result[3]."],   [".$result[5]."], ".$result[4].", [".$result[6]."]}),"."<br/>";
		}
		
	
	}
}

getLocations();


function getFaculties()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM faculties";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(F, {".$result[0].", ".$result[2].", ".$result[3].", [".$result[8]."],".$result[5].", ".$result[4].", 17, [".$result[6]."], [".$result[7]."]}),"."<br/>";
		}
		
	
	}
}

getFaculties();


function getTimeslots()
{
	$conn = new dbConnector();	
	$query = "SELECT * FROM timeslots";
	$row = $conn->query($query);
	
	if($row)
	{
		
		while ($result = $conn->fetch_row($row))
		{
			$data[] = $result;
			echo "ets:insert(T, {".$result[0].", [".$result[3]."],".$result[2].",  [".$result[4]."]}),"."<br/>";
		}
			
	}
}

getTimeslots();
?>

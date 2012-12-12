<?php

require_once ('../includes/dbconnector.php');


Class Login
{

function Login($username,$pwd)
{
	$this->username = $username;
	$this->pwd = $pwd;
}

function checkUser()
{
		$conn = new dbConnector();
		$insertQuery = "SELECT * FROM users WHERE username = '".$this->username."'";		
		$checkuser = $conn->query($insertQuery);		
		$row = pg_num_rows($checkuser); 
		if ( $row == 0)
		{
				return false;
		}
		else
		{
			$insertQuery = "SELECT * FROM users WHERE password = '".$this->pwd."'";
			$checkpassword = $conn->query($insertQuery);
			$row = pg_num_rows($checkpassword);
			if( $row == 0)
			{
				return false;
			}
			else 
			{
				return true;
			}
		}
}
function getUserid($username, $pwd)
{
	$conn = new dbConnector();
	$insertQuery = "(SELECT userid FROM users WHERE username = '".$username."' AND password = '".$pwd."')";
	$row =  $conn->query($insertQuery);
	$result = pg_fetch_row($row);
	return $result[0];
}


}
?>
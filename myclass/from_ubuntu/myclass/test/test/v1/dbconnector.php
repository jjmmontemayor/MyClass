<?php
require 'systemconfig.php';


class dbConnector extends SystemSettings 
{
	
	var $dbconn;
	var $dbquery;
	
function dbConnector() 
{
	$settings = SystemSettings::getSettings();
	
	$host = $settings['dbhost'];
	$port = $settings['port'];
	$db = $settings['dbname'];
	$user = $settings['dbusername'];
	$password = $settings['dbpassword'];
	
	$this->dbconn = pg_pconnect("host=".$host." port=".$port." dbname=".$db." user=".$user." password=".$password);
				
		if($this->dbconn)
			{
				return true;
			}
		else
			{
				die("Database error: Unable to connect to the pgsql database.");
			}
}

function query($query)
{
	$this->dbquery = $query;
	$result = pg_query($this->dbconn, $query);
	return $result;
}

function fetch_array($result)
{
	return pg_fetch_array($result);
}

function fetch_row($result)
{
	return pg_fetch_row($result);
}
function fetch_assoc($result)
{
	return pg_fetch_assoc($result);
}

function fetch_obj($result)
{
	return pg_fetch_object($result);
}

function row_count($result)
{
	return pg_num_rows($result);
}

function close()
{
	pg_close($this->dbconn);
}


}

?>
<?php
require 'systemconfig.php';


class dbConnector extends SystemSettings {
	
	var $dquery;
	var $link;
	
function dbConnector() {
	
	$settings = SystemSettings::getSettings();
	
	$host = $settings['dbhost'];
	$db = $settings['dbname'];
	$user = $settings['dbusername'];
	$password = $settings['dbpassword'];

	$this->link = mysql_connect($host, $user, $password);
	if(!$this->link){
		die('could not connect to:'.$db.mysql_error());
	}
	
	mysql_select_db($db);
	register_shutdown_function(array(&$this,'close'));
	
}

function query($query){

	$this->dquery = $query;
	return mysql_query($query, $this->link);
}

function fetchArray($result){
	return mysql_fetch_array($result);
}

function fetchRow($result){
	return mysql_fetch_row($result);
}


function close(){
	mysql_close($this->link);
}
} 



?>
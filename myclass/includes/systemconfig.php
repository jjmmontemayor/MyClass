<?php 

class SystemSettings 
{
	var $settings;
	
	function getSettings()
	{
		$settings['dbhost'] = 'localhost';
		$settings['port']='5432';
		$settings['dbusername'] = 'postgres';
		$settings['dbpassword'] = 'password123';
		$settings['dbname']='myclassc';
		
		
		return $settings;
	}
}
?>
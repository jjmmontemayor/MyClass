<?php 

class SystemSettings {

	var $settings;
	
	function getSettings()
	{
	
		$settings['siteName']="http://localhost/gw";
		$settings['dbhost'] = 'localhost';
		$settings['dbusername'] = 'root';
		$settings['dbpassword'] = '';
		$settings['dbname']='gw';
		
		return $settings;
	}



}

?>
<?php
require 'erlconnector.php';

set_time_limit(0);

$link = peb_connect("a@127.0.0.1","aaa");
$username = 'jenn';
if ($link)
{
	//echo "linked naaa!: ".$link."<br>\r\n";
	
	$x = peb_encode("{~a, ~a}", array(array($username,"connecting")));
	
	$y = peb_rpc('phero','getVal',peb_encode("[~a]",array('antref')),$link);
	$z = peb_decode($y);
	echo $z[0];
	//$erl = new erlConnector();
	//$result = $erl->receive($link);
	//print_r($result);
	//peb_send_byname("myclass",$x,$link);
}	
else
{

	echo "error:".peb_errorno()."<br>\r\nerror:".peb_error()."<br>\r\n";
	
}


?>

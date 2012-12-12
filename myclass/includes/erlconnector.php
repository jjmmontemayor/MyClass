<?php

class erlConnector()
{

function connect()
{
	$link = peb_pconnect('myclass@127.0.0.1',  'msu-iit');
	
	if (!$link) {
    		die('Could not connect: ' . peb_error());
	}
	return true;	
}

function send($pattern, $data) 
{
	$resource = peb_encode($pattern, $data);
	peb_send_byname("myclass", $resource);

	
}

function receive()
{
	$message = peb_receive();
	$result = peb_decode($message);
	return $result;
}

}
?>
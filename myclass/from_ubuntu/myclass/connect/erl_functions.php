<?php

class erl
{
	var $link;

function erl()
{
	$this->link = peb_connect("jenn@127.0.0.1","aaa");
	if ($this->link) {
		// sample only.
		// $link should be stored in a global variable
		// like $_SESSION['link'] or $this->link or something
		$_GET['peblink'] = $this->$link;
		return $this->link;
	}
	else die("error:".peb_errorno()."<br>\r\nerror:".peb_error()."<br>\r\n");
	
}

function close() {
	peb_close($_GET['peblink']);
	return true;
}

function rpc($fun, $args) {
	// $link should be from some global variable
	$this->link = $_GET['peblink'];
	
	$x = peb_rpc("myclass", $fun, $args, $link);
	$y = peb_decode($x);
	return $y[0];
}





}










?>
<?php
set_time_limit(0);

$link = peb_pconnect("a@127.0.0.1","aaa");
if ($link)
	echo "linked!:".$link."<br>\r\n";
else
	echo "error:".peb_errorno()."<br>\r\nerror:".peb_error()."<br>\r\n";
	
echo "<br>\r\n";
echo "<br>\r\n";

peb_status();
echo "<br>\r\n";
echo "<br>\r\n";

$x = peb_vencode("[~a,~a]", array(
								array( "hello", "friend" )
								)
			   );

echo "msg resource :".$x."\r\n";

echo "<br>\r\n";
echo "<br>\r\n";

peb_send_byname("myclass",$x,$link);
echo "<br>\r\n";
echo "<br>\r\n";

//peb_close($link);  You don't need to close pconnect :)

?>

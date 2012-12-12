<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Thesis</title>
<javascript>



<a position:absolute; href="" onclick="confirm('are you sure?');">STOP</a>
</head>
<body>

<div style="position:absolute;top:250px;left:450px;width:326px;color:#9E1D0B;text-align:center;">
<p><img src="../images/ring.gif"/></p>
<p><img src="../images/generating-data.jpg" /></p>
</div>
<?php
	
	include_once("../connect/activate.php");
	
	$myclass = new myClass();
	$username = "Jennifer";
	
	$myclass->activate();
	$myclass->start($username);
	
	
?>
<img style="position:absolute;top:400px; left: 530px;" src="../images/powered-by.jpg" />

</body>
</html>

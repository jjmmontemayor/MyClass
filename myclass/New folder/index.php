<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>  
    <title>MyClass Beta | MSU - IIT Faculty Workload Scheduler</title>  
    <link rel="stylesheet" href="css/styles.css" type="text/css" />
	<link rel="shortcut icon" href="images/favicon.ico" />
  	<script type="text/javascript">
function checkform(){
	var pass = document.getElementById('password').value;
	var user = document.getElementById('username').value;
	
	if(user == "" || pass == "" ){
		document.getElementById('error').innerHTML = "Please provide necessary fields";
		return false;
	}
}
</script>
</head>  
<body>  
	<div id="container">  
		<div id="header">
			MINDANAO STATE UNIVERSITY - ILIGAN INSTITUTE OF TECHNOLOGY
		</div> <!--end header--> 
		<div class="mainContent">
			<div id="tier1">
				<div id="myclassPic">
					<p><img src="images/myclass.jpg" alt="MyClass Beta"></p>
				</div>
				<form method="post" action="controller/login.php" onsubmit="return checkform();">
				<div id="login" class="gradientV">
					<p>USERNAME: <input type="text" id="username" name="username" size="60"/></p>
					<p>PASSWORD: <input type="password" id="password" name="password" size="60"/></p>
					<span><input type="checkbox" name="forgotPassword" /> Forgot Password?<span><br />
					<button>LOG IN</button><span id="error" style="color:red;"><?php if(isset($_GET['error'])) echo $_GET['error'];?></span>
				</div><!---end login-->
				</form>
			</div><!--end of tier1-->
		</div> <!--main content-->
	</div><!--end container-->  
	<div id="footer">  
			<a href="about.html">THE DEVELOPERS</a> | <a href="http://msuiit.edu.ph">MSUIIT.EDU.PH</a> | <a href="http://my.iit.edu.ph" >MY.IIT</a>
			<br />
			<span><small>COPYRIGHT</small> 2010</span>
	</div><!--end of footer-->
</body>
</html>
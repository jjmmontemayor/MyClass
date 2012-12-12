<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>  

<title>MyClass Beta | MSU - IIT Faculty Workload and Class Assignment System</title>  
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

<div id="wrap">  
	<!-- header --> 
	<div id="header">
			MINDANAO STATE UNIVERSITY - ILIGAN INSTITUTE OF TECHNOLOGY
	</div> 
	<!--end header--> 
	
	<!-- content wrap-->
	<div class="content-wrap">
		<div id="content">
			<div id="myclass-image">
				<p><img src="images/myclass.jpg" alt="MyClass Beta"></p>
			</div>
			<form method="post" action="controller/login.php" onsubmit="return checkform();">
			<div id="login" class="gradientV">
				<p>USERNAME: <input type="text" id="username" name="username" style="width:100%"/></p>
				<p>PASSWORD: <input type="password" id="password" name="password" style="width:100%"/></p>
				<span><input type="checkbox" name="forgotPassword" /> Forgot Password?<span><br />
				<button>LOG IN</button><span id="error" style="color:red;"><?php if(isset($_GET['error'])) echo $_GET['error'];?></span>
			</div>
			</form>
		</div>
	</div> 
	<!--end content-wrap -->
</div>  
<!-- end wrap -->

<!-- footer -->
<div id="footer">  
			<hr>
			<div class="float-right">
			<a href="about.html">THE DEVELOPERS</a> | <a href="http://msuiit.edu.ph" target="_blank">MSUIIT.EDU.PH</a> | <a href="http://my.iit.edu.ph" target="_blank">MY.IIT</a>
			</div>
			<div class="float-left">
			<span>MyClass Beta || MSU-IIT Faculty Workload and Class Assignment System &copy; 2010</span>
			</div>
</div>
<!--end of footer-->

</body>
</html>

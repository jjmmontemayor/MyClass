<html>
<head>
<title>Global Workforce Test</title>

<style>
body {width: 100%;font:bold 13px 'Arial','Helvetica',sans-serif;color: #ABABAB;}
#content-wrapper{ margin: 20px auto;width: 800px;border-top: 1px dotted #cccccc;border-bottom: 1px dotted #cccccc;}
#content-wrapper label {margin: 15px 10px 0 0}
#content-wrapper input {border: 2px solid #DADADA; text-align:left;padding:11px 7px;width:400px;}
.error {color: #F96464;clear:both;font-size:11px;margin:0 0 0 100px;padding:4px 0 0 0px;display:none;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

function getBaseUrl(url)
{
	var split_url = url.split('/');
	var length = split_url.length;
	var base_url = split_url[2];
	
	var split_base_url = base_url.split('.');
	var base_length = split_base_url.length;
	if(base_length == 4)
	{
		var new_url = split_base_url.slice(1, (base_length));
		var final_url = new_url.join('.');
		return final_url;
	}	
	else if (base_length == 3)
	{
		var new_url = split_base_url.slice(0, (base_length));
		var final_url = new_url.join('.');
		return final_url;
	}
}


function checkUrl() 
{
	var url = $('#url').val();
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	if(regexp.test(url))
	{
		var base_url = getBaseUrl(url);
		addUrl(base_url);	
	}
	else
	{
		alert('invalid url format');
	}
}

function addUrl(url)
{
	$.ajax({
		type 		: 'POST',
		url			: 'add-url.php', 
		data		: { 
						url : url
					  },
		dataType 	: 'html',
		success		: function(data){
							
								$('#url-list').fadeIn(400).html(data);
										
					  }
	});

}

</script>


</head>
<body>

<div id="content-wrapper">
<form id="form" method="post" onsubmit="checkUrl();">
<p><label>Website URL</label><input type="text" name="url" id="url" /><br/><span class="error">Please Enter URL of Website</span></p>
</form>
<div id="url-list">
<?php 
	include 'functions.php';
	$func = new Functions;
	$func->showTable();

?>
</div>
</div>




</body>
</html>
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

function checkUrl() {

	var url = $('#url').val();
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	if(regexp.test(url) && isBaseUrl(url))
	{
		var get_base_url = getBaseUrl(url);
		var clean_base_url = trimUrl(get_base_url);
		
		addUrl(clean_base_url);
	
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
		url		: 'add-url.php', 
		data		: { 
							url : url
						},
		dataType : "json",
		success	:	function(data){
							if(data.success)
							{
								$('#url-list').fadeIn(400).html('<p>hellloooooooo</p>');
																
							}
							else
							{
								$('#url-list').fadeIn(400).html('<p>goodbyeeee</p>');
							}
							
						}
	});

}

function isBaseUrl(url)
{
	var split_url = url.split('/');
	var length = split_url.length;
	
	if(length<=3)
	{
		return true;
	}
	
}

function getBaseUrl(url)
{
	var split_url = url.split('/');
	var length = split_url.length;
	var base_url = split_url[2];
	
	return base_url;
}

function trimUrl(url)
{
	var trim_url = url.split('.');
	var length = trim_url.length;
	if(length<=3)
	{
		var new_url = trim_url[1] + "." + trim_url[2];
		return new_url;
	}
}



</script>


</head>
<body>

<div id="content-wrapper">
<form id="form" method="post" onsubmit="checkUrl();">
<p><label>Website URL</label><input type="text" name="url" id="url" /><br/><span class="error">Please Enter URL of Website</span></p>
</form>
<div id="url-list"></div>
</div>




</body>
</html>
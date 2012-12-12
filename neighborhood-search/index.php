<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>Test</title>
<link type="text/css" media="all" rel="stylesheet" href="css/style.css">
<script src="http://code.jquery.com/jquery-1.4.4.js"></script>
<script type="text/javascript">

function isNumeric(elem){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		return false;
	}
}

function isAlphabet(elem){
	var alphaExp = /^[a-zA-Z ]+$/;
	if(elem.value.match(alphaExp))
	{
		return true;
	}else
	{
		return false;
	}
}

function check()
{
	var zip = document.getElementById('zip-value').value;
	var city = document.getElementById('city-value').value;
	var state = document.getElementById('state-value').value;
	
	
	if((zip != "" && (city == "" && state == "0"))  )
	{
		var zipLength = zip.length;
		if( (zipLength == 5) && (isNumeric(document.getElementById('zip-value'))))
		{
			return true;
		}
		else
		{
			
			alert('Please Provide A Valid Zip Code Value');
			return false;
		}
	}
	else if((zip == "" && (city != "" && state != "0"))  )
	{
		if(isAlphabet(document.getElementById('city-value')))
		{
			return true;
		}
		else
		{
			alert('Please Provide a Valid City Address');
			return false;
		}
	}
	else
	{
		
		alert('Please Choose Between the Forms and Fill Up Necessary Fields');
		return false;
	}
}

function showResults()
{
	var zip = document.getElementById('zip-value').value;
	var city = document.getElementById('city-value').value;
	var state = document.getElementById('state-value').value;

	if(check())
	{
		if(zip)
		{
			$.post("ajax_search.php", { zip: zip },
					function(data){
						$('#results').html(data);
						if ($('#results').is(":hidden")) 
						{
							$('#results').slideDown("slow");
						} else 
						{
							$("#results").hide();
						}
					});
		
		}
		else
		{
			$.post("ajax_search.php", { city: city, state: state },
					function(data){
						$('#results').html(data);
						if ($('#results').is(":hidden")) 
						{
							$('#results').slideDown("slow");
						} else 
						{
							$("#results").hide();
						}
					});
		}
}
}
function searchNeighborhood(id)
{
	$.post("neighborhood_search.php", { id: id},
					function(data){
						$('#results').html(data);
						
					});
}


</script>
</head>
<div id="content-wrapper">
	<div id="content">
		<div class="header"><p><img src="images/home.png" width="40" height="40" /><span class="f25 brown">FindAHome.com</span></p></div>
		<div id="results" style="display:none;overflow:scroll;height:300px;"></div>
		<div class="form-wrap">
			<form id="form">
				<div class="form zip f25 pad10"><p><label id="zip-code">Zip Code</label><input type="text" name="zip-value" id="zip-value"/></p></div>
				<span id="or">OR</span>
				<div class="form city-state f25 pad10">
					<p><label id="city">City</label><input type="text" name="city-value" id="city-value"/></p><br/>
					<p><label id="state">State</label>
					<select name="state-value" id="state-value">
					<option value="0">Select State</option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
					</select>
					</p>
				</div>
				<div class="submit"><img onclick="showResults();" src="images/submit.png"  style="cursor:pointer"></div>
			</form>
		</div>
	</div>
</div>
</html>


<?php
class Functions
{
function getZipCode($zipcode) 
{ 
    // Setup query string 
    $apikey = '2yr3wykzk9dtesbv8wbdvnj4'; 
    //$endDate = date('Y-m-d'); 
    $endDate = '2011-02-03'; 
	$startDate = '2009-02-06'; 
    $call_string = 'http://api.trulia.com/webservices.php?library=TruliaStats&function=getZipCodeStats'; 
    $call_string .= '&zipCode='.$zipcode; 
    $call_string .= '&startDate='.$startDate.'&endDate='.$endDate; 
    $call_string .= '&apikey='.$apikey; 
     
    // Make the request 
    $response = file_get_contents($call_string); 

    // Retrieve HTTP status code 
    list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3); 

    // Check the HTTP Status code 
    if($status_code != 200)  
    { 
        die('Your call to Trulia Web Services failed: HTTP status of:' . $status_code); 
    } 

    // Create a new DOM object 
    $dom = new DOMDocument('1.0', 'UTF-8'); 

    // Load the XML into the DOM 
    if ($dom->loadXML($response) === false)  
    { 
        die('XML Parsing failed'); 
    } 

    // Get the first searchResultsURL XML node 
    $searchResultsURL = $dom->getElementsByTagName('searchResultsURL')->item(0); 


    // Create Table
    echo '<table style="border: solid 1px #efc3a4;text-align:center;" width="400" scellspacing=0>'; 
    echo '<tr><td class="center">Week Ending Date'; 
    echo '</td><td class="center">Number Of Properties'; 
    echo '</td><td class="center">Median Listing Price'; 
    echo '</td><td>';

    // Get the parent Node
    $listingStats = $dom->getElementsByTagName('listingStats')->item(0); 
    $listingStat = $listingStats->firstChild; 

    // Populate Table 
    while($listingStat)  
    { 
        $i++; 
        $weekEndingDate =  $listingStat->getElementsByTagName('weekEndingDate')->item(0); 
        $subcategory = $listingStat->getElementsByTagName('subcategory')->item(0); 
        $medianListingPrice = $subcategory->getElementsByTagName('medianListingPrice')->item(0); 
        $numberOfProperties =  $subcategory->getElementsByTagName('numberOfProperties')->item(0); 
      
	//odd/even for table design
	  if (($i % 2) == 1)  
        { 
            echo '<tr bgcolor=#efc3a4><td class="center">'; 
        } 
        else 
        { 
            echo '<tr><td class="center">'; 
       
}
        print_r($weekEndingDate->nodeValue); 
        echo '</td><td class="center">'; 
        print_r(number_format($numberOfProperties->nodeValue)); 
        echo '</td><td class="center">$'; 
        print_r(number_format($medianListingPrice->nodeValue)); 
        echo '</td></tr>'; 

        $listingStat = $listingStat->nextSibling; 
    } 

    echo '</table><br>'; 
 
 
} 

function getCityStats($city, $state) 
{ 
    // Setup query string 
    $apikey = '2yr3wykzk9dtesbv8wbdvnj4'; 
    //$endDate = date('Y-m-d'); 
    $endDate = '2011-02-03'; 
	$startDate = '2009-02-06'; 
    $call_string = 'http://api.trulia.com/webservices.php?library=TruliaStats&function=getCityStats'; 
    $call_string .= '&city='.urlencode($city); 
	$call_string .= '&state='.$state; 
    $call_string .= '&startDate='.$startDate.'&endDate='.$endDate; 
    $call_string .= '&apikey='.$apikey; 
    


    // Make the request 
    $response = file_get_contents($call_string); 

    // Retrieve HTTP status code 
    list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3); 

    // Check the HTTP Status code 
    if($status_code != 200)  
    { 
        die('Your call to Trulia Web Services failed: HTTP status of:' . $status_code); 
    } 

    // Create a new DOM object 
    $dom = new DOMDocument('1.0', 'UTF-8'); 

    // Load the XML into the DOM 
    if ($dom->loadXML($response) === false)  
    { 
        die('XML Parsing failed'); 
    } 

    // Get the first searchResultsURL XML node 
    $searchResultsURL = $dom->getElementsByTagName('searchResultsURL')->item(0); 


    // Create Table
    echo '<table style="border: solid 1px #efc3a4;text-align:center;" width="400" scellspacing=0>'; 
    echo '<tr><td class="center">Week Ending Date'; 
    echo '</td><td class="center">Number Of Properties'; 
    echo '</td><td class="center">Median Listing Price'; 
    echo '</td><td>';

    // Get the Parent Node
    $listingStats = $dom->getElementsByTagName('listingStats')->item(0); 
    $listingStat = $listingStats->firstChild; 

    // Populate Table
    while($listingStat)  
    { 
        $i++; 
        $weekEndingDate =  $listingStat->getElementsByTagName('weekEndingDate')->item(0); 
        $subcategory = $listingStat->getElementsByTagName('subcategory')->item(0); 
        $medianListingPrice = $subcategory->getElementsByTagName('medianListingPrice')->item(0); 
        $numberOfProperties =  $subcategory->getElementsByTagName('numberOfProperties')->item(0); 
       
	   //odd/even for table design
	   if (($i % 2) == 1)  
        { 
            echo '<tr bgcolor=#efc3a4><td class="center">'; 
        } 
        else 
        { 
            echo '<tr><td class="center">'; 
       
		}
        print_r($weekEndingDate->nodeValue); 
        echo '</td><td class="center">'; 
        print_r(number_format($numberOfProperties->nodeValue)); 
        echo '</td><td class="center">$'; 
        print_r(number_format($medianListingPrice->nodeValue)); 
        echo '</td></tr>'; 

        $listingStat = $listingStat->nextSibling; 
    } 

   
    echo '</table><br>'; 
 
 
}
function getNeighborhood($city, $state) 
{ 
    // Setup query string 
    $apikey = '2yr3wykzk9dtesbv8wbdvnj4'; 
    $call_string = 'http://api.trulia.com/webservices.php?library=LocationInfo&function=getNeighborhoodsInCity'; 
    $call_string .= '&city='.urlencode($city); 
	$call_string .= '&state='.$state; 
    $call_string .= '&apikey='.$apikey; 
    
    // Make the request 
    $response = file_get_contents($call_string); 

    // Retrieve HTTP status code 
    list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3); 

    // Check the HTTP Status code 
    if($status_code != 200)  
    { 
        die('Your call to Trulia Web Services failed: HTTP status of:' . $status_code); 
    } 

    // Create a new DOM object 
    $dom = new DOMDocument('1.0', 'UTF-8'); 

    // Load the XML into the DOM 
    if ($dom->loadXML($response) === false)  
    { 
        die('XML Parsing failed'); 
    } 

  
    // Create Table
    echo '<table style="border: solid 1px #efc3a4;text-align:center;" width="400" scellspacing=0>'; 
    echo '<tr><td class="center">ID'; 
    echo '</td><td class="center">Name'; 
    echo '</td><td>';

    // Get the Parent Node
  
    $LocationInfo = $dom->getElementsByTagName('LocationInfo')->item(0);
    $neighborhood = $LocationInfo->getElementsByTagName('neighborhood')->item(0); 
	
	while($neighborhood)  
    { 
        $i++; 
        $id = $neighborhood->getElementsByTagName('id')->item(0); 
        $name =  $neighborhood->getElementsByTagName('name')->item(0); 
       
	   
	   if (($i % 2) == 1)  
        { 
            echo '<tr bgcolor=#efc3a4><td class="center">'; 
        } 
        else 
        { 
            echo '<tr><td class="center">'; 
       
		}
        print_r($id->nodeValue); 
        echo '</td><td class="center"><a href="javascript:searchNeighborhood(\''.$id->nodeValue.'\')">'; 
		print_r($name->nodeValue); 
        echo '</a></td></tr>'; 

        $neighborhood = $neighborhood->nextSibling; 
    } 
    echo '</table><br>'; 
}

function getNeighborhoodStat($id)
{
	// Setup query string 
    $apikey = '2yr3wykzk9dtesbv8wbdvnj4'; 
    //$endDate = date('Y-m-d'); 
    $endDate = '2011-02-03'; 
	$startDate = '2009-02-06'; 
    $call_string = 'http://api.trulia.com/webservices.php?library=TruliaStats&function=getNeighborhoodStats'; 
    $call_string .= '&neighborhoodId='.$id; 
    $call_string .= '&startDate='.$startDate.'&endDate='.$endDate; 
    $call_string .= '&apikey='.$apikey; 
    
    // Make the request 
    $response = file_get_contents($call_string); 

    // Retrieve HTTP status code 
    list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3); 

    // Check the HTTP Status code 
    if($status_code != 200)  
    { 
        die('Your call to Trulia Web Services failed: HTTP status of:' . $status_code); 
    } 

    // Create a new DOM object 
    $dom = new DOMDocument('1.0', 'UTF-8'); 

    // Load the XML into the DOM 
    if ($dom->loadXML($response) === false)  
    { 
        die('XML Parsing failed'); 
    } 

    // Get the first searchResultsURL XML node 
    $searchResultsURL = $dom->getElementsByTagName('searchResultsURL')->item(0); 


    // Create Table
    echo '<table style="border: solid 1px #efc3a4;text-align:center;" width="400" scellspacing=0>'; 
    echo '<tr><td class="center">Week Ending Date'; 
    echo '</td><td class="center">Number Of Properties'; 
    echo '</td><td class="center">Median Listing Price'; 
    echo '</td><td>';

    // Get Parent Node
    $listingStats = $dom->getElementsByTagName('listingStats')->item(0); 
    $listingStat = $listingStats->firstChild; 

    // Populate Table
    while($listingStat)  
    { 
        $i++; 
        $weekEndingDate =  $listingStat->getElementsByTagName('weekEndingDate')->item(0); 
        $subcategory = $listingStat->getElementsByTagName('subcategory')->item(0); 
        $medianListingPrice = $subcategory->getElementsByTagName('medianListingPrice')->item(0); 
        $numberOfProperties =  $subcategory->getElementsByTagName('numberOfProperties')->item(0); 
		
		//odd/even for table design
		   if (($i % 2) == 1)  
			{ 
				echo '<tr bgcolor=#efc3a4><td class="center">'; 
			} 
			else 
			{ 
				echo '<tr><td class="center">'; 
		   
			}
        
		print_r($weekEndingDate->nodeValue); 
        echo '</td><td class="center">'; 
        print_r(number_format($numberOfProperties->nodeValue)); 
        echo '</td><td class="center">$'; 
        print_r(number_format($medianListingPrice->nodeValue)); 
        echo '</td></tr>'; 

        $listingStat = $listingStat->nextSibling; 
    } 

    echo '</table><br>'; 

}
}


?>
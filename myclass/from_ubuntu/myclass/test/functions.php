<?php
require 'dbconnector.php';
require 'functions.php';

class Functions
{



function sort_array($array)
{
	$length = count($array);
	//echo $length;
	for($x = 0; $x <$length; $x++) 
	{
		for($y = $x+1; $y < $length; $y++) 
		{
			if($array[$x][0] > $array[$y][0]) 
		 	{
			  	$hold = $array[$x];  	
			  	$array[$x] = $array[$y];
			  	$array[$y] = $hold;			  
			}
		}
	}
	return $array;	
}
}

?>

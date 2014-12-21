<?php

$input = "hi 1.2.";

$integer = "/^[-+]?[0-9]+$/";
$float = "/^[-+]?[0-9]?+[.,][0-9]+$/";
$array = "/^\[.+\]$/";
 
$integerLast = "/^[-+]?[0-9]+\.?$/";
$floatLast = "/^[-+]?[0-9]?+[.,][0-9]+\.?$/";
$arrayLast = "/^\[.+\]\.?$/";
 
$res = array(
	'string'	=>	0,
	'integer'	=> 	0,
	'array'		=>	0,
	'float'		=> 	0
);
 
$words = explode(' ', $input);
 
if ($words[count($words) - 1] == '') {
	array_pop($words);
}
 
for ($i = 0; $i < count($words); $i++) {
 
	if ($i == count($words) - 1 ) {
	
		do {
		
			if (preg_match($arrayLast, $words[$i])) {
				$res['array']++;
				break;
			}
 
			if (preg_match($floatLast, $words[$i])) {
				$res['float']++;
				break;
			}
 
 
			if (preg_match($integerLast, $words[$i])) {
				$res['integer']++;
				break;
			}
 
			$res['string']++;
			break;
 
		} while(0);
	
	} else {
 
		do {
		
			if (preg_match($array, $words[$i])) {
				$res['array']++;
				break;
			}
 
			if (preg_match($float, $words[$i])) {
				$res['float']++;
				break;
			}
 
 
			if (preg_match($integer, $words[$i])) {
				$res['integer']++;
				break;
			}
 
			$res['string']++;
			break;
 
		} while(0);
		
	}
}
 
printf("Found %d arrays, %d strings, %d integer numbers and %d floating-point numbers.",
	$res['array'], $res['string'], $res['integer'], $res['float']);
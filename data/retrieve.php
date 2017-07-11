<?php

$assoc = [
	'audio' 	   => 'https://mainproject-c2cfb.firebaseio.com/audio.json',
	'heartBeat'    => 'https://mainproject-c2cfb.firebaseio.com/heartBeat.json',
	'humidity'	   => 'https://mainproject-c2cfb.firebaseio.com/humidity.json',
	'lightIntensity'  => 'https://mainproject-c2cfb.firebaseio.com/lightIntensity.json',
    'temperature'  => 'https://mainproject-c2cfb.firebaseio.com/temperature.json',
];

if (!empty($_GET['choice'])) {
	$selected = $_GET['choice'];
	if (array_key_exists($selected, $assoc)) {
		$url = $assoc[$selected];
		echo $url;
		$value = trim(file_get_contents($url));
		//echo $value . $assoc[$selected][1];
	}
} else {
	echo 'Error';
}